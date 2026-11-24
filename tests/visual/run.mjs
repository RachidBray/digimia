#!/usr/bin/env node
/**
 * Visual regression check for the Digimia store pages.
 *
 * Opens every page in tests/visual/pages.mjs in headless Chrome, in light and
 * dark mode at desktop and phone width, and:
 * - fails on an HTTP error, a PHP warning or fatal error in the page, a
 *   JavaScript error from the site itself, horizontal scrolling, or a missing
 *   expected element;
 * - saves a full-page screenshot and compares it with the baseline, listing
 *   what changed with a diff image.
 *
 * Usage:
 *   yarn test:visual                    check against the baseline
 *   yarn test:visual --update-baseline  save this run as the new baseline
 *   yarn test:visual --only=checkout,account
 *   yarn test:visual --baseline=rtl     compare with a second baseline (e.g. an Arabic site)
 *
 * Settings come from the environment or `.env` (never printed):
 *   WP_API_URL               site URL (default https://edd.local)
 *   VISUAL_TEST_USERNAME     test customer for signed-in pages
 *   VISUAL_TEST_PASSWORD
 *   VISUAL_TEST_COOKIE       or an auth cookie `name=value` instead
 *   CHROME_PATH             Chrome or Chromium binary, if not in a default place
 *
 * Node 22+, no dependencies: Chrome is driven over the DevTools protocol, and
 * images are compared in a page canvas.
 *
 * See docs/developer/visual-regression.md.
 */
import { spawn } from 'node:child_process';
import fs from 'node:fs';
import os from 'node:os';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

import config from './pages.mjs';

const dir = path.dirname( fileURLToPath( import.meta.url ) );
const root = path.resolve( dir, '../..' );
const outDir = path.join( dir, 'output' );
const sleep = ( ms ) => new Promise( ( resolve ) => setTimeout( resolve, ms ) );

/* Settings
------------------------------------------------------------------------ */

function readEnv() {
	const env = {};
	const file = path.join( root, '.env' );

	if ( fs.existsSync( file ) ) {
		for ( const line of fs.readFileSync( file, 'utf8' ).split( '\n' ) ) {
			const match = line.match( /^\s*([A-Z0-9_]+)\s*=\s*(.*?)\s*$/ );
			if ( match ) {
				env[ match[ 1 ] ] = match[ 2 ].replace( /^(['"])(.*)\1$/, '$2' );
			}
		}
	}

	return { ...env, ...process.env };
}

const env = readEnv();
const args = process.argv.slice( 2 );
const updateBaseline = args.includes( '--update-baseline' );
const only = ( args.find( ( a ) => a.startsWith( '--only=' ) ) || '' ).slice( 7 ).split( ',' ).filter( Boolean );
// A second set of screenshots, e.g. `--baseline=rtl` for an Arabic site,
// kept apart so it never replaces the main baseline.
const baselineName = ( args.find( ( a ) => a.startsWith( '--baseline=' ) ) || '' ).slice( 11 ).replace( /[^a-z0-9-]/gi, '' );
const baselineDir = path.join( dir, baselineName ? `baseline-${ baselineName }` : 'baseline' );
const baseUrl = ( env.WP_API_URL || 'https://edd.local' ).replace( /\/$/, '' );
const host = new URL( baseUrl ).hostname;

/* Chrome
------------------------------------------------------------------------ */

function chromePath() {
	const candidates = [
		env.CHROME_PATH,
		'/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',
		'/Applications/Chromium.app/Contents/MacOS/Chromium',
		'/usr/bin/google-chrome',
		'/usr/bin/chromium',
		'/usr/bin/chromium-browser',
	];
	const found = candidates.find( ( p ) => p && fs.existsSync( p ) );

	if ( ! found ) {
		throw new Error( 'Chrome not found. Set CHROME_PATH.' );
	}

	return found;
}

async function launchChrome() {
	const profile = fs.mkdtempSync( path.join( os.tmpdir(), 'digimia-visual-' ) );
	const flags = [
		'--headless=new',
		'--remote-debugging-port=0',
		`--user-data-dir=${ profile }`,
		'--no-first-run',
		'--no-default-browser-check',
		'--hide-scrollbars',
		'--disable-gpu',
		'--font-render-hinting=none',
	];

	// LocalWP certificates are self-signed. TLS checks stay on for any other host.
	if ( host.endsWith( '.local' ) ) {
		flags.push( '--ignore-certificate-errors' );
	}

	const proc = spawn( chromePath(), [ ...flags, 'about:blank' ], { stdio: 'ignore' } );
	const portFile = path.join( profile, 'DevToolsActivePort' );

	for ( let i = 0; i < 100 && ! fs.existsSync( portFile ); i++ ) {
		await sleep( 100 );
	}

	const port = fs.readFileSync( portFile, 'utf8' ).split( '\n' )[ 0 ];

	return {
		port,
		async close() {
			const exited = new Promise( ( resolve ) => proc.once( 'exit', resolve ) );
			proc.kill();
			await Promise.race( [ exited, sleep( 5000 ) ] );
			// Chrome's helper processes can still be writing to the profile; a
			// leftover folder in the system temp directory is harmless.
			try {
				fs.rmSync( profile, { recursive: true, force: true, maxRetries: 5, retryDelay: 200 } );
			} catch {}
		},
	};
}

async function openPage( port ) {
	const target = await ( await fetch( `http://127.0.0.1:${ port }/json/new?about:blank`, { method: 'PUT' } ) ).json();
	const ws = new WebSocket( target.webSocketDebuggerUrl );
	const pending = new Map();
	const listeners = [];
	let id = 0;

	ws.onmessage = ( event ) => {
		const message = JSON.parse( event.data );
		if ( message.id && pending.has( message.id ) ) {
			pending.get( message.id )( message );
			pending.delete( message.id );
		} else if ( message.method ) {
			listeners.forEach( ( listener ) => listener( message ) );
		}
	};
	await new Promise( ( resolve ) => ( ws.onopen = resolve ) );

	const send = ( method, params = {} ) =>
		new Promise( ( resolve, reject ) => {
			const callId = ++id;
			pending.set( callId, ( message ) => ( message.error ? reject( new Error( `${ method }: ${ message.error.message }` ) ) : resolve( message.result ) ) );
			ws.send( JSON.stringify( { id: callId, method, params } ) );
		} );

	const evaluate = async ( expression ) => {
		const result = await send( 'Runtime.evaluate', { expression, awaitPromise: true, returnByValue: true } );
		if ( result.exceptionDetails ) {
			throw new Error( result.exceptionDetails.exception?.description || result.exceptionDetails.text );
		}
		return result.result.value;
	};

	const loaded = () =>
		new Promise( ( resolve ) => {
			const timer = setTimeout( done, 20000 );
			function done() {
				clearTimeout( timer );
				listeners.splice( listeners.indexOf( onEvent ), 1 );
				resolve();
			}
			function onEvent( message ) {
				if ( message.method === 'Page.loadEventFired' ) {
					done();
				}
			}
			listeners.push( onEvent );
		} );

	const go = async ( url ) => {
		const ready = loaded();
		await send( 'Page.navigate', { url } );
		await ready;
	};

	await send( 'Page.enable' );
	await send( 'Runtime.enable' );
	await send( 'Network.enable' );
	await send( 'Network.setCacheDisabled', { cacheDisabled: true } );

	return { send, evaluate, go, listeners, close: () => ws.close() };
}

/* Page checks
------------------------------------------------------------------------ */

const STABILIZE = `(() => {
	const style = document.createElement('style');
	style.textContent = '*, *::before, *::after { animation: none !important; transition: none !important; caret-color: transparent !important; scroll-behavior: auto !important; }';
	document.head.append(style);
})()`;

const IMAGES_READY = `(async () => {
	document.querySelectorAll('img[loading="lazy"]').forEach((img) => {
		if (/^\\s*auto/.test(img.getAttribute('sizes') || '')) {
			img.sizes = Math.max(1, Math.ceil(img.getBoundingClientRect().width)) + 'px';
		}
		img.loading = 'eager';
	});
	const start = Date.now();
	const pending = () => [...document.images].filter((img) => img.getAttribute('src') && img.getClientRects().length && !(img.complete && img.naturalWidth));
	while (pending().length && Date.now() - start < 10000) {
		await new Promise((r) => setTimeout(r, 100));
	}
	await Promise.all([...document.images].map((img) => img.decode().catch(() => {})));
})()`;

async function setViewport( page, width, scheme ) {
	await page.send( 'Emulation.setDeviceMetricsOverride', { width, height: 900, deviceScaleFactor: 1, mobile: width < 600 } );
	await page.send( 'Emulation.setEmulatedMedia', { features: [ { name: 'prefers-color-scheme', value: scheme } ] } );
}

async function checkPage( page, spec, width, scheme ) {
	const problems = [];
	const jsErrors = [];
	const inflight = new Set();
	let lastActivity = Date.now();
	const networkIdle = async () => {
		const start = Date.now();
		while ( Date.now() - start < 10000 && ( inflight.size || Date.now() - lastActivity < 500 ) ) {
			await sleep( 100 );
		}
	};
	const onEvent = ( message ) => {
		if ( message.method === 'Network.requestWillBeSent' ) {
			inflight.add( message.params.requestId );
			lastActivity = Date.now();
		} else if ( message.method === 'Network.loadingFinished' || message.method === 'Network.loadingFailed' ) {
			inflight.delete( message.params.requestId );
			lastActivity = Date.now();
		} else if ( message.method === 'Runtime.exceptionThrown' ) {
			const details = message.params.exceptionDetails;
			const source = details.url || details.stackTrace?.callFrames?.[ 0 ]?.url || '';
			// Only the site's own scripts; payment provider frames are not ours to fix.
			if ( ! source || source.includes( host ) ) {
				jsErrors.push( ( details.exception?.description || details.text ).split( '\n' )[ 0 ] );
			}
		}
	};

	page.listeners.push( onEvent );
	await setViewport( page, width, scheme );

	for ( const before of spec.before || [] ) {
		await page.go( baseUrl + ( await resolvePath( page, before ) ) );
	}

	await page.go( baseUrl + ( await resolvePath( page, spec.path ) ) );

	// Reach pages whose URL holds an order or license ID by clicking through.
	for ( const selector of spec.follow || [] ) {
		const href = await page.evaluate( `document.querySelector(${ JSON.stringify( selector ) })?.href.split('#')[0] || ''` );
		if ( ! href ) {
			throw new Error( `no link matches ${ selector }` );
		}
		// Store action links (deactivate a site, cancel a subscription) change
		// the customer's data; a test only ever views pages.
		if ( /[?&](edd_action|edd-action)=|action=(deactivate|cancel|delete)/.test( href ) ) {
			throw new Error( `${ selector } matches an action link, not a page: ${ href }` );
		}
		await page.go( href );
	}
	await page.evaluate( `document.documentElement.setAttribute('data-theme', '${ scheme }')` );
	await page.evaluate( STABILIZE );
	await page.evaluate( 'document.fonts.ready.then(() => true)' );

	// Load every image now and wait until each has its pixels: a late image
	// must never show up as a change. Lazy images become eager; WordPress
	// gives them `sizes="auto"`, which only works while lazy, so it is
	// replaced with the image's laid-out width first (the same file the
	// browser would pick). `complete` is true for a lazy image that has not
	// even started, so the wait checks `naturalWidth` instead.
	await page.evaluate( IMAGES_READY );
	await networkIdle();

	const facts = await page.evaluate( `(() => {
		const nav = performance.getEntriesByType('navigation')[0];
		const html = document.body ? document.body.innerHTML : '';
		const php = html.match(/<b>(Warning|Notice|Deprecated|Fatal error|Parse error)<\\/b>:[^<]{0,160}/) || html.match(/There has been a critical error on this website/);
		return {
			status: nav ? nav.responseStatus : 0,
			overflow: document.documentElement.scrollWidth - document.documentElement.clientWidth,
			php: php ? php[0].replace(/<[^>]+>/g, '') : '',
			missing: ${ JSON.stringify( spec.expect || [] ) }.filter((selector) => !document.querySelector(selector)),
			signedIn: document.body.classList.contains('logged-in'),
			// Loaded images that render at 0×0 though their box is shown (e.g. an SVG logo without a width).
			collapsed: [...document.images].filter((img) => img.naturalWidth && img.getClientRects().length && !img.getBoundingClientRect().width).map((img) => (img.getAttribute('src') || '').split('/').pop()),
		};
	})()` );

	page.listeners.splice( page.listeners.indexOf( onEvent ), 1 );

	if ( facts.status >= 400 ) {
		problems.push( `HTTP ${ facts.status }` );
	}
	if ( facts.php ) {
		problems.push( `PHP: ${ facts.php }` );
	}
	if ( facts.overflow > 0 ) {
		problems.push( `scrolls sideways by ${ facts.overflow }px` );
	}
	if ( facts.collapsed.length ) {
		problems.push( `image renders at 0×0: ${ facts.collapsed.join( ', ' ) }` );
	}
	if ( facts.missing.length ) {
		problems.push( `missing ${ facts.missing.join( ', ' ) }` );
	}
	if ( spec.auth && ! facts.signedIn ) {
		problems.push( 'not signed in' );
	}
	jsErrors.forEach( ( error ) => problems.push( `JS: ${ error }` ) );

	if ( spec.mask?.length ) {
		await page.evaluate( `document.querySelectorAll(${ JSON.stringify( spec.mask.join( ',' ) ) }).forEach((el) => { el.style.display = 'none'; })` );
	}

	// EDD's register form fills in a random password after the page loads.
	await page.evaluate( `document.querySelectorAll('input[type="password"], input[name*="pass"]').forEach((input) => { input.value = ''; })` );

	// A full-page capture lays the whole page out as one tall viewport, which
	// starts loading images that were still off screen. The first capture
	// only triggers that; the second is taken once they are in.
	const capture = async () => {
		const height = Math.min( await page.evaluate( 'Math.ceil(document.documentElement.scrollHeight)' ), 12000 );
		return page.send( 'Page.captureScreenshot', {
			format: 'png',
			captureBeyondViewport: true,
			clip: { x: 0, y: 0, width, height, scale: 1 },
		} );
	};
	await capture();
	await networkIdle();
	await page.evaluate( IMAGES_READY );
	const shot = await capture();

	return { problems, png: Buffer.from( shot.data, 'base64' ) };
}

/* Image comparison (in a blank page's canvas)
------------------------------------------------------------------------ */

async function compare( page, before, after ) {
	await page.go( 'about:blank' );
	const result = await page.evaluate( `(async () => {
		const load = (src) => new Promise((resolve) => { const img = new Image(); img.onload = () => resolve(img); img.src = src; });
		const [a, b] = await Promise.all([load('data:image/png;base64,${ before.toString( 'base64' ) }'), load('data:image/png;base64,${ after.toString( 'base64' ) }')]);
		const width = Math.max(a.width, b.width), height = Math.max(a.height, b.height);
		const canvas = (img) => { const c = document.createElement('canvas'); c.width = width; c.height = height; const ctx = c.getContext('2d'); ctx.drawImage(img, 0, 0); return ctx.getImageData(0, 0, width, height); };
		const da = canvas(a), db = canvas(b);
		const out = document.createElement('canvas'); out.width = width; out.height = height;
		const ctx = out.getContext('2d'); ctx.globalAlpha = 0.25; ctx.drawImage(b, 0, 0); ctx.globalAlpha = 1;
		const diff = ctx.getImageData(0, 0, width, height);
		let changed = 0;
		for (let i = 0; i < da.data.length; i += 4) {
			const delta = Math.abs(da.data[i] - db.data[i]) + Math.abs(da.data[i + 1] - db.data[i + 1]) + Math.abs(da.data[i + 2] - db.data[i + 2]);
			if (delta > 48) { changed++; diff.data[i] = 230; diff.data[i + 1] = 0; diff.data[i + 2] = 60; diff.data[i + 3] = 255; }
		}
		ctx.putImageData(diff, 0, 0);
		return { changed, total: width * height, sizeChanged: a.width !== b.width || a.height !== b.height, from: a.height, to: b.height, png: out.toDataURL('image/png').split(',')[1] };
	})()` );

	return { ...result, png: Buffer.from( result.png, 'base64' ) };
}

/* Run
------------------------------------------------------------------------ */

// Swap `{download:slug}` in a path for that product's ID on this site,
// looked up through the REST API from inside the browser.
async function resolvePath( page, pathname ) {
	const slugs = [ ...pathname.matchAll( /\{download:([\w-]+)\}/g ) ];
	if ( ! slugs.length ) {
		return pathname;
	}
	await page.go( `${ baseUrl }/wp-json/` );
	for ( const [ token, slug ] of slugs ) {
		const id = await page.evaluate( `fetch('/wp-json/wp/v2/edd-downloads?slug=${ slug }&_fields=id').then((r) => r.json()).then((d) => d[0]?.id || 0)` );
		if ( ! id ) {
			throw new Error( `no download with the slug ${ slug }` );
		}
		pathname = pathname.replace( token, id );
	}
	return pathname;
}

async function signIn( page ) {
	// An auth cookie (`name=value`) instead of a password, e.g. from
	// `wp eval` with wp_generate_auth_cookie() for scripted runs.
	if ( env.VISUAL_TEST_COOKIE ) {
		const [ name, ...value ] = env.VISUAL_TEST_COOKIE.split( '=' );
		await page.send( 'Network.setCookie', { name, value: value.join( '=' ), domain: host, path: '/', secure: baseUrl.startsWith( 'https' ), httpOnly: true } );
		await page.go( `${ baseUrl }/account/` );
		return page.evaluate( `document.body.classList.contains('logged-in')` );
	}

	if ( ! env.VISUAL_TEST_USERNAME || ! env.VISUAL_TEST_PASSWORD ) {
		return false;
	}

	await page.go( `${ baseUrl }/login/` );
	await page.evaluate( `(() => {
		document.querySelector('#edd_user_login').value = ${ JSON.stringify( env.VISUAL_TEST_USERNAME ) };
		document.querySelector('#edd_user_pass').value = ${ JSON.stringify( env.VISUAL_TEST_PASSWORD ) };
	})()` );

	const ready = new Promise( ( resolve ) => {
		const onEvent = ( message ) => {
			if ( message.method === 'Page.loadEventFired' ) {
				page.listeners.splice( page.listeners.indexOf( onEvent ), 1 );
				resolve();
			}
		};
		page.listeners.push( onEvent );
	} );
	await page.evaluate( `document.querySelector('#edd_login_submit').click()` );
	await Promise.race( [ ready, sleep( 15000 ) ] );

	return page.evaluate( `document.body.classList.contains('logged-in')` );
}

async function main() {
	const pages = config.pages.filter( ( spec ) => ! only.length || only.includes( spec.name ) );
	const runDir = path.join( outDir, 'latest' );

	fs.rmSync( runDir, { recursive: true, force: true } );
	fs.mkdirSync( runDir, { recursive: true } );

	const chrome = await launchChrome();
	const page = await openPage( chrome.port );
	const report = [];
	let failures = 0;
	let changes = 0;

	try {
		// Signed-out pages first, then the same browser signs in.
		const ordered = [ ...pages.filter( ( p ) => ! p.auth ), ...pages.filter( ( p ) => p.auth ) ];
		let signedIn = false;

		for ( const spec of ordered ) {
			if ( spec.auth && ! signedIn ) {
				signedIn = await signIn( page );
				if ( ! signedIn ) {
					console.log( 'Skipping signed-in pages: set VISUAL_TEST_USERNAME and VISUAL_TEST_PASSWORD in .env (sign-in failed or not set).' );
					break;
				}
			}

			for ( const width of config.widths ) {
				for ( const scheme of config.schemes ) {
					const name = `${ spec.name }-${ width }-${ scheme }`;
					let result;

					try {
						result = await checkPage( page, spec, width, scheme );
					} catch ( error ) {
						result = { problems: [ `error: ${ error.message }` ], png: null };
					}

					const entry = { name, problems: result.problems, diff: null };

					if ( result.png ) {
						fs.writeFileSync( path.join( runDir, `${ name }.png` ), result.png );
						const baseline = path.join( baselineDir, `${ name }.png` );

						if ( updateBaseline ) {
							fs.mkdirSync( baselineDir, { recursive: true } );
							fs.writeFileSync( baseline, result.png );
						} else if ( fs.existsSync( baseline ) ) {
							const diff = await compare( page, fs.readFileSync( baseline ), result.png );
							const percent = ( 100 * diff.changed ) / diff.total;
							if ( diff.sizeChanged || percent > 0.05 ) {
								fs.writeFileSync( path.join( runDir, `${ name }.diff.png` ), diff.png );
								entry.diff = diff.sizeChanged ? `height ${ diff.from } → ${ diff.to }px, ${ percent.toFixed( 2 ) }% of pixels` : `${ percent.toFixed( 2 ) }% of pixels`;
								changes++;
							}
						} else {
							entry.diff = 'no baseline';
						}
					}

					failures += entry.problems.length ? 1 : 0;
					report.push( entry );

					const status = entry.problems.length ? 'FAIL' : entry.diff && entry.diff !== 'no baseline' ? 'CHANGED' : 'ok';
					console.log( `${ status.padEnd( 8 ) } ${ name }${ entry.problems.length ? ` — ${ entry.problems.join( '; ' ) }` : '' }${ entry.diff ? ` [${ entry.diff }]` : '' }` );
				}
			}
		}
	} finally {
		page.close();
		await chrome.close();
	}

	fs.writeFileSync( path.join( runDir, 'report.json' ), JSON.stringify( { url: baseUrl, date: new Date().toISOString(), report }, null, '\t' ) );

	console.log( `\n${ report.length } screenshots, ${ failures } with problems, ${ changes } changed from the baseline.` );
	console.log( `Screenshots and diffs: ${ path.relative( root, runDir ) }/` );
	if ( updateBaseline ) {
		console.log( `Baseline saved: ${ path.relative( root, baselineDir ) }/` );
	}

	process.exitCode = failures ? 1 : 0;
}

main().catch( ( error ) => {
	console.error( error );
	process.exitCode = 1;
} );

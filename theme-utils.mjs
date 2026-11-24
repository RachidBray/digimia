#!/usr/bin/env node

/**
 * Pattern tools — Digimia Theme.
 *
 * Prepares pattern files pasted from the editor: wraps their visible text in
 * esc_html_e() or esc_attr_e() with the text domain, so it can be translated,
 * and turns absolute image URLs into ones PHP builds, so the images load on
 * any site.
 *
 * Usage:
 *   yarn translate:patterns   # Escapes every pattern
 *   yarn dev                  # Also escapes each pattern when it is saved
 *
 * Run `node theme-utils.mjs help` for the commands and options.
 *
 * The escaping (createRewriter(), escapeBlockAttributes(), and escapeText())
 * is adapted from Twenty Twenty-Five's theme-utils.mjs, (C) WordPress.org,
 * GPL-2.0-or-later: https://github.com/WordPress/twentytwentyfive
 *
 * @package digimia
 */

import fs from 'fs';
import path from 'path';
import process from 'process';
import chokidar from 'chokidar';
import glob from 'fast-glob';
import { RewritingStream } from 'parse5-html-rewriting-stream';

const USAGE = `Usage:
  node theme-utils.mjs escape-patterns [FOLDERS|FILES] [OPTIONS]
  node theme-utils.mjs watch [FOLDERS] [OPTIONS]

Commands:
  escape-patterns   Escapes the text and image URLs of pattern files.
  watch             Escapes every pattern, then each one again when it is saved.

  FOLDERS are folders holding a patterns/ folder (default: the current folder).

Options:
  --text-domain=DOMAIN   Text domain of the strings (default: the folder's name).
  --image-base=PHP       PHP that gives the URL of the folder holding
                         patterns/images/ (default: get_template_directory_uri()).

Examples:
  node theme-utils.mjs escape-patterns --text-domain=digimia
  node theme-utils.mjs escape-patterns ../../plugins/my-plugin --text-domain=my-plugin '--image-base=plugins_url( "", __DIR__ )'`;

/**
 * Block attributes that hold visible text. The ones printed inside an HTML
 * attribute (isAttr) take esc_attr_e(), the others esc_html_e().
 */
const BLOCK_TEXT_ATTRIBUTES = [
	{ name: 'label' },
	{ name: 'placeholder', isAttr: true },
	{ name: 'buttonText' },
	{ name: 'content' },
	{ name: 'ariaLabel', isAttr: true },
];

// An image's absolute URL, as the editor saves it, capturing the file's path
// inside patterns/images/: https://example.com/wp-content/themes/digimia/patterns/images/<file>
const IMAGE_URL = /https?:\/\/[^\/]+\/(?:[^\/]+\/)*patterns\/images\/([^"'\s]+)/i;

// The same URL in a block's settings, such as a Cover block's "url".
const BLOCK_IMAGE_URL = /("url":\s*")https?:\/\/[^"]+(\/patterns\/images\/[^"]+")/g;

// Either of the two, anywhere in a file.
const ANY_IMAGE_URL = /(?:src="https?:\/\/[^"]+\/|"url":\s*"https?:\/\/[^"]+)patterns\/images\/[^"]+"/i;

/**
 * Wraps text in the PHP that prints it translated and escaped. Text that is
 * empty, only white space, or already PHP comes back unchanged.
 *
 * Translators get the text without its outer spaces. A leading or trailing
 * space is kept outside the call, so text stays apart from an inline tag next
 * to it: "Get <strong>" keeps its space before the bold word.
 *
 * @param {string}  text       Text from the markup.
 * @param {string}  textDomain Text domain of the string.
 * @param {boolean} isAttr     Whether the text is printed inside an HTML attribute.
 * @return {string} The PHP call, or the text unchanged.
 */
function escapeText( text, textDomain, isAttr = false ) {
	const trimmed = text && text.trim();
	if ( ! textDomain || ! trimmed || trimmed.startsWith( '<?php' ) ) {
		return text;
	}
	const escape = isAttr ? 'esc_attr_e' : 'esc_html_e';
	// PHP drops only a newline right after ?>, so a space there stays.
	const before = text.startsWith( ' ' ) ? ' ' : '';
	const after = text.endsWith( ' ' ) ? ' ' : '';
	// A single-quoted PHP string ends at an unescaped ' and turns \\ into \.
	const quoted = trimmed.replaceAll( '\\', '\\\\' ).replaceAll( "'", "\\'" );
	return `${ before }<?php ${ escape }( '${ quoted }', '${ textDomain }' ); ?>${ after }`;
}

/**
 * Gives the PHP that prints the URL of the folder holding patterns/images/.
 *
 * @param {string} imageBase PHP expression for the folder's URL.
 * @return {string} A PHP echo statement.
 */
function phpUrl( imageBase ) {
	return `<?php echo esc_url( ${ imageBase } ); ?>`;
}

/**
 * Turns an image's absolute URL into one PHP builds from the image base.
 *
 * @param {string} src       The img element's src.
 * @param {string} imageBase PHP expression for the folder's URL.
 * @return {string} The new src, or src unchanged.
 */
function imageUrl( src, imageBase ) {
	if ( ! src || src.trim().startsWith( '<?php' ) ) {
		return src;
	}
	const file = src.match( IMAGE_URL )?.[ 1 ];
	if ( file ) {
		return `${ phpUrl( imageBase ) }/patterns/images/${ file }`;
	}
	// Twenty Twenty-Five's rule: a file in an assets/ folder is the theme's.
	const parts = src.split( '/' );
	const assets = parts.indexOf( 'assets' );
	return -1 === assets ? src : `${ phpUrl( imageBase ) }/${ parts.slice( assets ).join( '/' ) }`;
}

/**
 * Escapes the text a block comment holds in its settings, such as a Search
 * block's label: <!-- wp:search {"label":"Search"} /-->.
 *
 * @param {string} comment    The comment's text, without <!-- and -->.
 * @param {string} textDomain Text domain of the strings.
 * @return {string} The comment's new text.
 */
function escapeBlockAttributes( comment, textDomain ) {
	const start = comment.indexOf( '{' );
	const end = comment.lastIndexOf( '}' );
	if ( -1 === start || end < start ) {
		return comment;
	}
	try {
		const attributes = JSON.parse( comment.slice( start, end + 1 ) );
		for ( const { name, isAttr } of BLOCK_TEXT_ATTRIBUTES ) {
			if ( attributes[ name ] ) {
				attributes[ name ] = escapeText( attributes[ name ], textDomain, isAttr );
			}
		}
		return comment.slice( 0, start ) + JSON.stringify( attributes ) + comment.slice( end + 1 );
	} catch {
		// Settings that aren't JSON (PHP inside them) or a value that isn't text.
		return comment;
	}
}

/**
 * Creates the HTML rewriter that escapes one pattern file.
 *
 * @param {string} textDomain Text domain of the strings.
 * @param {string} imageBase  PHP expression for the image folder's URL.
 * @return {RewritingStream} The rewriter.
 */
function createRewriter( textDomain, imageBase ) {
	const rewriter = new RewritingStream();

	rewriter.on( 'text', ( _, raw ) => {
		rewriter.emitRaw( escapeText( raw, textDomain ) );
	} );

	rewriter.on( 'startTag', ( tag ) => {
		for ( const attr of tag.attrs ) {
			if ( 'img' === tag.tagName && 'src' === attr.name ) {
				attr.value = imageUrl( attr.value, imageBase );
			} else if ( ( 'img' === tag.tagName && 'alt' === attr.name ) || 'aria-label' === attr.name ) {
				attr.value = escapeText( attr.value, textDomain, true );
			}
		}
		rewriter.emitStartTag( tag );
	} );

	// To the HTML parser, the file's PHP (its header, and text escaped before)
	// is a comment, like the block comments that hold each block's settings.
	rewriter.on( 'comment', ( comment, raw ) => {
		if ( comment.text.startsWith( '?php' ) ) {
			rewriter.emitRaw( raw );
			return;
		}
		const text = comment.text.replace(
			BLOCK_IMAGE_URL,
			( _, before, file ) => before + phpUrl( imageBase ) + file
		);
		rewriter.emitComment( { ...comment, text: escapeBlockAttributes( text, textDomain ) } );
	} );

	return rewriter;
}

/**
 * Escapes one pattern file in place.
 *
 * Escaping twice isn't safe (the &nbsp; a first pass leaves would become a
 * string of its own), so a file that already uses the text domain and has
 * no absolute image URL is left alone.
 *
 * @param {string} file       Path of the pattern file.
 * @param {string} textDomain Text domain of the strings.
 * @param {string} imageBase  PHP expression for the image folder's URL.
 * @return {Promise<boolean>} Whether the file changed.
 */
async function escapeFile( file, textDomain, imageBase ) {
	const content = await fs.promises.readFile( file, 'utf8' );
	if ( content.includes( '<?php' ) && content.includes( `'${ textDomain }'` ) && ! ANY_IMAGE_URL.test( content ) ) {
		return false;
	}
	const escaped = await rewrite( content, createRewriter( textDomain, imageBase ) );
	if ( escaped === content ) {
		return false;
	}
	await fs.promises.writeFile( file, escaped );
	return true;
}

/**
 * Runs markup through a rewriter.
 *
 * @param {string}          html     The markup.
 * @param {RewritingStream} rewriter The rewriter.
 * @return {Promise<string>} The rewritten markup.
 */
function rewrite( html, rewriter ) {
	return new Promise( ( resolve, reject ) => {
		let output = '';
		rewriter.on( 'data', ( chunk ) => ( output += chunk ) );
		rewriter.on( 'end', () => resolve( output ) );
		rewriter.on( 'error', reject );
		rewriter.end( html );
	} );
}

/**
 * Resolves a command's paths. A folder stands for every pattern in its
 * patterns/ folder, a file for itself. The text domain defaults to the name
 * of the folder holding patterns/.
 *
 * @param {string[]} paths      Folders and files.
 * @param {string}   textDomain Text domain from --text-domain, if any.
 * @return {Promise<Object[]>} One { root, files, textDomain } per path.
 */
function resolveTargets( paths, textDomain ) {
	return Promise.all(
		paths.map( async ( target ) => {
			const isFolder = fs.statSync( target ).isDirectory();
			const root = isFolder ? target : path.dirname( path.dirname( target ) );
			const patterns = path.join( root, 'patterns' );
			const files = isFolder
				? ( await glob( '**/*.php', { cwd: patterns } ) ).map( ( file ) => path.join( patterns, file ) )
				: [ target ];
			return { root, files, textDomain: textDomain ?? path.basename( path.resolve( root ) ) };
		} )
	);
}

/**
 * The escape-patterns command.
 *
 * @param {string[]} paths   Folders and files.
 * @param {Object}   options Text domain and image base.
 */
async function escapePatterns( paths, { textDomain, imageBase } ) {
	for ( const target of await resolveTargets( paths, textDomain ) ) {
		let changed = 0;
		for ( const file of target.files ) {
			if ( await escapeFile( file, target.textDomain, imageBase ) ) {
				console.log( `Escaped ${ file }` );
				changed++;
			}
		}
		console.log( `${ changed } of ${ target.files.length } patterns changed (text domain "${ target.textDomain }").` );
	}
}

/**
 * The watch command, which `yarn dev` runs: escapes every pattern, then each
 * one again when it is added or saved.
 *
 * @param {string[]} paths   Folders.
 * @param {Object}   options Text domain and image base.
 */
async function watchPatterns( paths, { textDomain, imageBase } ) {
	await escapePatterns( paths, { textDomain, imageBase } );
	for ( const target of await resolveTargets( paths, textDomain ) ) {
		const escapeSaved = async ( file ) => {
			try {
				if ( file.endsWith( '.php' ) && ( await escapeFile( file, target.textDomain, imageBase ) ) ) {
					console.log( `Escaped ${ file }` );
				}
			} catch ( error ) {
				console.error( `Could not escape ${ file }: ${ error.message }` );
			}
		};
		chokidar
			.watch( path.join( target.root, 'patterns' ), {
				ignoreInitial: true,
				// Wait until the editor has finished writing the file.
				awaitWriteFinish: { stabilityThreshold: 300, pollInterval: 100 },
			} )
			.on( 'add', escapeSaved )
			.on( 'change', escapeSaved );
	}
	console.log( 'Watching patterns. Press Ctrl+C to stop.' );
}

const COMMANDS = {
	'escape-patterns': escapePatterns,
	watch: watchPatterns,
};

const [ command, ...args ] = process.argv.slice( 2 );

if ( ! COMMANDS[ command ] ) {
	const help = [ undefined, 'help', '--help', '-h' ].includes( command );
	( help ? console.log : console.error )( help ? USAGE : `Unknown command: ${ command }\n\n${ USAGE }` );
	process.exit( help ? 0 : 1 );
}

const paths = [];
const options = { imageBase: 'get_template_directory_uri()' };
for ( const arg of args ) {
	if ( arg.startsWith( '--text-domain=' ) ) {
		options.textDomain = arg.slice( '--text-domain='.length );
	} else if ( arg.startsWith( '--image-base=' ) ) {
		options.imageBase = arg.slice( '--image-base='.length );
	} else if ( arg.startsWith( '--' ) ) {
		console.error( `Unknown option: ${ arg }\n\n${ USAGE }` );
		process.exit( 1 );
	} else {
		paths.push( arg );
	}
}

try {
	await COMMANDS[ command ]( paths.length ? paths : [ '.' ], options );
} catch ( error ) {
	console.error( error.message );
	process.exit( 1 );
}

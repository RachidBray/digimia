#!/usr/bin/env node

/**
 * Icon Manager — Digimia Theme.
 *
 * Manages assets/icons/, the Digimia icon set: Phosphor icons, regular weight
 * (@phosphor-icons/core, MIT). Each icon is one filled path, as the core Icon
 * block requires. After adding an icon, give it a label in inc/icons.php.
 *
 * Usage:
 *   yarn icons:add rocket credit-card    # Copy from Phosphor + optimize
 *   yarn icons:optimize                  # SVGO all icons
 *   yarn icons:list                      # List installed icons
 *   yarn icons:remove rocket             # Remove an icon
 *   yarn icons:search cart               # Search the Phosphor library
 *
 * @package digimia
 */

import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import { optimize } from 'svgo';

const __filename = fileURLToPath( import.meta.url );
const __dirname  = path.dirname( __filename );

const ICONS_DIR  = path.resolve( __dirname, 'assets/icons' );
const SOURCE_DIR = path.resolve( __dirname, 'node_modules/@phosphor-icons/core/assets/regular' );

/**
 * SVGO config: keeps viewBox and the filled path (colored by currentColor),
 * removes metadata and fixed dimensions.
 */
const SVGO_CONFIG = {
	multipass: true,
	plugins: [
		'preset-default',
		'removeTitle',
		'removeDesc',
		{
			name: 'removeAttrs',
			params: {
				attrs: [ 'class' ],
			},
		},
		'removeDimensions',
		{
			name: 'addAttributesToSVGElement',
			params: {
				attributes: [ { fill: 'currentColor' } ],
			},
		},
	],
};

/* ──────────────────────────────── Commands ──────────────────────────────── */

/**
 * Add icons from Phosphor by name.
 */
function cmdAdd( names ) {
	if ( ! names.length ) {
		console.error( '❌  Provide icon name(s): yarn icons:add arrow-right sparkle' );
		process.exit( 1 );
	}

	if ( ! fs.existsSync( SOURCE_DIR ) ) {
		console.error( '❌  @phosphor-icons/core not found. Run: yarn install' );
		process.exit( 1 );
	}

	fs.mkdirSync( ICONS_DIR, { recursive: true } );

	let added = 0;

	for ( const name of names ) {
		const src = path.join( SOURCE_DIR, `${ name }.svg` );
		const dst = path.join( ICONS_DIR, `${ name }.svg` );

		if ( ! fs.existsSync( src ) ) {
			console.warn( `⚠️  "${ name }" not found in Phosphor. Run "yarn icons:search ${ name }" to find matches.` );
			continue;
		}

		const raw    = fs.readFileSync( src, 'utf8' );
		const result = optimize( raw, { ...SVGO_CONFIG, path: src } );

		fs.writeFileSync( dst, result.data, 'utf8' );
		console.log( `✅  ${ name }.svg → assets/icons/` );
		added++;
	}

	console.log( `\n${ added } icon(s) added and optimized. Add a label for each in inc/icons.php.` );
}

/**
 * Optimize all existing icons in-place.
 */
function cmdOptimize() {
	if ( ! fs.existsSync( ICONS_DIR ) ) {
		console.log( 'No icons directory found.' );
		return;
	}

	const files = fs.readdirSync( ICONS_DIR ).filter( ( f ) => f.endsWith( '.svg' ) );

	if ( ! files.length ) {
		console.log( 'No SVG files to optimize.' );
		return;
	}

	let totalSaved = 0;

	for ( const file of files ) {
		const filePath    = path.join( ICONS_DIR, file );
		const raw         = fs.readFileSync( filePath, 'utf8' );
		const sizeBefore  = Buffer.byteLength( raw, 'utf8' );
		const result      = optimize( raw, { ...SVGO_CONFIG, path: filePath } );
		const sizeAfter   = Buffer.byteLength( result.data, 'utf8' );
		const saved       = sizeBefore - sizeAfter;

		fs.writeFileSync( filePath, result.data, 'utf8' );
		totalSaved += saved;

		const pct = sizeBefore > 0 ? ( ( saved / sizeBefore ) * 100 ).toFixed( 1 ) : '0';
		console.log( `  ${ file.padEnd( 25 ) } ${ sizeBefore }B → ${ sizeAfter }B  (${ pct }% saved)` );
	}

	console.log( `\n✅  ${ files.length } icon(s) optimized. Total saved: ${ totalSaved }B` );
}

/**
 * List all installed icons.
 */
function cmdList() {
	if ( ! fs.existsSync( ICONS_DIR ) ) {
		console.log( 'No icons directory found.' );
		return;
	}

	const files = fs.readdirSync( ICONS_DIR ).filter( ( f ) => f.endsWith( '.svg' ) );
	console.log( `\n📦  ${ files.length } icon(s) in assets/icons/:\n` );

	for ( const file of files ) {
		const size = fs.statSync( path.join( ICONS_DIR, file ) ).size;
		console.log( `  • ${ file.replace( '.svg', '' ).padEnd( 22 ) } (${ size }B)` );
	}
}

/**
 * Remove an icon.
 */
function cmdRemove( names ) {
	if ( ! names.length ) {
		console.error( '❌  Provide icon name(s): yarn icons:remove arrow-left' );
		process.exit( 1 );
	}

	for ( const name of names ) {
		const filePath = path.join( ICONS_DIR, `${ name }.svg` );

		if ( ! fs.existsSync( filePath ) ) {
			console.warn( `⚠️  "${ name }.svg" not found.` );
			continue;
		}

		fs.unlinkSync( filePath );
		console.log( `🗑️  Removed ${ name }.svg. Remove its label from inc/icons.php.` );
	}
}

/**
 * Search the Phosphor library for matching icon names.
 */
function cmdSearch( terms ) {
	if ( ! terms.length ) {
		console.error( '❌  Provide a search term: yarn icons:search cart' );
		process.exit( 1 );
	}

	if ( ! fs.existsSync( SOURCE_DIR ) ) {
		console.error( '❌  @phosphor-icons/core not found. Run: yarn install' );
		process.exit( 1 );
	}

	const allIcons = fs.readdirSync( SOURCE_DIR )
		.filter( ( f ) => f.endsWith( '.svg' ) )
		.map( ( f ) => f.replace( '.svg', '' ) );

	const query   = terms.join( ' ' ).toLowerCase();
	const matches = allIcons.filter( ( name ) => name.includes( query ) );

	if ( ! matches.length ) {
		console.log( `No Phosphor icons matching "${ query }".` );
		return;
	}

	// Check which are already installed.
	const installed = fs.existsSync( ICONS_DIR )
		? fs.readdirSync( ICONS_DIR ).filter( ( f ) => f.endsWith( '.svg' ) ).map( ( f ) => f.replace( '.svg', '' ) )
		: [];

	console.log( `\n🔍  ${ matches.length } Phosphor icon(s) matching "${ query }":\n` );

	for ( const name of matches.slice( 0, 30 ) ) {
		const tag = installed.includes( name ) ? ' ✓ installed' : '';
		console.log( `  ${ name }${ tag }` );
	}

	if ( matches.length > 30 ) {
		console.log( `  ... and ${ matches.length - 30 } more. Try a more specific term.` );
	}

	console.log( `\nAdd with: yarn icons:add ${ matches.slice( 0, 3 ).join( ' ' ) }` );
}

/* ──────────────────────────────── Router ──────────────────────────────── */

const [ , , command, ...args ] = process.argv;

switch ( command ) {
	case 'add':
		cmdAdd( args );
		break;
	case 'optimize':
		cmdOptimize();
		break;
	case 'list':
		cmdList();
		break;
	case 'remove':
		cmdRemove( args );
		break;
	case 'search':
		cmdSearch( args );
		break;
	default:
		console.log( `
Digimia Icon Manager
────────────────────
  yarn icons:add <name...>       Copy icon(s) from Phosphor + optimize
  yarn icons:optimize            SVGO-optimize all existing icons
  yarn icons:list                List installed icons
  yarn icons:remove <name...>    Remove icon(s)
  yarn icons:search <term>       Search the Phosphor library
		` );
}

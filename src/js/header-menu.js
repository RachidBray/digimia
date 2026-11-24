/**
 * Digimia header menu
 *
 * Core's Navigation block swaps the menu for its button below 600px only: a
 * long menu wraps onto a second line well before that, and a short one would
 * fit on a phone. In the theme's headers (`.digimia-site-header`) the full menu
 * shows while its top-level items fit on one line, and the button when they
 * don't. This script tries the full menu and marks the Navigation block
 * `data-digimia-menu="fits"` or `"button"` (styles in _core-navigation.scss).
 * Until it runs, tablet widths show the button, which keeps the header the
 * same height either way.
 *
 * @package digimia
 */
( function () {
	'use strict';

	const navs = document.querySelectorAll( '.digimia-site-header .wp-block-navigation' );

	if ( ! navs.length ) {
		return;
	}

	const wide = window.matchMedia( '(min-width: 600px)' );

	function fit( nav ) {
		// Below 600px core shows the button; an open menu is left as it is.
		if ( ! wide.matches || nav.querySelector( '.is-menu-open' ) ) {
			return;
		}

		// Show the full menu, measure, and settle before the next paint.
		nav.dataset.digimiaMenu = 'fits';

		const items = [ ...nav.querySelectorAll( '.wp-block-navigation__container > li' ) ];
		const first = items[ 0 ]?.getBoundingClientRect();
		const oneLine = first && items.every( ( item ) => item.getBoundingClientRect().top < first.bottom );

		nav.dataset.digimiaMenu = oneLine ? 'fits' : 'button';
	}

	const fitAll = () => navs.forEach( fit );
	let frame = 0;

	fitAll();
	document.fonts?.ready.then( fitAll );
	window.addEventListener( 'resize', () => {
		cancelAnimationFrame( frame );
		frame = requestAnimationFrame( fitAll );
	} );
}() );

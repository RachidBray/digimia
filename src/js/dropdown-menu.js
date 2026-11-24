/**
 * Digimia dropdown menus
 *
 * A dropdown opens under its label and a nested menu beside its parent, both
 * toward the end of the line (_core-navigation.scss). When an open panel would
 * run off the screen, this script marks its menu item `data-digimia-flip` and
 * the panel opens toward the start instead.
 *
 * @package digimia
 */
( function () {
	'use strict';

	const navs = document.querySelectorAll( '.wp-block-navigation' );

	if ( ! navs.length ) {
		return;
	}

	// How far the panel runs past the screen on the side it opens toward.
	function overflow( panel, flipped ) {
		const rect = panel.getBoundingClientRect();
		const rtl = 'rtl' === getComputedStyle( panel ).direction;
		const towardRight = rtl === flipped;

		return towardRight ? rect.right - document.documentElement.clientWidth : -rect.left;
	}

	function place( item ) {
		const panel = item.querySelector( ':scope > .wp-block-navigation__submenu-container' );

		// The phone menu lists its links in place.
		if ( ! panel || item.closest( '.is-menu-open' ) ) {
			return;
		}

		delete item.dataset.digimiaFlip;

		const ahead = overflow( panel, false );

		if ( ahead <= 0 ) {
			return;
		}

		item.dataset.digimiaFlip = '';

		// Where the other side has even less room, the first way wins.
		if ( overflow( panel, true ) > ahead ) {
			delete item.dataset.digimiaFlip;
		}
	}

	// Core opens a panel by setting its toggle's aria-expanded; this runs
	// before the panel is painted.
	const observer = new MutationObserver( ( records ) => {
		records.forEach( ( { target } ) => {
			const item = target.closest( '.has-child' );

			if ( item && 'true' === target.getAttribute( 'aria-expanded' ) ) {
				place( item );
			}
		} );
	} );

	navs.forEach( ( nav ) => {
		observer.observe( nav, { subtree: true, attributes: true, attributeFilter: [ 'aria-expanded' ] } );
	} );
}() );

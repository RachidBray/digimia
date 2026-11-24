/**
 * Digimia EDD add-to-cart feedback
 *
 * EDD confirms an add with an "Added to cart" note that stays for 3 seconds.
 * The theme keeps that note for screen readers only and confirms on the button
 * the shopper just clicked instead: the next step (Checkout) shows at once with
 * a check that pops in, and the header cart count bumps. Works with every EDD
 * cart setting: with "Redirect to Checkout" the page leaves before this runs,
 * and the Cart Preview drawer opens from the same event.
 *
 * EDD triggers its events through jQuery, so they are read through jQuery.
 *
 * @package digimia
 */
( function ( $ ) {
	'use strict';

	if ( ! $ ) {
		return;
	}

	const JUST_ADDED = 'digimia-just-added';
	const BUMP = 'digimia-bump';
	const DURATION = 2400;

	let lastWrapper = null;

	// EDD's event does not say which button was used, so remember the click.
	$( document.body ).on( 'click', '.edd-add-to-cart', function () {
		lastWrapper = this.closest( '.edd_purchase_submit_wrapper' );
	} );

	$( document.body ).on( 'edd_cart_item_added', function () {
		if ( lastWrapper ) {
			const wrapper = lastWrapper;

			wrapper.classList.remove( JUST_ADDED );
			// Restart the animation when the same button is used twice in a row.
			void wrapper.offsetWidth;
			wrapper.classList.add( JUST_ADDED );
			window.setTimeout( () => wrapper.classList.remove( JUST_ADDED ), DURATION );
		}

		document.querySelectorAll( '.edd-blocks-cart__mini-quantity' ).forEach( ( badge ) => {
			badge.classList.remove( BUMP );
			void badge.offsetWidth;
			badge.classList.add( BUMP );
		} );
	} );
}( window.jQuery ) );

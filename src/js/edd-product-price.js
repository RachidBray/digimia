/**
 * Digimia product price
 *
 * A purchase card shows the product price large (`digimia-product-price`) above
 * the Buy Button. For a product with license options it starts at the
 * preselected license; when the shopper picks another license, the large price
 * follows. EDD prints each option's formatted price in its label, so the text
 * is taken from there and currency formatting stays EDD's. With multiple
 * licenses selectable at once (checkboxes) the price is left as it is.
 *
 * @package digimia
 */
( function () {
	'use strict';

	document.addEventListener( 'change', ( event ) => {
		const input = event.target;

		if ( ! input.matches?.( '.edd_price_options input[type="radio"]' ) ) {
			return;
		}

		const card = input.closest( '.digimia-purchase-card' );
		const price = card?.querySelector( '.digimia-product-price' );
		const label = input.closest( 'li' )?.querySelector( '.edd_price_option_price' );

		if ( price && label ) {
			price.textContent = label.textContent.trim();
		}
	} );
}() );

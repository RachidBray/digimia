/**
 * Digimia product details in the editor
 *
 * The `digimia/product` block bindings source is registered in PHP
 * (inc/edd-product.php), which renders the values on the front end. Here it
 * gets a field list, so a Paragraph can be connected to a product fact from the
 * block's Attributes panel, and shows each fact's name in place of its value.
 *
 * @package digimia
 */
( function ( wp, facts ) {
	'use strict';

	if ( ! wp?.blocks?.registerBlockBindingsSource || ! facts ) {
		return;
	}

	wp.blocks.registerBlockBindingsSource( {
		name: 'digimia/product',
		usesContext: [ 'postId', 'postType' ],
		getFieldsList() {
			return Object.entries( facts ).map( ( [ key, label ] ) => ( {
				label,
				type: 'string',
				args: { key },
			} ) );
		},
		getValues( { bindings } ) {
			const values = {};
			Object.entries( bindings ).forEach( ( [ attribute, { args } ] ) => {
				values[ attribute ] = facts[ args?.key ] || args?.key;
			} );
			return values;
		},
		canUserEditValue: () => false,
	} );
}( window.wp, window.digimiaProductFacts ) );

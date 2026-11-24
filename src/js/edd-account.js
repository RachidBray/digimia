/**
 * Digimia customer account
 *
 * - License keys ([edd_license_keys]): a Copy button beside each key field.
 *   Without JavaScript the read-only field still selects for copying.
 * - Account menu (`.digimia-account-nav`): the link of the section in view
 *   gets `aria-current="true"`.
 *
 * Loaded by inc/edd-account.php where the license keys or the account menu
 * render.
 *
 * @package digimia
 */
( function () {
	'use strict';

	const i18n = window.digimiaAccount || { copy: 'Copy', copied: 'Copied' };

	document.querySelectorAll( 'input.edd_sl_license_key' ).forEach( ( input ) => {
		const wrap = document.createElement( 'span' );
		const button = document.createElement( 'button' );

		wrap.className = 'digimia-license-key';
		button.type = 'button';
		button.className = 'digimia-license-key__copy';
		button.textContent = i18n.copy;
		button.setAttribute( 'aria-live', 'polite' );

		input.before( wrap );
		wrap.append( input, button );

		input.addEventListener( 'focus', () => input.select() );
		button.addEventListener( 'click', async () => {
			try {
				await navigator.clipboard.writeText( input.value );
			} catch {
				input.select();
				return;
			}

			button.textContent = i18n.copied;
			setTimeout( () => {
				button.textContent = i18n.copy;
			}, 2000 );
		} );
	} );

	const links = [ ...document.querySelectorAll( '.digimia-account-nav a[href^="#"]' ) ];
	const sections = links
		.map( ( link ) => document.getElementById( decodeURIComponent( link.hash.slice( 1 ) ) ) )
		.filter( Boolean );

	if ( ! sections.length || ! ( 'IntersectionObserver' in window ) ) {
		return;
	}

	const visible = new Set();
	const observer = new IntersectionObserver(
		( entries ) => {
			entries.forEach( ( entry ) => {
				if ( entry.isIntersecting ) {
					visible.add( entry.target );
				} else {
					visible.delete( entry.target );
				}
			} );

			// The first section in page order that is in view.
			const current = sections.find( ( section ) => visible.has( section ) );
			links.forEach( ( link ) => {
				if ( current && link.hash === `#${ current.id }` ) {
					link.setAttribute( 'aria-current', 'true' );
				} else {
					link.removeAttribute( 'aria-current' );
				}
			} );
		},
		{ rootMargin: '-20% 0px -60% 0px' }
	);

	sections.forEach( ( section ) => observer.observe( section ) );
}() );

/**
 * Pages checked by `yarn test:visual` (tests/visual/run.mjs).
 *
 * Paths match the demo store's content (see
 * docs/developer/visual-regression.md). Each page:
 * - name:   file name of its screenshots.
 * - path:   URL path on the site; `{download:slug}` becomes that product's ID.
 * - auth:   true to load it signed in as the test customer.
 * - before: paths loaded first, e.g. to put a product in the cart.
 * - follow: links to click through after loading the path, each the first
 *           match of a selector, for pages whose URL holds an order or
 *           license ID.
 * - expect: selectors that must be in the page.
 * - mask:   selectors removed before the screenshot (third-party frames and
 *           other content that changes on every load).
 */
export default {
	widths: [ 1440, 390 ],
	schemes: [ 'light', 'dark' ],
	pages: [
		{ name: 'home', path: '/', expect: [ '.digimia-glow-hero svg.digimia-illustration', '.digimia-float-chip', '.digimia-accent-card', '.digimia-plan.is-style-section-brand', 'h1 mark' ] },
		{ name: 'home-store', path: '/home-digital-products/' },
		{ name: 'home-courses', path: '/home-courses/', expect: [ '.digimia-curriculum', '.digimia-session--featured', '.digimia-course-stage', 'svg.digimia-illustration' ] },
		{ name: 'home-books', path: '/home-books/', expect: [ '.digimia-book-cover', '.digimia-excerpt .has-drop-cap', '.digimia-press-lead' ] },
		{ name: 'home-fitness', path: '/home-fitness/', expect: [ '.digimia-fitness-hero', '.digimia-photo-mono', '.digimia-accent-card', 'svg.digimia-illustration' ] },
		{ name: 'home-plugins', path: '/home-plugins/', expect: [ '.digimia-code-window', '.digimia-release', 'svg.digimia-illustration' ] },
		{ name: 'contact', path: '/contact/', expect: [ '.digimia-message-card form', '.digimia-contact-method' ] },
		{ name: 'changelog', path: '/changelog/', expect: [ '.digimia-release' ] },
		{ name: 'pricing', path: '/pricing/', expect: [ '.digimia-tabs--billing', 'table' ] },
		{ name: 'features', path: '/features/', expect: [ '.digimia-feature-rows', '.digimia-tabs' ] },
		{ name: 'integrations', path: '/integrations/', expect: [ '.digimia-integration--card', '.digimia-code-window' ] },
		{ name: 'how-it-works', path: '/how-it-works/', expect: [ '.digimia-timeline__step' ] },
		{ name: 'about', path: '/about/' },
		{ name: 'team', path: '/team/', expect: [ '.digimia-member' ] },
		{ name: 'careers', path: '/careers/', expect: [ '.digimia-job' ] },
		{ name: 'shop-sidebar', path: '/shop-sidebar/', expect: [ '.digimia-shop-sidebar', '.digimia-product-card' ] },
		{ name: 'portfolio', path: '/portfolio/', expect: [ '.digimia-project' ] },
		{ name: 'case-study', path: '/case-study/', expect: [ '.digimia-case-results' ] },
		{ name: 'coming-soon', path: '/coming-soon/', expect: [ '.digimia-photo-hero' ] },
		{ name: 'services', path: '/services/', expect: [ '.digimia-service', '.digimia-timeline__step' ] },
		{ name: 'shop', path: '/downloads/', expect: [ '.wp-block-edd-downloads .edd_download_purchase_form, .digimia-product-card' ] },
		{
			name: 'product-showcase',
			path: '/downloads/icon-library-essentials/',
			expect: [ '.digimia-purchase-card', '.edd_purchase_submit_wrapper', '#edd-reviews', '.digimia-product-rating' ],
		},
		{
			name: 'product-banner',
			path: '/downloads/saas-dashboard-ui-kit/',
			expect: [ '.digimia-purchase-card', '.edd_price_options' ],
		},
		{ name: 'product-guide', path: '/downloads/startup-pitch-deck-template/', expect: [ '.digimia-purchase-card' ] },
		{ name: 'product-classic', path: '/downloads/agency-proposal-kit/', expect: [ '.edd_purchase_submit_wrapper' ] },
		{
			name: 'product-licensed',
			path: '/downloads/formwise-pro/',
			expect: [ '.digimia-purchase-card', '.edd-variable-pricing-desc' ],
		},
		{
			name: 'checkout',
			path: '/checkout/',
			before: [ '/checkout/?edd_action=add_to_cart&download_id={download:icon-library-essentials}' ],
			expect: [ '#edd_purchase_form', '#edd_checkout_user_info', '#edd_checkout_cart' ],
			mask: [ '#edd-paypal-container', '.edd-paypal-wallet-container', '#edd-paypal-messages', '#edd-fastlane-container' ],
		},
		{ name: 'login', path: '/login/', expect: [ '#edd_login_form, .edd-blocks-form' ] },
		{ name: 'register', path: '/register/', expect: [ '.edd-blocks-form' ] },
		{ name: 'journal', path: '/journal/' },
		{
			name: 'account',
			path: '/account/',
			auth: true,
			expect: [ '.digimia-account-nav', '#edd_sl_license_keys', '.edd-blocks-subscriptions__subscription', '.edd-blocks-orders__order' ],
		},
		{
			name: 'account-subscription',
			path: '/account/',
			follow: [ 'a[href*="subscription_id="]' ],
			auth: true,
			expect: [ '.edd-blocks-subscriptions__subscription-actions' ],
		},
		{
			name: 'account-license-sites',
			path: '/account/',
			follow: [ 'a[href*="license_id="]' ],
			auth: true,
			expect: [ '#edd_sl_license_sites', '#edd_sl_license_add_site_form' ],
		},
		{
			name: 'product-reviews-signed-in',
			path: '/downloads/icon-library-essentials/',
			auth: true,
			expect: [ '#edd-reviews-form, .edd-reviews-form form' ],
		},
	],
};

<?php
/**
 * Customer account page (pattern `store-account`).
 *
 * Display-only. The Licenses and Subscriptions sections, and their links in
 * the account menu, show only when EDD Software Licensing or EDD Recurring
 * Payments is active and the signed-in customer has a license or a
 * subscription, so a store without them never shows empty sections. Also
 * loads src/js/edd-account.js (key copy buttons, current menu link) and gives
 * subscription status chips their status class.
 *
 * @package digimia
 */

declare(strict_types=1);

namespace Digimia;

/**
 * Whether the extension behind an optional account section is active.
 *
 * The `store-account` pattern leaves out a section, and its menu link, while
 * it is not: the editor would show the Subscriptions block as unsupported and
 * the license keys shortcode as bare text. A page saved with a section keeps
 * it, hidden until the extension is active.
 *
 * @param string $section `licenses` or `subscriptions`.
 */
function account_section_available( string $section ): bool {
	if ( 'licenses' === $section ) {
		return function_exists( 'edd_software_licensing' );
	}

	return 'subscriptions' === $section && class_exists( 'EDD_Recurring_Subscriber' );
}

/**
 * Whether an optional account section applies to the current customer.
 *
 * @param string $section `licenses` or `subscriptions`.
 */
function account_has_section( string $section ): bool {
	static $cache = array();

	if ( isset( $cache[ $section ] ) ) {
		return $cache[ $section ];
	}

	$user_id = get_current_user_id();
	$has     = false;

	if ( $user_id && 'licenses' === $section && account_section_available( 'licenses' ) ) {
		$has = (bool) edd_software_licensing()->get_license_keys_of_user( $user_id, 0, 'any', false );
	}

	if ( $user_id && 'subscriptions' === $section && account_section_available( 'subscriptions' ) ) {
		$subscriber = new \EDD_Recurring_Subscriber( $user_id, true );
		$has        = $subscriber->id && (bool) $subscriber->get_subscriptions();
	}

	$cache[ $section ] = $has;
	return $has;
}

/**
 * Drop an optional account section, or its menu link, that does not apply.
 *
 * Sections are groups with `digimia-account-licenses` /
 * `digimia-account-subscriptions`; menu links are list items with
 * `digimia-account-nav__licenses` / `digimia-account-nav__subscriptions`.
 *
 * @param string               $content Rendered block.
 * @param array<string, mixed> $block   Parsed block.
 * @return string
 */
function drop_unused_account_sections( string $content, array $block ): string {
	$classes = (string) ( $block['attrs']['className'] ?? '' );

	if ( ! str_contains( $classes, 'digimia-account-' ) ) {
		return $content;
	}

	foreach ( array( 'licenses', 'subscriptions' ) as $section ) {
		if ( preg_match( '/\bdigimia-account-(nav__)?' . $section . '\b/', $classes ) && ! account_has_section( $section ) ) {
			return '';
		}
	}

	return $content;
}
add_filter( 'render_block_core/group', __NAMESPACE__ . '\drop_unused_account_sections', 10, 2 );
add_filter( 'render_block_core/list-item', __NAMESPACE__ . '\drop_unused_account_sections', 10, 2 );

/**
 * Copy buttons for license keys and the current-section link in the account
 * menu (src/js/edd-account.js), where either renders.
 */
function enqueue_account_script(): void {
	if ( wp_script_is( 'digimia-edd-account' ) ) {
		return;
	}

	wp_enqueue_script(
		'digimia-edd-account',
		get_template_directory_uri() . '/assets/js/edd-account.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
	wp_add_inline_script(
		'digimia-edd-account',
		'window.digimiaAccount = ' . wp_json_encode(
			array(
				'copy'   => __( 'Copy', 'digimia' ),
				'copied' => __( 'Copied', 'digimia' ),
			)
		) . ';',
		'before'
	);
}
add_action( 'edd_sl_license_keys_before', __NAMESPACE__ . '\enqueue_account_script' );

/**
 * Load the account script with the account menu.
 *
 * @param string               $content Rendered block.
 * @param array<string, mixed> $block   Parsed block.
 * @return string
 */
function enqueue_account_script_with_menu( string $content, array $block ): string {
	if ( str_contains( (string) ( $block['attrs']['className'] ?? '' ), 'digimia-account-nav' ) ) {
		enqueue_account_script();
	}

	return $content;
}
add_filter( 'render_block_core/list', __NAMESPACE__ . '\enqueue_account_script_with_menu', 10, 2 );

/**
 * Subscription status as a class on its chip (`is-active`, `is-cancelled`,
 * …), so the status colors apply: EDD Recurring prints the translated status
 * as text only. In the list, each card's ID comes from its details link,
 * which follows the status in the card; on the details page, from the URL.
 *
 * Links between the list and a subscription's pages also get `#subscriptions`,
 * so the reloaded account page opens at its Subscriptions section.
 *
 * @param string $content Rendered block.
 * @return string
 */
function subscription_block_markup( string $content ): string {
	if ( ! class_exists( 'EDD_Subscription' ) ) {
		return $content;
	}

	$content = (string) preg_replace_callback(
		'#class="edd-blocks-subscriptions__subscription-status(?=(?:.*?subscription_id=(\d+))?)#s',
		static function ( array $m ): string {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Display only.
			$id           = ! empty( $m[1] ) ? (int) $m[1] : absint( $_GET['subscription_id'] ?? 0 );
			$subscription = new \EDD_Subscription( $id );
			return $m[0] . ( $subscription->id ? ' is-' . sanitize_html_class( (string) $subscription->status ) : '' );
		},
		$content
	);

	$page = untrailingslashit( (string) get_permalink() );

	return (string) preg_replace_callback(
		'#href="([^"]+)"#',
		static function ( array $m ) use ( $page ): string {
			$url  = html_entity_decode( $m[1] );
			$path = untrailingslashit( (string) wp_parse_url( $url, PHP_URL_PATH ) );
			$same = $path && ! str_contains( $url, '#' ) && str_ends_with( $page, $path );

			return $same && ( str_contains( $url, 'subscription_id=' ) || untrailingslashit( $url ) === $page )
				? 'href="' . $m[1] . '#subscriptions"'
				: $m[0];
		},
		$content
	);
}
add_filter( 'render_block_edd/subscriptions', __NAMESPACE__ . '\subscription_block_markup' );

/**
 * Give the Software Licensing views an H1.
 *
 * Managing a license (`?action=manage_licenses`) replaces the whole account
 * page, H1 included. The single-license view opens with an `<h5>`, which
 * becomes the page's H1 (the theme styles it by class, so it looks the same);
 * the order overview and the upgrade list have no heading, so they get a
 * visually hidden one.
 *
 * @param string $content Rendered Post Content block.
 * @return string
 */
function license_view_heading( string $content ): string {
	if ( ! str_contains( $content, 'edd-manage-license-back' ) || str_contains( $content, '<h1' ) ) {
		return $content;
	}

	$single = (string) preg_replace( '#<h5 class="edd-sl-manage-license-header">(.*?)</h5>#s', '<h1 class="edd-sl-manage-license-header">$1</h1>', $content, 1, $count );
	if ( $count ) {
		return $single;
	}

	$heading = '<h1 class="screen-reader-text">' . esc_html__( 'Licenses', 'digimia' ) . '</h1>';

	return (string) preg_replace( '#^(<div\b[^>]*>)#', '$1' . $heading, $content, 1 );
}
add_filter( 'render_block_core/post-content', __NAMESPACE__ . '\license_view_heading' );

/**
 * Name the account fields EDD leaves unlabeled.
 *
 * Screen readers announce a field by its label. EDD's register form labels its
 * email field `for="email"` while the field's ID is `edd-user-email`, so the
 * two never connect; Software Licensing prints the read-only license key and
 * the "add a site" field with no label at all.
 *
 * @param string $content Rendered block.
 * @return string
 */
function edd_field_labels( string $content ): string {
	if ( ! str_contains( $content, 'edd_sl_license_key' ) && ! str_contains( $content, 'name="site_url"' ) && ! str_contains( $content, 'id="edd-user-email"' ) ) {
		return $content;
	}

	$email = str_contains( $content, 'id="edd-user-email"' ) && ! str_contains( $content, 'id="email"' );
	$tag   = new \WP_HTML_Tag_Processor( $content );

	while ( $tag->next_tag() ) {
		$name = $tag->get_tag();

		if ( 'LABEL' === $name && $email && 'email' === $tag->get_attribute( 'for' ) ) {
			$tag->set_attribute( 'for', 'edd-user-email' );
		} elseif ( 'INPUT' === $name && null === $tag->get_attribute( 'aria-label' ) ) {
			if ( $tag->has_class( 'edd_sl_license_key' ) ) {
				$tag->set_attribute( 'aria-label', __( 'License key', 'digimia' ) );
			} elseif ( 'site_url' === $tag->get_attribute( 'name' ) ) {
				$tag->set_attribute( 'aria-label', __( 'Site URL', 'digimia' ) );
			}
		}
	}

	return $tag->get_updated_html();
}
add_filter( 'render_block_edd/register', __NAMESPACE__ . '\edd_field_labels' );
add_filter( 'render_block_core/shortcode', __NAMESPACE__ . '\edd_field_labels' );
add_filter( 'render_block_core/post-content', __NAMESPACE__ . '\edd_field_labels' );

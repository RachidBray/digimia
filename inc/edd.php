<?php
/**
 * Easy Digital Downloads presentation helpers for Digimia.
 *
 * Display-only helpers used by patterns. EDD owns all store behavior.
 *
 * @package digimia
 */

declare(strict_types=1);

namespace Digimia;

/**
 * Get the URL of a store page configured in EDD settings.
 *
 * @param string $option   EDD page option, e.g. `purchase_page` or `purchase_history_page`.
 * @param string $fallback Path relative to the home URL when EDD or the page is missing.
 */
function edd_page_url( string $option, string $fallback = '/' ): string {
	if ( function_exists( 'edd_get_option' ) ) {
		$page_id = (int) edd_get_option( $option, 0 );

		if ( $page_id > 0 ) {
			$url = get_permalink( $page_id );

			if ( $url ) {
				return $url;
			}
		}
	}

	return home_url( $fallback );
}

/**
 * Get the download archive URL, falling back to `/downloads/`.
 */
function edd_archive_url(): string {
	$url = get_post_type_archive_link( 'download' );

	return $url ? $url : home_url( '/downloads/' );
}

/**
 * Get download category IDs as a Query block `taxQuery` list.
 *
 * Patterns can only store term IDs, which differ on every site, so they look
 * the categories up by slug when they render. Missing categories are skipped;
 * if none exist, the list is empty and the query shows all downloads.
 *
 * @param string $slugs Download category slug, e.g. `plugins`, or several separated by commas.
 * @return string JSON array of term IDs.
 */
function download_category_ids( string $slugs ): string {
	$ids = array();

	foreach ( array_map( 'trim', explode( ',', $slugs ) ) as $slug ) {
		$term = get_term_by( 'slug', $slug, 'download_category' );

		if ( $term instanceof \WP_Term ) {
			$ids[] = $term->term_id;
		}
	}

	return (string) wp_json_encode( $ids );
}

/**
 * Get a download category's archive URL, falling back to the download archive.
 *
 * @param string $slug Download category slug, e.g. `plugins`.
 */
function download_category_url( string $slug ): string {
	$url = get_term_link( $slug, 'download_category' );

	return is_wp_error( $url ) ? edd_archive_url() : $url;
}

/**
 * Show nine downloads a page on the shop and its category and tag archives.
 *
 * The product grids show three rows of three. WordPress counts archive pages
 * with the Reading setting, so with ten a page the shop's last page would
 * return a 404 and category grids would end with a single card.
 *
 * @param \WP_Query $query The query being set up.
 */
function download_archive_page_size( \WP_Query $query ): void {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( $query->is_post_type_archive( 'download' ) || $query->is_tax( array( 'download_category', 'download_tag' ) ) ) {
		$query->set( 'posts_per_page', 9 );
	}
}
add_action( 'pre_get_posts', __NAMESPACE__ . '\download_archive_page_size' );

/**
 * Use the theme's button color instead of EDD's default blue.
 *
 * EDD falls back to `blue` when no button color is saved. An explicit choice
 * in Downloads → Settings → Styles is still respected.
 *
 * @param string $color_class EDD color class.
 * @return string
 */
function edd_button_color_class( string $color_class ): string {
	$settings = get_option( 'edd_settings', array() );

	return empty( $settings['checkout_color'] ) ? '' : $color_class;
}
add_filter( 'edd_button_color_class', __NAMESPACE__ . '\edd_button_color_class' );

/**
 * Drop EDD's `button` style class on the front end when no style is saved.
 *
 * EDD's `.edd-submit.button` rule paints buttons gray and outranks theme.json
 * button styles. Without the class, theme buttons style EDD buttons. An
 * explicit choice in Downloads → Settings → Styles is still respected.
 *
 * @param mixed $value Button style setting.
 * @return mixed
 */
function edd_button_style( $value ) {
	if ( is_admin() && ! wp_doing_ajax() ) {
		return $value;
	}

	$settings = get_option( 'edd_settings', array() );

	return empty( $settings['button_style'] ) ? '' : $value;
}
add_filter( 'edd_get_option_button_style', __NAMESPACE__ . '\edd_button_style' );

/**
 * Render EDD purchase buttons as theme buttons so theme.json button styles,
 * section styles, and dark mode apply to them.
 *
 * @param array<string, mixed> $args Purchase link arguments.
 * @return array<string, mixed>
 */
function edd_purchase_link_args( array $args ): array {
	$args['class'] = trim( ( $args['class'] ?? '' ) . ' wp-element-button' );

	return $args;
}
add_filter( 'edd_purchase_link_args', __NAMESPACE__ . '\edd_purchase_link_args' );

/**
 * Mini cart badge shows the number only; "item(s)" stays for screen readers.
 *
 * EDD's mini cart prints "{count} {item|items}" (server render and the AJAX
 * refresh after add to cart). This string is only used there.
 *
 * @param string $translation Translated text.
 * @param string $single      Singular source text.
 * @param string $plural      Plural source text.
 * @param int    $number      Count.
 * @param string $domain      Text domain.
 */
function edd_mini_cart_quantity_label( $translation, $single, $plural, $number, $domain ) {
	if ( 'easy-digital-downloads' !== $domain || 'item' !== $single || 'items' !== $plural ) {
		return $translation;
	}

	return '<span class="screen-reader-text">' . esc_html( $translation ) . '</span>';
}
add_filter( 'ngettext', __NAMESPACE__ . '\edd_mini_cart_quantity_label', 10, 5 );

/**
 * Add the theme button class to the checkout "Purchase" button.
 *
 * @param string $html Button markup.
 */
function edd_checkout_button_purchase( string $html ): string {
	$processor = new \WP_HTML_Tag_Processor( $html );

	while ( $processor->next_tag() ) {
		if ( 'edd-purchase-button' === $processor->get_attribute( 'id' ) ) {
			$processor->add_class( 'wp-element-button' );
		}
	}

	return $processor->get_updated_html();
}
add_filter( 'edd_checkout_button_purchase', __NAMESPACE__ . '\edd_checkout_button_purchase' );

/**
 * Whether block markup contains a block, looking inside the patterns it
 * references (product templates place the Buy Button through a pattern).
 *
 * @param string $block_name Block name.
 * @param string $content    Block markup.
 * @param int    $depth      Pattern nesting level, to stop on a pattern that includes itself.
 */
function content_has_block( string $block_name, string $content, int $depth = 0 ): bool {
	if ( has_block( $block_name, $content ) ) {
		return true;
	}

	if ( $depth > 3 || ! preg_match_all( '#<!-- wp:pattern \{"slug":"([^"]+)"#', $content, $matches ) ) {
		return false;
	}

	$registry = \WP_Block_Patterns_Registry::get_instance();
	foreach ( $matches[1] as $slug ) {
		$pattern = $registry->get_registered( $slug );
		if ( $pattern && content_has_block( $block_name, (string) $pattern['content'], $depth + 1 ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Skip EDD's purchase button under the product content when the block
 * template already places an EDD Buy Button block.
 *
 * @param string $template Template path.
 */
function edd_skip_appended_purchase_link( string $template ): string {
	global $_wp_current_template_content;

	if ( is_singular( 'download' ) && is_string( $_wp_current_template_content ) && content_has_block( 'edd/buy-button', $_wp_current_template_content ) ) {
		remove_action( 'edd_after_download_content', 'edd_append_purchase_link' );
	}

	return $template;
}
add_filter( 'template_include', __NAMESPACE__ . '\edd_skip_appended_purchase_link', 100 );

/**
 * Link product cards with license options to the product page.
 *
 * In a product grid, the purchase form for a product with variable prices
 * lists every license inside a narrow card. Outside that product's own page,
 * show a link to choose a license instead, as stores usually do, with the
 * lowest price when the block shows the price on its button. Covers the Buy
 * Button and Downloads blocks, which both use this form.
 *
 * @param string               $form Purchase form markup.
 * @param array<string, mixed> $args Purchase link arguments.
 * @return string
 */
function edd_card_license_link( string $form, array $args ): string {
	$download_id = (int) ( $args['download_id'] ?? 0 );

	if ( ! $download_id || ! edd_has_variable_prices( $download_id ) ) {
		return $form;
	}

	if ( is_singular( 'download' ) && get_queried_object_id() === $download_id ) {
		return $form;
	}

	$label = empty( $args['price'] ) ? __( 'Choose options', 'digimia' ) : sprintf(
		/* translators: %s: lowest price of the product. */
		__( 'From %s &ndash; Options', 'digimia' ),
		edd_currency_filter( edd_format_amount( edd_get_lowest_price_option( $download_id ) ) )
	);

	return sprintf(
		'<div class="edd_purchase_submit_wrapper"><a class="edd-submit wp-element-button" href="%1$s">%2$s</a></div>',
		esc_url( get_permalink( $download_id ) ),
		wp_kses_post( $label )
	);
}
add_filter( 'edd_purchase_download_form', __NAMESPACE__ . '\edd_card_license_link', 10, 2 );

/**
 * Category chips are links, not headings.
 *
 * The Terms block always wraps each term name in an `<h3>`. In a chip row
 * (`digimia-term-chips`, under the store search) those would be a run of
 * headings that skip levels after the page title, so they become paragraphs.
 *
 * @param string               $content Rendered block.
 * @param array<string, mixed> $block   Parsed block.
 * @return string
 */
function edd_term_chips_markup( string $content, array $block ): string {
	$classes = explode( ' ', (string) ( $block['attrs']['className'] ?? '' ) );

	if ( ! in_array( 'digimia-term-chips', $classes, true ) ) {
		return $content;
	}

	return (string) preg_replace( '#<(/?)h3\b#', '<$1p', $content );
}
add_filter( 'render_block_edd/terms', __NAMESPACE__ . '\edd_term_chips_markup', 10, 2 );

/**
 * Load the first product image on the shop page straight away.
 *
 * The Downloads block runs its own query, outside the main loop, so WordPress
 * lazy-loads every image in it. On the shop page the grid is the page, and its
 * first image is the largest paint: it loads eagerly, with high priority.
 * `sizes="auto"` only applies to lazy images, so it goes too.
 *
 * @param string $content Rendered block.
 * @return string
 */
function edd_shop_first_image( string $content ): string {
	static $done = false;

	if ( $done || ! is_post_type_archive( 'download' ) ) {
		return $content;
	}

	$tag = new \WP_HTML_Tag_Processor( $content );
	if ( ! $tag->next_tag( 'img' ) ) {
		return $content;
	}

	$done  = true;
	$sizes = (string) $tag->get_attribute( 'sizes' );
	$tag->remove_attribute( 'loading' );
	$tag->set_attribute( 'fetchpriority', 'high' );
	if ( str_starts_with( $sizes, 'auto,' ) ) {
		$tag->set_attribute( 'sizes', ltrim( substr( $sizes, 5 ) ) );
	}

	return $tag->get_updated_html();
}
add_filter( 'render_block_edd/downloads', __NAMESPACE__ . '\edd_shop_first_image' );

/**
 * Product titles on the shop page are h2.
 *
 * The Downloads block prints each title as an h3, which suits a grid under a
 * section heading. On the shop page the grid sits right under the page's H1,
 * so the titles move up a level and the outline no longer skips one.
 *
 * @param string $content Rendered block.
 * @return string
 */
function edd_shop_title_level( string $content ): string {
	if ( ! is_post_type_archive( 'download' ) ) {
		return $content;
	}

	return str_replace( array( '<h3', '</h3>' ), array( '<h2', '</h2>' ), $content );
}
add_filter( 'render_block_edd/downloads', __NAMESPACE__ . '\edd_shop_title_level' );

/**
 * Downloads grid: the price beside the buy button, as in the product cards.
 *
 * EDD prints the price under the excerpt and the button in the card's footer.
 * The price moves into the footer, where the styles set the two in a row. A
 * product with license options shows "From" and its lowest price, as the cards
 * do, instead of EDD's price range.
 *
 * @param string               $content Rendered block.
 * @param array<string, mixed> $block   Parsed block.
 * @return string
 */
function edd_downloads_price_beside_button( string $content, array $block ): string {
	// Both default to on. Without either, there is nothing to pair.
	if ( false === ( $block['attrs']['price'] ?? true ) || false === ( $block['attrs']['purchase_link'] ?? true ) ) {
		return $content;
	}

	return (string) preg_replace_callback(
		'#(<div class="edd-blocks__download-price">.*?</div>)(.*?<footer class="edd-blocks__download-footer">)#s',
		static function ( array $m ): string {
			$price = $m[1];

			if ( preg_match( '#<span class="edd_price edd_price_range_low"[^>]*>.*?</span>#s', $price, $low ) ) {
				$price = '<div class="edd-blocks__download-price">' . sprintf(
					/* translators: %s: lowest price of the product. */
					esc_html__( 'From %s', 'digimia' ),
					'<span class="digimia-price-amount">' . $low[0] . '</span>'
				) . '</div>';
			}

			return $m[2] . $price;
		},
		$content
	);
}
add_filter( 'render_block_edd/downloads', __NAMESPACE__ . '\edd_downloads_price_beside_button', 10, 2 );

/**
 * Two-column checkout by default.
 *
 * EDD creates its Checkout page with a bare `edd/checkout` block, which renders
 * as one narrow column. When no layout is chosen, use EDD's two-column layout
 * (form beside the order summary) at wide width. A layout set in the block
 * settings is kept.
 *
 * @param array<string, mixed> $block Parsed block.
 * @return array<string, mixed>
 */
function edd_checkout_default_layout( array $block ): array {
	if ( 'edd/checkout' !== ( $block['blockName'] ?? '' ) || ! empty( $block['attrs']['layout'] ) ) {
		return $block;
	}

	$block['attrs']['layout'] = 'two-thirds';
	$block['attrs']['align']  = $block['attrs']['align'] ?? 'wide';

	return $block;
}
add_filter( 'render_block_data', __NAMESPACE__ . '\edd_checkout_default_layout' );

/**
 * Pill-shaped PayPal buttons, matching the theme buttons.
 *
 * PayPal draws the buttons in its own frame, so only the options its SDK
 * accepts can change; the brand colors stay PayPal's.
 *
 * @param array<string, string> $styles PayPal button styles.
 * @return array<string, string>
 */
function edd_paypal_button_shape( array $styles ): array {
	$styles['shape'] = 'pill';

	return $styles;
}
add_filter( 'edd_paypal_smart_button_style', __NAMESPACE__ . '\edd_paypal_button_shape' );

/**
 * Add-to-cart feedback on the clicked button (src/js/edd-cart-feedback.js).
 *
 * Depends on EDD's `edd-ajax` script, so it only prints where EDD's AJAX
 * add-to-cart runs.
 */
function edd_enqueue_cart_feedback(): void {
	if ( ! function_exists( 'edd_get_option' ) ) {
		return;
	}

	wp_enqueue_script(
		'digimia-edd-cart-feedback',
		get_template_directory_uri() . '/assets/js/edd-cart-feedback.js',
		array( 'jquery', 'edd-ajax' ),
		wp_get_theme()->get( 'Version' ),
		array( 'in_footer' => true )
	);
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\edd_enqueue_cart_feedback', 20 );

/**
 * Load EDD's Cart Preview drawer on every store page when it is enabled.
 *
 * EDD looks for buy buttons and the mini cart in the page's own content. In a
 * block theme they live in templates, patterns, and the header part (every
 * header pattern has the mini cart), so the drawer would not load on the shop
 * archive or pattern-built pages until the cart already had an item. EDD still
 * skips it on the checkout page and when the setting is off.
 */
add_filter( 'edd_cart_preview_should_load', '__return_true' );

/**
 * "Products" on the confirmation and receipt as an h2.
 *
 * EDD prints an h3 right under the page title (h1), which skips a level.
 *
 * @param string $content Rendered block.
 * @return string
 */
function edd_receipt_heading_level( string $content ): string {
	return (string) preg_replace( '#<(/?)h3\b#', '<$1h2', $content );
}
add_filter( 'render_block_edd/confirmation', __NAMESPACE__ . '\edd_receipt_heading_level' );
add_filter( 'render_block_edd/receipt', __NAMESPACE__ . '\edd_receipt_heading_level' );

/**
 * Header account link: Account when signed in, Sign in otherwise.
 *
 * The header patterns place an icon-only Button with the
 * `digimia-account-link` class before the mini cart. Its saved link is the
 * Account page; for visitors who are not signed in it points to the EDD login
 * page instead, with a matching label for screen readers.
 *
 * @param string               $content Rendered block.
 * @param array<string, mixed> $block   Parsed block.
 * @return string
 */
function edd_header_account_link( string $content, array $block ): string {
	$classes = explode( ' ', (string) ( $block['attrs']['className'] ?? '' ) );

	if ( ! in_array( 'digimia-account-link', $classes, true ) || is_user_logged_in() ) {
		return $content;
	}

	$tag = new \WP_HTML_Tag_Processor( $content );
	if ( $tag->next_tag( 'a' ) ) {
		$tag->set_attribute( 'href', edd_page_url( 'login_page', '/login/' ) );
		$tag->set_attribute( 'aria-label', __( 'Sign in', 'digimia' ) );
	}

	return (string) preg_replace(
		'#(<span class="screen-reader-text">).*?(</span>)#s',
		'$1' . esc_html__( 'Sign in', 'digimia' ) . '$2',
		$tag->get_updated_html(),
		1
	);
}
add_filter( 'render_block_core/button', __NAMESPACE__ . '\edd_header_account_link', 20, 2 );

/**
 * Name the store templates in the Site Editor. WordPress names only the
 * templates it knows, so the shop and the product category and tag templates
 * would show their file names.
 *
 * @param array<string, array<string, string>> $types Template slug => title and description.
 * @return array<string, array<string, string>>
 */
function edd_template_types( array $types ): array {
	return $types + array(
		'archive-download'           => array(
			'title'       => _x( 'Shop', 'template name', 'digimia' ),
			'description' => __( 'Displays every download.', 'digimia' ),
		),
		'taxonomy-download_category' => array(
			'title'       => _x( 'Product category', 'template name', 'digimia' ),
			'description' => __( 'Displays the downloads in a product category, beside a sidebar to search and browse.', 'digimia' ),
		),
		'taxonomy-download_tag'      => array(
			'title'       => _x( 'Product tag', 'template name', 'digimia' ),
			'description' => __( 'Displays the downloads with a product tag, beside a sidebar to search and browse.', 'digimia' ),
		),
	);
}
add_filter( 'default_template_types', __NAMESPACE__ . '\edd_template_types' );

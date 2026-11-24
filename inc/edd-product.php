<?php
/**
 * Product page helpers for the single download templates.
 *
 * Display-only: product facts for core blocks through block bindings, related
 * products for a Query Loop, and the breadcrumb taxonomy. EDD owns the data.
 *
 * @package digimia
 */

declare(strict_types=1);

namespace Digimia;

/**
 * Facts a block can bind to with the `digimia/product` source.
 *
 * @return array<string, string> Key => label.
 */
function download_fact_keys(): array {
	return array(
		'price'      => __( 'Product price', 'digimia' ),
		'price_from' => __( 'Lowest price', 'digimia' ),
		'buy_label'  => __( 'Buy button label', 'digimia' ),
		'files'      => __( 'Number of files', 'digimia' ),
		'formats'    => __( 'File formats', 'digimia' ),
		'version'    => __( 'Version', 'digimia' ),
		'sales'      => __( 'Number of sales', 'digimia' ),
		'rating'     => __( 'Average rating', 'digimia' ),
	);
}

/**
 * One product fact as display text, or an empty string when it does not apply.
 *
 * - price: "Free", the price, or for license options the default option's
 *   price (the one preselected in the Buy Button; edd-product-price.js keeps
 *   it in step with the chosen license).
 * - price_from: "From $49" for license options, otherwise as price.
 * - buy_label: "Choose a license" for license options, otherwise "Buy now".
 * - files: "3 files".
 * - formats: file extensions, e.g. "FIG, PDF, ZIP".
 * - version: the Software Licensing version, when that extension is used.
 * - sales: "1,240 sales". Not placed by the templates; add it where social
 *   proof helps.
 * - rating: "4.7 (3 reviews)", linked to the reviews, with EDD Reviews
 *   (inc/edd-reviews.php). Empty without approved reviews.
 *
 * @param int    $download_id Download ID.
 * @param string $key         Fact key.
 */
function download_fact( int $download_id, string $key ): string {
	if ( ! $download_id || 'download' !== get_post_type( $download_id ) || ! function_exists( 'edd_get_download_files' ) ) {
		return '';
	}

	switch ( $key ) {
		case 'price':
			if ( edd_is_free_download( $download_id ) ) {
				return __( 'Free', 'digimia' );
			}

			$amount = edd_get_download_price( $download_id );
			if ( edd_has_variable_prices( $download_id ) ) {
				$prices  = edd_get_variable_prices( $download_id );
				$default = edd_get_default_variable_price( $download_id );
				$amount  = $prices[ $default ]['amount'] ?? edd_get_lowest_price_option( $download_id );
			}

			return price_text( $amount );

		case 'price_from':
			if ( edd_has_variable_prices( $download_id ) && ! edd_is_free_download( $download_id ) ) {
				return sprintf(
					/* translators: %s: lowest price of the product. */
					__( 'From %s', 'digimia' ),
					price_text( edd_get_lowest_price_option( $download_id ) )
				);
			}

			return download_fact( $download_id, 'price' );

		case 'buy_label':
			return edd_has_variable_prices( $download_id ) ? __( 'Choose a license', 'digimia' ) : __( 'Buy now', 'digimia' );

		case 'files':
			$count = count( (array) edd_get_download_files( $download_id ) );
			/* translators: %s: number of files in the download. */
			return $count ? sprintf( _n( '%s file', '%s files', $count, 'digimia' ), number_format_i18n( $count ) ) : '';

		case 'formats':
			$formats = array();
			foreach ( (array) edd_get_download_files( $download_id ) as $file ) {
				$path      = (string) wp_parse_url( (string) ( $file['file'] ?? '' ), PHP_URL_PATH );
				$extension = strtoupper( pathinfo( $path, PATHINFO_EXTENSION ) );
				if ( $extension && strlen( $extension ) <= 5 ) {
					$formats[ $extension ] = true;
				}
			}
			ksort( $formats );

			return implode( ', ', array_keys( $formats ) );

		case 'version':
			return (string) get_post_meta( $download_id, '_edd_sl_version', true );

		case 'sales':
			$sales = (int) edd_get_download_sales_stats( $download_id );
			/* translators: %s: number of sales. */
			return $sales ? sprintf( _n( '%s sale', '%s sales', $sales, 'digimia' ), number_format_i18n( $sales ) ) : '';

		case 'rating':
			$stats = review_stats( $download_id );
			$count = $stats['count'];
			return $count ? sprintf(
				/* translators: 1: average rating, e.g. 4.7; 2: number of reviews. */
				_n( '%1$s (%2$s review)', '%1$s (%2$s reviews)', $count, 'digimia' ),
				number_format_i18n( $stats['average'], 1 ),
				number_format_i18n( $count )
			) : '';
	}

	return '';
}

/**
 * An amount in the store's currency, as text: "$49.00".
 *
 * @param float|int|string $amount Amount.
 */
function price_text( $amount ): string {
	return html_entity_decode( edd_currency_filter( edd_format_amount( $amount ) ), ENT_QUOTES, 'UTF-8' );
}

/**
 * Register the `digimia/product` block bindings source.
 *
 * A Paragraph or Heading bound to it shows a fact of the download in context
 * (the product page, or a Query Loop item), e.g.
 * `"metadata":{"bindings":{"content":{"source":"digimia/product","args":{"key":"files"}}}}`.
 */
function register_download_bindings(): void {
	if ( ! function_exists( 'register_block_bindings_source' ) ) {
		return;
	}

	register_block_bindings_source(
		'digimia/product',
		array(
			'label'              => __( 'Product details', 'digimia' ),
			'uses_context'       => array( 'postId' ),
			'get_value_callback' => static function ( array $args, \WP_Block $block ): string {
				$download_id = (int) ( $block->context['postId'] ?? 0 );
				$key         = (string) ( $args['key'] ?? '' );
				$value       = esc_html( download_fact( $download_id, $key ) );

				// The rating links to the reviews, with the full rating for screen readers.
				if ( 'rating' === $key && '' !== $value ) {
					$stats = review_stats( $download_id );
					$count = $stats['count'];
					$value = sprintf(
						'<a href="%1$s" aria-label="%2$s">%3$s</a>',
						esc_url( get_permalink( $download_id ) . '#edd-reviews' ),
						/* translators: 1: average rating, e.g. 4.7; 2: number of reviews. */
						esc_attr( sprintf( _n( 'Rated %1$s out of 5 from %2$s review', 'Rated %1$s out of 5 from %2$s reviews', $count, 'digimia' ), number_format_i18n( $stats['average'], 1 ), number_format_i18n( $count ) ) ),
						$value
					);
				}

				// "From" and the lowest price: the amount in its own element, so
				// the price styles can set "From" apart from it.
				if ( 'price_from' === $key && '' !== $value && edd_has_variable_prices( $download_id ) && ! edd_is_free_download( $download_id ) ) {
					$value = sprintf(
						/* translators: %s: lowest price of the product. */
						esc_html__( 'From %s', 'digimia' ),
						'<span class="digimia-price-amount">' . esc_html( price_text( edd_get_lowest_price_option( $download_id ) ) ) . '</span>'
					);
				}

				return $value;
			},
		)
	);
}
add_action( 'init', __NAMESPACE__ . '\register_download_bindings' );

/**
 * Editor labels and the field list for the `digimia/product` source.
 */
function enqueue_download_bindings_editor(): void {
	wp_enqueue_script(
		'digimia-product-bindings',
		get_template_directory_uri() . '/assets/js/product-bindings.js',
		array( 'wp-blocks' ),
		wp_get_theme()->get( 'Version' ),
		true
	);
	wp_add_inline_script(
		'digimia-product-bindings',
		'window.digimiaProductFacts = ' . wp_json_encode( download_fact_keys() ) . ';',
		'before'
	);
}
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_download_bindings_editor' );

/**
 * Drop a bound fact that does not apply, and a detail row left without a value.
 *
 * A product with no files has no "Files" row instead of an empty one. Rows are
 * groups with the `digimia-detail-row` class whose first paragraph is the label
 * (`digimia-detail-label`).
 *
 * @param string    $content Rendered block.
 * @param array     $block   Parsed block.
 * @param \WP_Block $instance Block instance.
 * @return string
 */
function drop_empty_download_facts( string $content, array $block, $instance ): string {
	foreach ( (array) ( $block['attrs']['metadata']['bindings'] ?? array() ) as $binding ) {
		if ( 'digimia/product' === ( $binding['source'] ?? '' )
			&& '' === download_fact( (int) ( $instance->context['postId'] ?? 0 ), (string) ( $binding['args']['key'] ?? '' ) ) ) {
			return '';
		}
	}

	if ( 'core/group' === $block['blockName'] && str_contains( (string) ( $block['attrs']['className'] ?? '' ), 'digimia-detail-row' ) ) {
		$value = preg_replace( '#<p[^>]*digimia-detail-label.*?</p>#s', '', $content, 1 );
		if ( '' === trim( wp_strip_all_tags( (string) $value ) ) ) {
			return '';
		}
	}

	return $content;
}
add_filter( 'render_block', __NAMESPACE__ . '\drop_empty_download_facts', 10, 3 );

/**
 * Related products: a Query Loop with the `digimia-related-downloads` class
 * lists other downloads from the product's categories, then the latest ones
 * when the categories run short. It never lists the product itself.
 *
 * The product ID is passed to the loop's Post Template through its query
 * context, read back in `related_downloads_query_vars()`.
 *
 * @param array<string, mixed> $context      Block context.
 * @param array<string, mixed> $parsed_block Parsed block.
 * @param \WP_Block|null       $parent_block Parent block.
 * @return array<string, mixed>
 */
function related_downloads_context( array $context, array $parsed_block, $parent_block ): array {
	if ( 'core/post-template' !== ( $parsed_block['blockName'] ?? '' )
		|| ! $parent_block instanceof \WP_Block
		|| ! str_contains( (string) ( $parent_block->parsed_block['attrs']['className'] ?? '' ), 'digimia-related-downloads' )
		|| ! is_singular( 'download' ) ) {
		return $context;
	}

	$context['query']                     = (array) ( $context['query'] ?? array() );
	$context['query']['digimiaRelatedTo'] = get_queried_object_id();

	return $context;
}
add_filter( 'render_block_context', __NAMESPACE__ . '\related_downloads_context', 10, 3 );

/**
 * Query vars for a related products loop.
 *
 * @param array<string, mixed> $query Query vars.
 * @param \WP_Block            $block Post Template block.
 * @return array<string, mixed>
 */
function related_downloads_query_vars( array $query, $block ): array {
	$download_id = (int) ( $block->context['query']['digimiaRelatedTo'] ?? 0 );
	if ( ! $download_id ) {
		return $query;
	}

	$count = max( 1, (int) ( $query['posts_per_page'] ?? 3 ) );
	$base  = array(
		'post_type'           => 'download',
		'post_status'         => 'publish',
		'fields'              => 'ids',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	$ids   = array();
	$terms = wp_get_post_terms( $download_id, 'download_category', array( 'fields' => 'ids' ) );
	if ( $terms && ! is_wp_error( $terms ) ) {
		$ids = get_posts(
			$base + array(
				'posts_per_page' => $count,
				'post__not_in'   => array( $download_id ), // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_post__not_in
				'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					array(
						'taxonomy' => 'download_category',
						'terms'    => $terms,
					),
				),
			)
		);
	}

	if ( count( $ids ) < $count ) {
		$ids = array_merge(
			$ids,
			get_posts(
				$base + array(
					'posts_per_page' => $count - count( $ids ),
					'post__not_in'   => array_merge( array( $download_id ), $ids ), // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_post__not_in
				)
			)
		);
	}

	unset( $query['post__not_in'], $query['tax_query'], $query['offset'] );
	$query['post__in'] = $ids ? $ids : array( 0 );
	$query['orderby']  = 'post__in';

	return $query;
}
add_filter( 'query_loop_block_query_vars', __NAMESPACE__ . '\related_downloads_query_vars', 10, 2 );

/**
 * Breadcrumbs on a product page go through its category, not its tags.
 *
 * @param array<string, mixed> $settings  Breadcrumb settings.
 * @param string               $post_type Post type.
 * @return array<string, mixed>
 */
function download_breadcrumb_taxonomy( array $settings, string $post_type ): array {
	if ( 'download' === $post_type && empty( $settings['taxonomy'] ) ) {
		$settings['taxonomy'] = 'download_category';
	}

	return $settings;
}
add_filter( 'block_core_breadcrumbs_post_type_settings', __NAMESPACE__ . '\download_breadcrumb_taxonomy', 10, 2 );

/**
 * Keep the big price in a purchase card in step with the chosen license
 * (src/js/edd-product-price.js). Loaded with the Buy Button block only.
 *
 * @param string $content Rendered block.
 */
function enqueue_product_price_script( string $content ): string {
	if ( is_singular( 'download' ) && ! wp_script_is( 'digimia-edd-product-price' ) ) {
		wp_enqueue_script(
			'digimia-edd-product-price',
			get_template_directory_uri() . '/assets/js/edd-product-price.js',
			array(),
			wp_get_theme()->get( 'Version' ),
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);
	}

	return $content;
}
add_filter( 'render_block_edd/buy-button', __NAMESPACE__ . '\enqueue_product_price_script' );

/**
 * "Choose your license" only above a product with license options.
 *
 * A Heading with the `digimia-license-heading` class is dropped on the page of
 * a product with a single price, where there is nothing to choose.
 *
 * @param string               $content Rendered block.
 * @param array<string, mixed> $block   Parsed block.
 * @return string
 */
function license_heading_only_with_options( string $content, array $block ): string {
	if ( ! str_contains( (string) ( $block['attrs']['className'] ?? '' ), 'digimia-license-heading' )
		|| ! is_singular( 'download' ) || ! function_exists( 'edd_has_variable_prices' ) ) {
		return $content;
	}

	return edd_has_variable_prices( get_queried_object_id() ) ? $content : '';
}
add_filter( 'render_block_core/heading', __NAMESPACE__ . '\license_heading_only_with_options', 10, 2 );

/**
 * The product's excerpt only when one was written.
 *
 * The product templates open with the excerpt, right above the description.
 * With no excerpt, WordPress makes one from the description, so its first
 * lines would show twice. Other products on the page (related products) keep
 * the automatic excerpt.
 *
 * @param string               $content  Rendered block.
 * @param array<string, mixed> $block    Parsed block.
 * @param \WP_Block            $instance Block instance.
 * @return string
 */
function product_excerpt_only_when_written( string $content, array $block, \WP_Block $instance ): string {
	$post_id = (int) ( $instance->context['postId'] ?? 0 );

	if ( ! is_singular( 'download' ) || get_queried_object_id() !== $post_id || has_excerpt( $post_id ) ) {
		return $content;
	}

	return '';
}
add_filter( 'render_block_core/post-excerpt', __NAMESPACE__ . '\product_excerpt_only_when_written', 10, 3 );

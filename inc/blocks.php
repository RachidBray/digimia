<?php
/**
 * Block registrations for Digimia.
 *
 * @package digimia
 */

declare(strict_types=1);

namespace Digimia;

/**
 * Register theme blocks.
 */
function digimia_register_blocks(): void {
	wp_register_script(
		'digimia-block-editor',
		get_theme_file_uri( 'assets/js/editor.js' ),
		array( 'wp-blocks', 'wp-element', 'wp-i18n' ),
		wp_get_theme()->get( 'Version' ),
		true
	);

	register_block_type_from_metadata(
		get_theme_file_path( 'blocks/theme-toggle' ),
		array(
			'render_callback' => __NAMESPACE__ . '\digimia_render_theme_toggle_block',
			'editor_script'   => 'digimia-block-editor',
		)
	);
}
add_action( 'init', __NAMESPACE__ . '\digimia_register_blocks' );

/**
 * Render callback for theme toggle block.
 *
 * @return string
 */
function digimia_render_theme_toggle_block(): string {
	ob_start();
	require get_theme_file_path( 'blocks/theme-toggle/render.php' );
	return (string) ob_get_clean();
}

/**
 * Leave the current post out of "Keep reading" queries.
 *
 * Applies to Query Loops whose Post Template has the `digimia-related` class
 * (the template patterns' related posts section).
 *
 * @param array<string, mixed> $query Query vars.
 * @param \WP_Block            $block Post Template block.
 * @return array<string, mixed>
 */
function related_posts_exclude_current( array $query, \WP_Block $block ): array {
	$classes = explode( ' ', (string) ( $block->attributes['className'] ?? '' ) );

	if ( is_singular() && in_array( 'digimia-related', $classes, true ) ) {
		$query['post__not_in'] = array_merge( (array) ( $query['post__not_in'] ?? array() ), array( get_queried_object_id() ) );
	}

	return $query;
}
add_filter( 'query_loop_block_query_vars', __NAMESPACE__ . '\related_posts_exclude_current', 10, 2 );

/**
 * Show the site title where a Site Logo block has no logo to render.
 *
 * Header and footer patterns use the Site Logo block, so a site without a
 * logo still shows its name instead of an empty space.
 *
 * @param string               $content Rendered block.
 * @param array<string, mixed> $block   Parsed block.
 * @return string
 */
function site_logo_fallback( string $content, array $block ): string {
	if ( '' !== trim( $content ) ) {
		return $content;
	}

	$attributes = array( 'level' => 0 );
	if ( 'center' === ( $block['attrs']['align'] ?? '' ) ) {
		$attributes['textAlign'] = 'center';
	}

	return render_block(
		array(
			'blockName'    => 'core/site-title',
			'attrs'        => $attributes,
			'innerBlocks'  => array(),
			'innerHTML'    => '',
			'innerContent' => array(),
		)
	);
}
add_filter( 'render_block_core/site-logo', __NAMESPACE__ . '\site_logo_fallback', 10, 2 );

/**
 * Give a logo without stored dimensions the block's width.
 *
 * WordPress cannot read the size of an SVG, so an SVG logo is stored as 0×0
 * (unless an SVG plugin fills it in) and the Site Logo block prints the image
 * without a width. In a flex header it then collapses to nothing. The block's
 * own width setting (e.g. 132 in the header patterns) is used instead; the
 * height follows the SVG's proportions.
 *
 * @param string               $content Rendered block.
 * @param array<string, mixed> $block   Parsed block.
 * @return string
 */
function site_logo_width( string $content, array $block ): string {
	$width = (int) ( $block['attrs']['width'] ?? 0 );

	if ( ! $width || ! str_contains( $content, 'custom-logo' ) ) {
		return $content;
	}

	$tag   = new \WP_HTML_Tag_Processor( $content );
	$query = array(
		'tag_name'   => 'img',
		'class_name' => 'custom-logo',
	);
	if ( $tag->next_tag( $query ) && ! (int) $tag->get_attribute( 'width' ) ) {
		$tag->set_attribute( 'width', (string) $width );
		$tag->remove_attribute( 'height' );
	}

	return $tag->get_updated_html();
}
add_filter( 'render_block_core/site-logo', __NAMESPACE__ . '\site_logo_width', 20, 2 );

/**
 * Folders of pattern images the theme handles: their URL path and their
 * directory, both ending in a slash. The theme's own, and any that
 * `digimia_image_folders` adds (Digimia Pro's, for its patterns' images).
 *
 * @return array<string, string> Directory by URL path.
 */
function image_folders(): array {
	$folders = array(
		(string) wp_parse_url( get_template_directory_uri(), PHP_URL_PATH ) . '/patterns/images/' => get_theme_file_path( 'patterns/images/' ),
	);

	/**
	 * Filters the folders of pattern images whose illustrations are inlined
	 * and whose photos get their width and height.
	 *
	 * @param array<string, string> $folders Directory by URL path, both ending in a slash.
	 */
	return (array) apply_filters( 'digimia_image_folders', $folders );
}

/**
 * The file of a pattern image from one of the image folders, or an empty
 * string for any other image.
 *
 * @param string $src Image URL.
 */
function pattern_image_file( string $src ): string {
	// Match on the path only: content saved over http (or before a domain
	// change) still points at the same file.
	$path = (string) wp_parse_url( $src, PHP_URL_PATH );

	foreach ( image_folders() as $prefix => $dir ) {
		if ( str_starts_with( $path, $prefix ) ) {
			return trailingslashit( $dir ) . basename( $path );
		}
	}

	return '';
}

/**
 * Inline the theme's illustrations so they follow the active palette.
 *
 * The `patterns/images/digimia-*.svg` files color their shapes with palette
 * custom properties, falling back to the default palette. Loaded through an
 * `<img>`, an SVG cannot see the page's custom properties, so on the front end
 * an Image block showing one of these files gets the SVG markup itself. The
 * block keeps its `<img>` in the editor, so it can still be replaced.
 *
 * @param string $content Rendered block.
 * @return string
 */
function inline_theme_illustration( string $content ): string {
	if ( ! str_contains( $content, '/patterns/images/digimia-' ) ) {
		return $content;
	}

	return (string) preg_replace_callback(
		'/<img\b[^>]*>/i',
		static function ( array $matches ): string {
			$img = new \WP_HTML_Tag_Processor( $matches[0] );
			$img->next_tag();
			$src  = (string) $img->get_attribute( 'src' );
			$file = preg_match( '/^digimia-[a-z0-9-]+\.svg$/', basename( (string) wp_parse_url( $src, PHP_URL_PATH ) ) ) ? pattern_image_file( $src ) : '';

			if ( '' === $file ) {
				return $matches[0];
			}

			$svg = is_readable( $file ) ? (string) file_get_contents( $file ) : ''; // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Local theme or plugin file.

			if ( '' === $svg ) {
				return $matches[0];
			}

			// IDs must stay unique when an illustration appears more than once.
			$suffix = wp_unique_id( '-' );
			$svg    = preg_replace( '/\b(id="|url\(#)(dg-[a-z-]+)/', '$1$2' . $suffix, $svg );

			$tag = new \WP_HTML_Tag_Processor( (string) $svg );
			if ( ! $tag->next_tag( 'svg' ) ) {
				return $matches[0];
			}

			$alt = (string) $img->get_attribute( 'alt' );
			$tag->add_class( 'digimia-illustration' );
			if ( '' === $alt ) {
				$tag->set_attribute( 'aria-hidden', 'true' );
			} else {
				$tag->set_attribute( 'role', 'img' );
				$tag->set_attribute( 'aria-label', $alt );
			}
			foreach ( array( 'class', 'style' ) as $name ) {
				$value = $img->get_attribute( $name );
				if ( is_string( $value ) && '' !== $value ) {
					'class' === $name ? $tag->add_class( $value ) : $tag->set_attribute( 'style', $value );
				}
			}

			return $tag->get_updated_html();
		},
		$content
	);
}
add_filter( 'render_block_core/image', __NAMESPACE__ . '\inline_theme_illustration' );

/**
 * Width and height of a raster image shipped in a pattern image folder.
 *
 * @param string $src Image URL.
 * @return array{0: int, 1: int}|null Null for any other image.
 */
function theme_image_size( string $src ): ?array {
	static $sizes = array();

	$file = preg_match( '/^[a-z0-9-]+\.(webp|png|jpe?g)$/', basename( (string) wp_parse_url( $src, PHP_URL_PATH ) ) ) ? pattern_image_file( $src ) : '';

	if ( '' === $file ) {
		return null;
	}

	if ( ! array_key_exists( $file, $sizes ) ) {
		$size           = is_readable( $file ) ? wp_getimagesize( $file ) : false;
		$sizes[ $file ] = $size ? array( (int) $size[0], (int) $size[1] ) : null;
	}

	return $sizes[ $file ];
}

/**
 * Give the theme's pattern photos their width and height.
 *
 * WordPress lazy-loads an image, and fetches the first large one with high
 * priority, only when the image has both attributes. A theme file has no
 * attachment to read them from, so without this every photo on a page loaded
 * at once and a product image further down got the high priority instead of
 * the hero. The size comes from the file itself.
 *
 * @param string $content Rendered block.
 * @return string
 */
function theme_image_dimensions( string $content ): string {
	if ( ! str_contains( $content, '/patterns/images/' ) ) {
		return $content;
	}

	$tag = new \WP_HTML_Tag_Processor( $content );

	while ( $tag->next_tag( 'img' ) ) {
		$size = null === $tag->get_attribute( 'width' ) ? theme_image_size( (string) $tag->get_attribute( 'src' ) ) : null;

		if ( $size ) {
			$tag->set_attribute( 'width', (string) $size[0] );
			$tag->set_attribute( 'height', (string) $size[1] );
		}
	}

	return $tag->get_updated_html();
}
add_filter( 'render_block_core/image', __NAMESPACE__ . '\theme_image_dimensions' );
add_filter( 'render_block_core/cover', __NAMESPACE__ . '\theme_image_dimensions' );
add_filter( 'render_block_core/media-text', __NAMESPACE__ . '\theme_image_dimensions' );

/**
 * Index of the top-level block of the main content now rendering.
 *
 * @param string $action `get`, `next` (a top-level block starts), or `reset` (the content starts).
 * @return int -1 before the first block.
 */
function content_section( string $action = 'get' ): int {
	static $index = -1;

	if ( 'reset' === $action ) {
		$index = -1;
	} elseif ( 'next' === $action ) {
		++$index;
	}

	return $index;
}

/**
 * Start counting sections when the main content renders.
 *
 * @param string $content Post content.
 * @return string
 */
function reset_content_sections( string $content ): string {
	content_section( 'reset' );
	return $content;
}
add_filter( 'the_content', __NAMESPACE__ . '\reset_content_sections', 8 );

/**
 * Number each top-level block of the main content as it starts to render.
 *
 * The number travels with the block (`digimiaSection`), so the filter that
 * sees the finished block knows which section it was.
 *
 * @param array<string, mixed> $parsed_block Block about to render.
 * @param array<string, mixed> $source_block Block as parsed.
 * @param \WP_Block|null       $parent_block Parent block, null at the top level.
 * @return array<string, mixed>
 */
function count_content_sections( array $parsed_block, array $source_block, $parent_block = null ): array {
	if ( null === $parent_block && doing_filter( 'the_content' ) && in_the_loop() && is_main_query() ) {
		$parsed_block['digimiaSection'] = content_section( 'next' );
	}

	return $parsed_block;
}
add_filter( 'render_block_data', __NAMESPACE__ . '\count_content_sections', 10, 3 );

/**
 * Load the images in a page's first section straight away, the largest first.
 *
 * WordPress keeps the first three images of the content eager, counting every
 * image, and fetches the first large one with high priority. A row of covers
 * or avatars in a hero pushed the hero photo into lazy loading and took its
 * priority (the Books hero, whose photo is the largest paint on a desktop). A
 * page built from patterns opens with its hero, so once the first top-level
 * block has rendered, every image in it loads eagerly, its largest image gets
 * the high priority, and each counts toward the eager images, so the photos
 * below the hero wait until they are near the screen.
 *
 * @param string               $content Rendered block.
 * @param array<string, mixed> $block   Parsed block.
 * @return string
 */
function eager_hero_images( string $content, array $block ): string {
	if ( 0 !== ( $block['digimiaSection'] ?? null ) || ! str_contains( $content, '<img' ) ) {
		return $content;
	}

	$tag      = new \WP_HTML_Tag_Processor( $content );
	$largest  = 0;
	$priority = false;
	$index    = 0;
	$pick     = -1;

	while ( $tag->next_tag( 'img' ) ) {
		if ( null !== $tag->get_attribute( 'fetchpriority' ) ) {
			$priority = true;
		}
		if ( null === $tag->get_attribute( 'loading' ) ) {
			$tag->set_attribute( 'loading', 'eager' );
			wp_increase_content_media_count();

			$pixels = image_pixels( $tag );
			if ( $pixels > $largest ) {
				$largest = $pixels;
				$pick    = $index;
			}
		}
		++$index;
	}

	/** This filter is documented in wp-includes/media.php */
	$min_pixels = apply_filters( 'wp_min_priority_img_pixels', 50000 ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Core's own threshold, so a site's setting applies here too.

	if ( $priority || $pick < 0 || $largest < $min_pixels ) {
		return $tag->get_updated_html();
	}

	$tag = new \WP_HTML_Tag_Processor( $tag->get_updated_html() );
	for ( $i = 0; $i <= $pick; $i++ ) {
		$tag->next_tag( 'img' );
	}
	$tag->set_attribute( 'fetchpriority', 'high' );
	wp_high_priority_element_flag( false );

	return $tag->get_updated_html();
}
add_filter( 'render_block', __NAMESPACE__ . '\eager_hero_images', 10, 2 );

/**
 * Pixel count of the image at the tag processor's cursor.
 *
 * From its width and height, from the file for a theme image whose block has
 * not been given them yet (a top-level Cover), or, for a Media Library image,
 * from the attachment the `wp-image-{id}` class names.
 *
 * @param \WP_HTML_Tag_Processor $tag Processor on an `<img>`.
 * @return int
 */
function image_pixels( \WP_HTML_Tag_Processor $tag ): int {
	$width  = (int) $tag->get_attribute( 'width' );
	$height = (int) $tag->get_attribute( 'height' );

	if ( ! $width || ! $height ) {
		list( $width, $height ) = theme_image_size( (string) $tag->get_attribute( 'src' ) ) ?? array( 0, 0 );
	}

	if ( ( ! $width || ! $height ) && preg_match( '/\bwp-image-(\d+)\b/', (string) $tag->get_attribute( 'class' ), $match ) ) {
		$size = wp_image_src_get_dimensions( (string) $tag->get_attribute( 'src' ), (array) wp_get_attachment_metadata( (int) $match[1] ), (int) $match[1] );
		if ( $size ) {
			list( $width, $height ) = $size;
		}
	}

	return $width * $height;
}

/**
 * Load only the first counted image of the content eagerly.
 *
 * WordPress keeps the first three eager. After a hero those were photos
 * further down that shared a phone's bandwidth with it: the Fitness hero
 * painted a second later. A lazy image that is already on screen still loads
 * straight away.
 *
 * @return int
 */
function eager_image_count(): int {
	return 1;
}
add_filter( 'wp_omit_loading_attr_threshold', __NAMESPACE__ . '\eager_image_count' );

/**
 * Let keyboard users scroll code and tables that run wider than the screen.
 *
 * A code sample or a comparison table scrolls sideways on a phone, and a
 * scroll area can only be scrolled from the keyboard once it can take focus
 * (WCAG 2.1.1). The element that scrolls gets `tabindex="0"`: the `<code>` in
 * a Code block, the `<pre>` of a Preformatted block, and the Table block's
 * `<figure>`.
 *
 * @param string               $content Rendered block.
 * @param array<string, mixed> $block   Parsed block.
 * @return string
 */
function focusable_scroll_area( string $content, array $block ): string {
	$element = array(
		'core/code'         => 'code',
		'core/preformatted' => 'pre',
		'core/table'        => 'figure',
	)[ $block['blockName'] ] ?? '';

	$tag = new \WP_HTML_Tag_Processor( $content );
	if ( '' === $element || ! $tag->next_tag( $element ) || null !== $tag->get_attribute( 'tabindex' ) ) {
		return $content;
	}

	$tag->set_attribute( 'tabindex', '0' );

	return $tag->get_updated_html();
}
add_filter( 'render_block_core/code', __NAMESPACE__ . '\focusable_scroll_area', 10, 2 );
add_filter( 'render_block_core/preformatted', __NAMESPACE__ . '\focusable_scroll_area', 10, 2 );
add_filter( 'render_block_core/table', __NAMESPACE__ . '\focusable_scroll_area', 10, 2 );

/**
 * Skip a Categories block whose taxonomy is not registered, such as product
 * categories while Easy Digital Downloads is off. Core reads the taxonomy's
 * labels without checking that it exists, which logs PHP warnings.
 *
 * @param string|null          $pre_render   Content to use instead of rendering, or null.
 * @param array<string, mixed> $parsed_block Parsed block.
 * @return string|null
 */
function skip_categories_without_taxonomy( $pre_render, array $parsed_block ) {
	if ( 'core/categories' === $parsed_block['blockName'] && ! taxonomy_exists( $parsed_block['attrs']['taxonomy'] ?? 'category' ) ) {
		return '';
	}

	return $pre_render;
}
add_filter( 'pre_render_block', __NAMESPACE__ . '\skip_categories_without_taxonomy', 10, 2 );

/**
 * The theme's phone menu part holds a pattern reference, so its strings can be
 * translated. Core only recognises a Navigation block written directly in an
 * overlay part: it then renders that block as a plain `div` instead of a
 * second `nav` landmark, and turns off its own phone menu. So the pattern is
 * expanded into blocks before core reads the part. Parts saved in the Site
 * Editor already hold blocks and never reach this filter. The editor keeps
 * the reference (admin and REST requests), so opening the part leaves it unchanged.
 *
 * @param \WP_Block_Template|null $template Template part from a theme file.
 * @return \WP_Block_Template|null
 */
function expand_overlay_part_patterns( $template ) {
	if ( ! $template instanceof \WP_Block_Template || 'navigation-overlay' !== ( $template->area ?? '' ) || is_admin() || wp_is_serving_rest_request() ) {
		return $template;
	}

	$template->content = serialize_blocks( resolve_pattern_blocks( parse_blocks( $template->content ) ) );

	return $template;
}
add_filter( 'get_block_file_template', __NAMESPACE__ . '\expand_overlay_part_patterns' );

/**
 * Point text arrows the reading way on right-to-left sites. Patterns write
 * "Talk to us →" with the arrow outside the translated text, so a translation
 * cannot turn it. Only blocks that hold no other blocks are changed, so no
 * arrow is swapped twice.
 *
 * @param string $content Rendered block.
 */
function flip_text_arrows( string $content ): string {
	if ( ! is_rtl() ) {
		return $content;
	}
	return strtr(
		$content,
		array(
			'→'      => '←',
			'←'      => '→',
			'&rarr;' => '&larr;',
			'&larr;' => '&rarr;',
		)
	);
}
add_filter( 'render_block_core/paragraph', __NAMESPACE__ . '\flip_text_arrows' );
add_filter( 'render_block_core/heading', __NAMESPACE__ . '\flip_text_arrows' );
add_filter( 'render_block_core/button', __NAMESPACE__ . '\flip_text_arrows' );

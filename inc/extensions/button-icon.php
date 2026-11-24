<?php
/**
 * Button Icon Extension — Adds SVG icon support to core/button.
 *
 * Architecture:
 * 1. Uses the shared Digimia icon set (inc/icons.php, assets/icons/)
 * 2. Registers editor script + localizes icon data
 * 3. Injects SVG server-side via render_block (zero front-end JS)
 *
 * @package digimia
 */

declare(strict_types=1);

namespace Digimia\Extensions\ButtonIcon;

/**
 * Allowed SVG elements and attributes for sanitization.
 */
const ALLOWED_SVG_TAGS = array(
	'svg'      => array(
		'xmlns'           => true,
		'width'           => true,
		'height'          => true,
		'viewbox'         => true,
		'fill'            => true,
		'stroke'          => true,
		'stroke-width'    => true,
		'stroke-linecap'  => true,
		'stroke-linejoin' => true,
		'class'           => true,
		'aria-hidden'     => true,
		'focusable'       => true,
		'role'            => true,
	),
	'path'     => array(
		'd'    => true,
		'fill' => true,
	),
	'circle'   => array(
		'cx'   => true,
		'cy'   => true,
		'r'    => true,
		'fill' => true,
	),
	'rect'     => array(
		'x'      => true,
		'y'      => true,
		'width'  => true,
		'height' => true,
		'rx'     => true,
		'ry'     => true,
		'fill'   => true,
	),
	'line'     => array(
		'x1' => true,
		'x2' => true,
		'y1' => true,
		'y2' => true,
	),
	'polyline' => array(
		'points' => true,
		'fill'   => true,
	),
	'polygon'  => array(
		'points' => true,
		'fill'   => true,
	),
);

/**
 * Build the icon registry from the shared Digimia icon set.
 *
 * Uses a static cache so files are read only once per request.
 *
 * @return array<string, array{slug: string, label: string, svg: string}>
 */
function get_icon_registry(): array {
	static $registry = null;

	if ( null !== $registry ) {
		return $registry;
	}

	$registry = array();

	foreach ( \Digimia\icon_set() as $slug => $label ) {
		$file = \Digimia\icon_path( $slug );
		$raw  = $file ? file_get_contents( $file ) : ''; // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local file.

		if ( ! $raw ) {
			continue;
		}

		// Sanitize SVG through wp_kses. Kses lowercases attribute names; restore
		// viewBox, which is case-sensitive when the editor uses the SVG as an image.
		$svg = str_replace( ' viewbox=', ' viewBox=', wp_kses( $raw, ALLOWED_SVG_TAGS ) );

		// Fallback size (CSS sizes it from the button text) and accessibility attributes.
		$svg = str_replace(
			'<svg ',
			'<svg width="24" height="24" aria-hidden="true" focusable="false" ',
			$svg
		);

		$registry[ $slug ] = array(
			'slug'  => $slug,
			'label' => $label,
			'svg'   => $svg,
		);
	}

	return $registry;
}

/**
 * Enqueue editor assets for the button icon extension.
 */
function enqueue_editor_assets(): void {
	$asset_file = get_theme_file_path( 'assets/js/button-icon-editor.asset.php' );

	// Fallback if no asset file (non-wp-scripts build).
	if ( file_exists( $asset_file ) ) {
		$asset = require $asset_file;
	} else {
		$asset = array(
			'dependencies' => array(
				'wp-blocks',
				'wp-block-editor',
				'wp-components',
				'wp-compose',
				'wp-element',
				'wp-hooks',
				'wp-i18n',
			),
			'version'      => wp_get_theme()->get( 'Version' ),
		);
	}

	wp_enqueue_script(
		'digimia-button-icon-editor',
		get_theme_file_uri( 'assets/js/button-icon-editor.js' ),
		$asset['dependencies'],
		$asset['version'],
		true
	);

	// Pass icon registry to JS — one localize call, no extra HTTP requests.
	$icons = get_icon_registry();
	wp_localize_script(
		'digimia-button-icon-editor',
		'digimiaButtonIcons',
		array(
			'icons' => array_values( $icons ),
		)
	);

	wp_set_script_translations( 'digimia-button-icon-editor', 'digimia' );

	// Editor-only styles — enqueue for both parent frame and editor iframe.
	$css_file = get_theme_file_path( 'assets/styles/button-icon-editor.css' );
	if ( file_exists( $css_file ) ) {
		wp_enqueue_style(
			'digimia-button-icon-editor',
			get_theme_file_uri( 'assets/styles/button-icon-editor.css' ),
			array(),
			$asset['version']
		);

		// Also inject into the WP 6.6+ iframe-based editor canvas.
		add_editor_style( 'assets/styles/button-icon-editor.css' );
	}
}
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_editor_assets' );

/**
 * Inject SVG icon into core/button on the front end (server-side rendering).
 *
 * This is the performance-critical path — no front-end JS needed.
 *
 * @param string $block_content The block HTML.
 * @param array  $block         The parsed block data.
 * @return string Modified HTML with SVG injected.
 */
function render_button_with_icon( string $block_content, array $block ): string {
	// Early bail: not our concern.
	if ( 'core/button' !== $block['blockName'] ) {
		return $block_content;
	}

	$attrs = $block['attrs'] ?? array();
	$slug  = $attrs['digimiaIcon'] ?? '';

	if ( empty( $slug ) ) {
		return $block_content;
	}

	$registry = get_icon_registry();

	if ( ! isset( $registry[ $slug ] ) ) {
		return $block_content;
	}

	$position  = $attrs['digimiaIconPosition'] ?? 'left';
	$icon_only = 'only' === $position;

	// The icon is sized in CSS relative to the button's font size. Arrows are
	// marked so they can be mirrored when the page reads right to left.
	$icon_class = \Digimia\is_directional_icon( $slug ) ? 'wp-block-button__icon is-directional' : 'wp-block-button__icon';
	$icon_html  = '<span class="' . $icon_class . '" aria-hidden="true">' . $registry[ $slug ]['svg'] . '</span>';

	// Build CSS classes.
	$extra_classes = 'has-icon icon-position-' . esc_attr( $position );
	if ( $icon_only ) {
		$extra_classes .= ' is-icon-only';
	}

	// Add classes to the <a> element.
	$block_content = str_replace(
		'wp-block-button__link',
		'wp-block-button__link ' . $extra_classes,
		$block_content
	);

	// Icon-only mode: hide text, add aria-label from button text.
	if ( $icon_only ) {
		// Extract the visible text to use as aria-label.
		$button_text = '';
		if ( preg_match( '/<a\b[^>]*>(.+?)<\/a>/s', $block_content, $text_match ) ) {
			$button_text = wp_strip_all_tags( $text_match[1] );
		}

		// Add aria-label for accessibility.
		if ( $button_text ) {
			$block_content = preg_replace(
				'/(<a\b)/',
				'$1 aria-label="' . esc_attr( $button_text ) . '"',
				$block_content,
				1
			);
		}

		// Wrap existing text content in a visually-hidden span.
		$block_content = preg_replace(
			'/(<a\b[^>]*>)(.*?)(<\/a>)/s',
			'$1<span class="screen-reader-text">$2</span>$3',
			$block_content,
			1
		);

		// Inject icon inside the <a>, after the opening tag.
		$block_content = preg_replace(
			'/(<a\b[^>]*>)/',
			'$1' . $icon_html,
			$block_content,
			1
		);
	} elseif ( 'right' === $position ) {
		// Normal mode: inject icon before or after the text.
		$block_content = preg_replace(
			'/(<\/a>)/',
			$icon_html . '$1',
			$block_content,
			1
		);
	} else {
		$block_content = preg_replace(
			'/(<a\b[^>]*>)/',
			'$1' . $icon_html,
			$block_content,
			1
		);
	}

	return $block_content;
}
add_filter( 'render_block', __NAMESPACE__ . '\render_button_with_icon', 10, 2 );

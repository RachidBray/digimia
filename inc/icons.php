<?php
/**
 * Digimia icon set.
 *
 * One curated set of Phosphor icons (regular weight, MIT) in assets/icons/,
 * shared by the core Icon block (registered as the "Digimia" collection) and
 * the button icon extension. Phosphor draws every icon as a filled path, which
 * is what the Icon block's sanitizer and `fill: currentColor` styling expect.
 *
 * To add an icon, drop its SVG in assets/icons/ and add a label below.
 *
 * @package digimia
 */

declare(strict_types=1);

namespace Digimia;

/**
 * Icon slugs (file names in assets/icons/) and their labels.
 *
 * @return array<string, string>
 */
function icon_set(): array {
	return array(
		// Arrows and interface.
		'arrow-left'              => __( 'Arrow left', 'digimia' ),
		'arrow-right'             => __( 'Arrow right', 'digimia' ),
		'arrow-down'              => __( 'Arrow down', 'digimia' ),
		'arrow-up-right'          => __( 'Arrow up right', 'digimia' ),
		'arrow-square-out'        => __( 'External link', 'digimia' ),
		'caret-down'              => __( 'Caret down', 'digimia' ),
		'caret-right'             => __( 'Caret right', 'digimia' ),
		'plus'                    => __( 'Plus', 'digimia' ),
		'minus'                   => __( 'Minus', 'digimia' ),
		'x'                       => __( 'Close', 'digimia' ),
		'trash'                   => __( 'Trash', 'digimia' ),
		'check'                   => __( 'Check', 'digimia' ),
		'check-circle'            => __( 'Check circle', 'digimia' ),
		'magnifying-glass'        => __( 'Search', 'digimia' ),
		'list'                    => __( 'Menu', 'digimia' ),
		'sliders-horizontal'      => __( 'Settings', 'digimia' ),

		// Store and payment.
		'shopping-cart'           => __( 'Cart', 'digimia' ),
		'shopping-bag'            => __( 'Bag', 'digimia' ),
		'storefront'              => __( 'Store', 'digimia' ),
		'credit-card'             => __( 'Credit card', 'digimia' ),
		'wallet'                  => __( 'Wallet', 'digimia' ),
		'receipt'                 => __( 'Receipt', 'digimia' ),
		'tag'                     => __( 'Price tag', 'digimia' ),
		'percent'                 => __( 'Percent', 'digimia' ),
		'seal-percent'            => __( 'Discount badge', 'digimia' ),
		'gift'                    => __( 'Gift', 'digimia' ),
		'package'                 => __( 'Bundle', 'digimia' ),

		// Files and delivery.
		'download-simple'         => __( 'Download', 'digimia' ),
		'cloud-arrow-down'        => __( 'Cloud download', 'digimia' ),
		'file'                    => __( 'File', 'digimia' ),
		'file-text'               => __( 'Document', 'digimia' ),
		'file-zip'                => __( 'Zip file', 'digimia' ),
		'folder-open'             => __( 'Folder', 'digimia' ),
		'arrows-clockwise'        => __( 'Updates', 'digimia' ),
		'clock-counter-clockwise' => __( 'History', 'digimia' ),
		'infinity'                => __( 'Lifetime', 'digimia' ),

		// Trust and licensing.
		'shield'                  => __( 'Shield', 'digimia' ),
		'shield-check'            => __( 'Secure', 'digimia' ),
		'lock'                    => __( 'Lock', 'digimia' ),
		'key'                     => __( 'License key', 'digimia' ),
		'scales'                  => __( 'Terms', 'digimia' ),
		'certificate'             => __( 'Certificate', 'digimia' ),
		'seal-check'              => __( 'Verified', 'digimia' ),
		'medal'                   => __( 'Award', 'digimia' ),
		'thumbs-up'               => __( 'Thumbs up', 'digimia' ),

		// Support and people.
		'question'                => __( 'Help', 'digimia' ),
		'info'                    => __( 'Info', 'digimia' ),
		'warning'                 => __( 'Warning', 'digimia' ),
		'warning-circle'          => __( 'Warning circle', 'digimia' ),
		'lifebuoy'                => __( 'Support', 'digimia' ),
		'chat-circle'             => __( 'Chat', 'digimia' ),
		'envelope-simple'         => __( 'Email', 'digimia' ),
		'headset'                 => __( 'Headset', 'digimia' ),
		'user'                    => __( 'User', 'digimia' ),
		'users'                   => __( 'Team', 'digimia' ),
		'heart'                   => __( 'Heart', 'digimia' ),
		'star'                    => __( 'Star', 'digimia' ),
		'smiley'                  => __( 'Smile', 'digimia' ),

		// Design and products.
		'palette'                 => __( 'Palette', 'digimia' ),
		'pen-nib'                 => __( 'Pen tool', 'digimia' ),
		'pencil-simple'           => __( 'Pencil', 'digimia' ),
		'paint-brush'             => __( 'Brush', 'digimia' ),
		'text-aa'                 => __( 'Typography', 'digimia' ),
		'image'                   => __( 'Image', 'digimia' ),
		'layout'                  => __( 'Layout', 'digimia' ),
		'squares-four'            => __( 'Grid', 'digimia' ),
		'stack'                   => __( 'Layers', 'digimia' ),
		'frame-corners'           => __( 'Frame', 'digimia' ),
		'puzzle-piece'            => __( 'Component', 'digimia' ),
		'figma-logo'              => __( 'Figma', 'digimia' ),
		'code'                    => __( 'Code', 'digimia' ),
		'presentation-chart'      => __( 'Presentation', 'digimia' ),
		'monitor'                 => __( 'Desktop', 'digimia' ),
		'laptop'                  => __( 'Laptop', 'digimia' ),
		'device-mobile'           => __( 'Mobile', 'digimia' ),
		'cursor-click'            => __( 'Click', 'digimia' ),

		// Growth and time.
		'lightning'               => __( 'Lightning', 'digimia' ),
		'rocket'                  => __( 'Rocket', 'digimia' ),
		'sparkle'                 => __( 'Sparkle', 'digimia' ),
		'trend-up'                => __( 'Growth', 'digimia' ),
		'chart-bar'               => __( 'Chart', 'digimia' ),
		'target'                  => __( 'Target', 'digimia' ),
		'lightbulb'               => __( 'Idea', 'digimia' ),
		'clock'                   => __( 'Clock', 'digimia' ),
		'calendar-blank'          => __( 'Calendar', 'digimia' ),
		'play'                    => __( 'Play', 'digimia' ),
		'globe'                   => __( 'Globe', 'digimia' ),
		'sun'                     => __( 'Sun', 'digimia' ),
		'moon'                    => __( 'Moon', 'digimia' ),
		'github-logo'             => __( 'GitHub', 'digimia' ),

		// Integrations.
		'plugs-connected'         => __( 'Integration', 'digimia' ),
		'webhooks-logo'           => __( 'Webhooks', 'digimia' ),
		'slack-logo'              => __( 'Slack', 'digimia' ),
		'notion-logo'             => __( 'Notion', 'digimia' ),
		'stripe-logo'             => __( 'Stripe', 'digimia' ),
		'google-drive-logo'       => __( 'Google Drive', 'digimia' ),
		'microsoft-teams-logo'    => __( 'Microsoft Teams', 'digimia' ),
	);
}

/**
 * Absolute path of an icon's SVG file, or an empty string if it does not exist.
 *
 * @param string $slug Icon slug.
 */
function icon_path( string $slug ): string {
	$path = get_theme_file_path( 'assets/icons/' . sanitize_key( $slug ) . '.svg' );
	return is_readable( $path ) ? $path : '';
}

/**
 * Register the set as the "Digimia" collection of the core Icon block (WordPress 7.1+).
 */
function register_icon_collection(): void {
	if ( ! function_exists( 'wp_register_icon_collection' ) ) {
		return;
	}

	wp_register_icon_collection(
		'digimia',
		array(
			'label'       => __( 'Digimia', 'digimia' ),
			'description' => __( 'Icons for digital goods stores, in the Digimia style.', 'digimia' ),
		)
	);

	foreach ( icon_set() as $slug => $label ) {
		$path = icon_path( $slug );
		if ( $path ) {
			wp_register_icon(
				'digimia/' . $slug,
				array(
					'label'     => $label,
					'file_path' => $path,
				)
			);
		}
	}
}
add_action( 'init', __NAMESPACE__ . '\register_icon_collection' );

/**
 * Whether an icon points along the line of text (an arrow or caret to the
 * left or right), so it should be mirrored when the page reads right to left.
 *
 * @param string $slug Icon slug, with or without the `digimia/` prefix.
 */
function is_directional_icon( string $slug ): bool {
	return (bool) preg_match( '/(^|[\/-])(left|right)(-|$)/', $slug );
}

/**
 * Mark Icon blocks that show a directional icon, so the stylesheet can mirror
 * them right to left.
 *
 * @param string               $content Rendered block.
 * @param array<string, mixed> $block   Parsed block.
 */
function mark_directional_icon( string $content, array $block ): string {
	if ( ! is_directional_icon( (string) ( $block['attrs']['icon'] ?? '' ) ) ) {
		return $content;
	}
	$tag = new \WP_HTML_Tag_Processor( $content );
	if ( $tag->next_tag() ) {
		$tag->add_class( 'is-directional' );
	}
	return $tag->get_updated_html();
}
add_filter( 'render_block_core/icon', __NAMESPACE__ . '\mark_directional_icon', 10, 2 );

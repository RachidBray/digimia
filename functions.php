<?php
/**
 * Digimia theme: loads the theme's modules, then sets up its stylesheets,
 * block styles, pattern categories, and sidebar area.
 *
 * @package digimia
 * @author  AddictedToWeb
 * @license GNU General Public License v3 or later
 * @link    https://addictedtoweb.com
 */

namespace Digimia;

require_once get_template_directory() . '/inc/blocks.php';
require_once get_template_directory() . '/inc/icons.php';
require_once get_template_directory() . '/inc/extensions/button-icon.php';
require_once get_template_directory() . '/inc/edd.php';
require_once get_template_directory() . '/inc/edd-product.php';
require_once get_template_directory() . '/inc/edd-reviews.php';
require_once get_template_directory() . '/inc/edd-account.php';
require_once get_template_directory() . '/inc/admin-welcome.php';

/**
 * The editor shows the theme's stylesheet, and the inserter lists the theme's
 * patterns without WordPress's own.
 */
function setup() {
	add_editor_style( 'style.css' );
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\setup' );


/**
 * Loads the theme's stylesheet.
 */
function enqueue_styles() {
	// The file time busts browser caches on every build, not only on releases.
	$version = (string) filemtime( get_template_directory() . '/style.css' );
	wp_enqueue_style( sanitize_title( __NAMESPACE__ ), get_template_directory_uri() . '/style.css', array(), $version );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_styles' );


/**
 * Prevent FOUC (Flash of Unstyled Content) for dark/light mode.
 *
 * This inline script runs before anything renders, reading the user's
 * preference from localStorage or prefers-color-scheme, then applying
 * the data-theme attribute immediately on <html>.
 */
function theme_mode_inline_script() {
	?>
	<script>
	(function(){
		var s=localStorage.getItem('digimia-theme');
		if(s==='dark'||s==='light'){document.documentElement.setAttribute('data-theme',s);return;}
		if(window.matchMedia&&window.matchMedia('(prefers-color-scheme:dark)').matches){document.documentElement.setAttribute('data-theme','dark');}
		else{document.documentElement.setAttribute('data-theme','light');}
	})();
	</script>
	<?php
}
add_action( 'wp_head', __NAMESPACE__ . '\theme_mode_inline_script', 1 );


/**
 * Enqueue theme toggle script.
 */
function enqueue_theme_toggle_script() {
	wp_enqueue_script(
		'digimia-theme-toggle',
		get_template_directory_uri() . '/assets/js/theme-toggle.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_theme_toggle_script' );


/**
 * Block styles the theme adds to a block's Styles panel. Their CSS is in
 * src/scss/blocks/, built into the block's stylesheet below.
 */
function register_block_styles() {
	$styles = array(
		'core/list'         => array(
			'list-check' => __( 'Check', 'digimia' ),
			'list-cross' => __( 'Cross', 'digimia' ),
		),
		'core/details'      => array(
			'accordion' => __( 'Accordion', 'digimia' ),
			'card'      => __( 'Card', 'digimia' ),
		),
		'core/table'        => array(
			'comparison' => __( 'Comparison', 'digimia' ),
		),
		'core/cover'        => array(
			'blur-image-less' => __( 'Blurred Image', 'digimia' ),
		),
		'core/post-excerpt' => array(
			'excerpt-truncate-2' => __( 'Truncate 2 Lines', 'digimia' ),
			'excerpt-truncate-3' => __( 'Truncate 3 Lines', 'digimia' ),
			'excerpt-truncate-4' => __( 'Truncate 4 Lines', 'digimia' ),
		),
		'core/image'        => array(
			'rounded-full' => __( 'Rounded Full', 'digimia' ),
		),
		'core/post-terms'   => array(
			'term-button' => __( 'Button Style', 'digimia' ),
		),
	);

	foreach ( $styles as $block => $block_styles ) {
		foreach ( $block_styles as $name => $label ) {
			register_block_style(
				$block,
				array(
					'name'  => $name,
					'label' => $label,
				)
			);
		}
	}
}
add_action( 'init', __NAMESPACE__ . '\register_block_styles' );


/**
 * Block stylesheets: each assets/styles/core-<block>.css or edd-<block>.css
 * loads only on pages that show that block.
 */
function enqueue_block_stylesheets() {
	foreach ( glob( get_template_directory() . '/assets/styles/*.css' ) as $file ) {
		$name = basename( $file, '.css' );

		// core-post-excerpt.css belongs to core/post-excerpt; other files in the
		// folder (the welcome page, the editor) aren't block stylesheets.
		if ( ! preg_match( '/^(core|edd)-(.+)$/', $name, $block ) ) {
			continue;
		}

		wp_enqueue_block_style(
			"{$block[1]}/{$block[2]}",
			array(
				'handle' => "digimia-block-{$name}",
				'src'    => get_theme_file_uri( "assets/styles/{$name}.css" ),
				'path'   => get_theme_file_path( "assets/styles/{$name}.css" ),
			)
		);
	}
}
add_action( 'init', __NAMESPACE__ . '\enqueue_block_stylesheets' );


/**
 * The inserter's pattern categories, in the order it lists them.
 */
function register_pattern_categories() {
	$categories = array(
		'digimia/products'       => __( 'Products', 'digimia' ),
		'digimia/store'          => __( 'Store Pages', 'digimia' ),
		'digimia/hero'           => __( 'Hero', 'digimia' ),
		'digimia/features'       => __( 'Features', 'digimia' ),
		'digimia/pricing'        => __( 'Pricing & Licenses', 'digimia' ),
		'digimia/testimonial'    => __( 'Reviews', 'digimia' ),
		'digimia/faq'            => __( 'FAQ', 'digimia' ),
		'digimia/call-to-action' => __( 'Call To Action', 'digimia' ),
		'digimia/card'           => __( 'Cards', 'digimia' ),
		'digimia/pages'          => __( 'Pages', 'digimia' ),
		'digimia/posts'          => __( 'Journal', 'digimia' ),
		'digimia/header'         => __( 'Headers', 'digimia' ),
		'digimia/footer'         => __( 'Footers', 'digimia' ),
		'digimia/menu'           => __( 'Menus', 'digimia' ),
	);

	foreach ( $categories as $slug => $label ) {
		register_block_pattern_category( $slug, array( 'label' => $label ) );
	}
}
add_action( 'init', __NAMESPACE__ . '\register_pattern_categories', 9 );


/**
 * Adds a Sidebar area for template parts, next to Header and Footer, for the
 * sidebar the Page (With Sidebar) template shows.
 *
 * @param array $areas Template part areas.
 * @return array
 */
function add_sidebar_area( array $areas ) {
	$areas[] = array(
		'area'        => 'sidebar',
		'area_tag'    => 'section',
		'label'       => __( 'Sidebar', 'digimia' ),
		'description' => __( 'A column beside the page content, shown by the Page (With Sidebar) template.', 'digimia' ),
		'icon'        => 'sidebar',
	);

	return $areas;
}
add_filter( 'default_wp_template_part_areas', __NAMESPACE__ . '\add_sidebar_area' );

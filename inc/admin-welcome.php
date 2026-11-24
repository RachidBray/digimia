<?php
/**
 * Welcome page (Appearance → Digimia).
 *
 * Points a new site owner to Easy Digital Downloads, the Site Editor, the
 * documentation, support, and Digimia Pro. It holds no settings: design
 * choices live in the Site Editor. Digimia Pro replaces the Pro box through
 * the `digimia_welcome_pro` filter. Styles come from src/scss/admin/welcome.scss
 * and load on this page only.
 *
 * @package digimia
 */

declare(strict_types=1);

namespace Digimia;

const WELCOME_SLUG = 'digimia';

/**
 * Links the page points to.
 */
function welcome_links(): array {
	return array(
		'help'    => 'https://support.addictedtoweb.com/hc/en-us',
		'pro'     => 'https://addictedtoweb.com/downloads/digimia-pro/',
		'custom'  => 'https://addictedtoweb.com/contact-me/',
		'review'  => 'https://wordpress.org/support/theme/digimia/reviews/#new-post',
		'company' => 'https://addictedtoweb.com',
	);
}

/**
 * Add the page under Appearance.
 */
function register_welcome_page(): void {
	add_theme_page(
		__( 'Welcome to Digimia', 'digimia' ),
		__( 'Digimia', 'digimia' ),
		'edit_theme_options',
		WELCOME_SLUG,
		__NAMESPACE__ . '\render_welcome_page'
	);
}
add_action( 'admin_menu', __NAMESPACE__ . '\register_welcome_page' );

/**
 * Load the page's styles, on this page only.
 *
 * @param string $hook_suffix Current admin page.
 */
function enqueue_welcome_assets( string $hook_suffix ): void {
	$file = get_theme_file_path( 'assets/styles/admin-welcome.css' );

	if ( 'appearance_page_' . WELCOME_SLUG !== $hook_suffix || ! file_exists( $file ) ) {
		return;
	}

	wp_enqueue_style( 'digimia-admin-welcome', get_theme_file_uri( 'assets/styles/admin-welcome.css' ), array(), (string) filemtime( $file ) );
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\enqueue_welcome_assets' );

/**
 * Remember to point to the page once, after the theme is activated.
 */
function flag_welcome_notice(): void {
	set_transient( 'digimia_welcome_notice', 1, DAY_IN_SECONDS );
}
add_action( 'after_switch_theme', __NAMESPACE__ . '\flag_welcome_notice' );

/**
 * A one-time notice that links to the page.
 */
function welcome_notice(): void {
	if ( ! get_transient( 'digimia_welcome_notice' ) || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	delete_transient( 'digimia_welcome_notice' );

	$screen = get_current_screen();
	if ( $screen && 'appearance_page_' . WELCOME_SLUG === $screen->id ) {
		return;
	}

	printf(
		'<div class="notice notice-info is-dismissible"><p>%1$s <a href="%2$s">%3$s</a></p></div>',
		esc_html__( 'Thanks for choosing Digimia.', 'digimia' ),
		esc_url( admin_url( 'themes.php?page=' . WELCOME_SLUG ) ),
		esc_html__( 'See how to get started', 'digimia' )
	);
}
add_action( 'admin_notices', __NAMESPACE__ . '\welcome_notice' );

/**
 * An icon from the theme's set, as inline SVG for the page.
 *
 * @param string $slug Icon slug.
 */
function welcome_icon( string $slug ): string {
	$path = icon_path( $slug );

	if ( '' === $path ) {
		return '';
	}

	$svg = (string) file_get_contents( $path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- a local theme file.
	$svg = str_replace( '<svg ', '<svg aria-hidden="true" focusable="false" ', $svg );

	return wp_kses(
		$svg,
		array(
			'svg'  => array(
				'xmlns'       => true,
				'fill'        => true,
				'viewbox'     => true,
				'aria-hidden' => true,
				'focusable'   => true,
			),
			'path' => array( 'd' => true ),
		)
	);
}

/**
 * The plugin file of Easy Digital Downloads (free or Pro) when installed but
 * not active, or an empty string.
 */
function inactive_edd_plugin(): string {
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	foreach ( array( 'easy-digital-downloads-pro/easy-digital-downloads.php', 'easy-digital-downloads/easy-digital-downloads.php' ) as $file ) {
		if ( isset( get_plugins()[ $file ] ) ) {
			return $file;
		}
	}

	return '';
}

/**
 * What the Pro box shows: Digimia Pro's own details while it is active,
 * otherwise what it adds.
 */
function welcome_pro_box(): array {
	$default = array(
		'active'      => false,
		'title'       => __( 'Get more with Digimia Pro', 'digimia' ),
		'description' => __( 'Digimia Pro adds ready-made sites for more kinds of sellers, and the rest of the Digimia design library.', 'digimia' ),
		'features'    => array(
			array(
				'icon'  => 'storefront',
				'title' => __( 'Five more home pages', 'digimia' ),
				'text'  => __( 'Software, plugin shop, courses, books, and fitness homes, each with sections made for it.', 'digimia' ),
			),
			array(
				'icon'  => 'stack',
				'title' => __( 'Business pages', 'digimia' ),
				'text'  => __( 'Case study, careers, team, portfolio, services, integrations, changelog, and more.', 'digimia' ),
			),
			array(
				'icon'  => 'layout',
				'title' => __( 'More layouts', 'digimia' ),
				'text'  => __( 'Three more product layouts, more headers and footers, and five phone menu designs.', 'digimia' ),
			),
			array(
				'icon'  => 'squares-four',
				'title' => __( '140 more patterns', 'digimia' ),
				'text'  => __( 'Heroes, features, pricing tables, reviews, and calls to action for every kind of page.', 'digimia' ),
			),
		),
		'button'      => array(
			'label'    => __( 'See Digimia Pro', 'digimia' ),
			'url'      => welcome_links()['pro'],
			'external' => true,
		),
		'secondary'   => array(),
		'note'        => __( 'Also: styling for paid EDD extensions and one-click demo import.', 'digimia' ),
	);

	/**
	 * Filters the Pro box on the welcome page.
	 *
	 * Digimia Pro returns its own details while it is active. Feature icons
	 * are slugs from the theme's icon set.
	 *
	 * @param array $box {
	 *     @type bool   $active      Whether Digimia Pro is active.
	 *     @type string $title       Box heading.
	 *     @type string $description One or two sentences under the heading.
	 *     @type array  $features    Items with `icon`, `title`, and `text`.
	 *     @type array  $button      `label`, `url`, and optional `external`.
	 *     @type array  $secondary   An outline button after it, the same keys; optional.
	 *     @type string $note        Short line beside the buttons.
	 * }
	 */
	$box = apply_filters( 'digimia_welcome_pro', $default );

	return is_array( $box ) ? wp_parse_args( $box, $default ) : $default;
}

/**
 * A link that opens another site in a new tab.
 *
 * @param string $url     Address.
 * @param string $label   Link text.
 * @param string $classes Class names.
 */
function welcome_external_link( string $url, string $label, string $classes = '' ): string {
	return sprintf(
		'<a href="%1$s" class="%2$s" target="_blank" rel="noopener">%3$s<span class="screen-reader-text"> %4$s</span></a>',
		esc_url( $url ),
		esc_attr( $classes ),
		esc_html( $label ),
		esc_html__( '(opens in a new tab)', 'digimia' )
	);
}

/**
 * Render the page.
 */
function render_welcome_page(): void {
	$theme = wp_get_theme( get_template() );
	$links = welcome_links();
	$pro   = welcome_pro_box();
	$edd   = function_exists( 'EDD' );
	?>
	<div class="wrap digimia-welcome">
		<?php // Admin notices go here, above the cards, instead of under the first heading. ?>
		<hr class="wp-header-end">
		<section class="digimia-welcome__intro digimia-welcome__panel">
			<div class="digimia-welcome__intro-text">
				<h1>
					<?php esc_html_e( 'Welcome to Digimia', 'digimia' ); ?>
					<span class="digimia-welcome__version">
						<?php
						/* translators: %s: theme version number. */
						echo esc_html( sprintf( __( 'Version %s', 'digimia' ), $theme->get( 'Version' ) ) );
						?>
					</span>
				</h1>
				<p>
					<?php
					printf(
						/* translators: 1: Easy Digital Downloads, 2: theme author. */
						esc_html__( 'Digimia is a block theme for selling digital products with %1$s: a store home, shop and product pages, checkout, and customer accounts, with light and dark mode and styles you change in the Site Editor. Made by %2$s.', 'digimia' ),
						welcome_external_link( 'https://wordpress.org/plugins/easy-digital-downloads/', __( 'Easy Digital Downloads', 'digimia' ) ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in welcome_external_link().
						welcome_external_link( $links['company'], __( 'AddictedToWeb', 'digimia' ) ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in welcome_external_link().
					);
					?>
				</p>
				<p><?php echo welcome_external_link( $links['help'], __( 'Quick start guide', 'digimia' ), 'button button-primary button-hero' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in welcome_external_link(). ?></p>
			</div>
			<img class="digimia-welcome__screenshot" src="<?php echo esc_url( get_template_directory_uri() . '/screenshot.png' ); ?>" alt="" width="1200" height="900">
		</section>

		<?php if ( ! $edd ) : ?>
			<?php
			$inactive = inactive_edd_plugin();
			if ( $inactive && current_user_can( 'activate_plugins' ) ) {
				$action_url   = wp_nonce_url( admin_url( 'plugins.php?action=activate&plugin=' . rawurlencode( $inactive ) ), 'activate-plugin_' . $inactive );
				$action_label = __( 'Activate Easy Digital Downloads', 'digimia' );
			} elseif ( ! $inactive && current_user_can( 'install_plugins' ) ) {
				$action_url   = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=easy-digital-downloads' ), 'install-plugin_easy-digital-downloads' );
				$action_label = __( 'Install Easy Digital Downloads', 'digimia' );
			} else {
				$action_url = '';
			}
			?>
			<section class="digimia-welcome__panel digimia-welcome__edd">
				<span class="digimia-welcome__icon"><?php echo welcome_icon( 'shopping-cart' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized in welcome_icon(). ?></span>
				<div>
					<h2><?php esc_html_e( 'Set up your store', 'digimia' ); ?></h2>
					<p><?php esc_html_e( 'Digimia is made for Easy Digital Downloads, the free plugin that sells your products and runs checkout and customer accounts. The shop, product, and store pages need it.', 'digimia' ); ?></p>
				</div>
				<?php if ( $action_url ) : ?>
					<a class="button button-primary" href="<?php echo esc_url( $action_url ); ?>"><?php echo esc_html( $action_label ); ?></a>
				<?php endif; ?>
			</section>
		<?php endif; ?>

		<section class="digimia-welcome__panel digimia-welcome__pro<?php echo $pro['active'] ? ' is-active' : ''; ?>">
			<h2>
				<?php echo esc_html( $pro['title'] ); ?>
				<?php if ( $pro['active'] ) : ?>
					<span class="digimia-welcome__badge"><?php esc_html_e( 'Active', 'digimia' ); ?></span>
				<?php endif; ?>
			</h2>
			<p><?php echo esc_html( $pro['description'] ); ?></p>
			<ul class="digimia-welcome__grid">
				<?php foreach ( (array) $pro['features'] as $feature ) : ?>
					<li class="digimia-welcome__card">
						<span class="digimia-welcome__icon"><?php echo welcome_icon( (string) ( $feature['icon'] ?? '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized in welcome_icon(). ?></span>
						<h3><?php echo esc_html( (string) ( $feature['title'] ?? '' ) ); ?></h3>
						<p><?php echo esc_html( (string) ( $feature['text'] ?? '' ) ); ?></p>
					</li>
				<?php endforeach; ?>
			</ul>
			<div class="digimia-welcome__actions">
				<div class="digimia-welcome__buttons">
					<?php
					$buttons = array(
						'button'    => 'button button-primary',
						'secondary' => 'button',
					);
					foreach ( $buttons as $key => $classes ) {
						$button = (array) $pro[ $key ];
						if ( empty( $button['url'] ) ) {
							continue;
						}
						if ( ! empty( $button['external'] ) ) {
							echo welcome_external_link( (string) $button['url'], (string) ( $button['label'] ?? '' ), $classes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in welcome_external_link().
						} else {
							printf( '<a class="%1$s" href="%2$s">%3$s</a>', esc_attr( $classes ), esc_url( (string) $button['url'] ), esc_html( (string) ( $button['label'] ?? '' ) ) );
						}
					}
					?>
				</div>
				<?php if ( $pro['note'] ) : ?>
					<p><?php echo esc_html( $pro['note'] ); ?></p>
				<?php endif; ?>
			</div>
		</section>

		<ul class="digimia-welcome__grid digimia-welcome__links">
			<li class="digimia-welcome__panel">
				<span class="digimia-welcome__icon"><?php echo welcome_icon( 'paint-brush' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized in welcome_icon(). ?></span>
				<h2><?php esc_html_e( 'Site Editor', 'digimia' ); ?></h2>
				<p><?php esc_html_e( 'Change colors, fonts, the header and footer, and every template.', 'digimia' ); ?></p>
				<a href="<?php echo esc_url( admin_url( 'site-editor.php' ) ); ?>"><?php esc_html_e( 'Open the Site Editor', 'digimia' ); ?></a>
			</li>
			<?php if ( $edd ) : ?>
				<li class="digimia-welcome__panel">
					<span class="digimia-welcome__icon"><?php echo welcome_icon( 'sliders-horizontal' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized in welcome_icon(). ?></span>
					<h2><?php esc_html_e( 'Store settings', 'digimia' ); ?></h2>
					<p><?php esc_html_e( 'Payments, emails, taxes, and the pages Easy Digital Downloads uses.', 'digimia' ); ?></p>
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=download&page=edd-settings' ) ); ?>"><?php esc_html_e( 'Open store settings', 'digimia' ); ?></a>
				</li>
			<?php endif; ?>
			<li class="digimia-welcome__panel">
				<span class="digimia-welcome__icon"><?php echo welcome_icon( 'file-text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized in welcome_icon(). ?></span>
				<h2><?php esc_html_e( 'Documentation', 'digimia' ); ?></h2>
				<p><?php esc_html_e( 'Guides for setting up and customizing your store with Digimia.', 'digimia' ); ?></p>
				<?php echo welcome_external_link( $links['help'], __( 'Read the documentation', 'digimia' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in welcome_external_link(). ?>
			</li>
			<li class="digimia-welcome__panel">
				<span class="digimia-welcome__icon"><?php echo welcome_icon( 'lifebuoy' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized in welcome_icon(). ?></span>
				<h2><?php esc_html_e( 'Get support', 'digimia' ); ?></h2>
				<p><?php esc_html_e( 'Stuck on something? Ask us in the help center.', 'digimia' ); ?></p>
				<?php echo welcome_external_link( $links['help'], __( 'Contact support', 'digimia' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in welcome_external_link(). ?>
			</li>
		</ul>

		<section class="digimia-welcome__panel digimia-welcome__row">
			<span class="digimia-welcome__icon"><?php echo welcome_icon( 'code' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized in welcome_icon(). ?></span>
			<div>
				<h2><?php esc_html_e( 'Need something custom?', 'digimia' ); ?></h2>
				<p><?php esc_html_e( 'We can set up your store for you or build features made for your shop.', 'digimia' ); ?></p>
			</div>
			<?php echo welcome_external_link( $links['custom'], __( 'Request custom work', 'digimia' ), 'button' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in welcome_external_link(). ?>
		</section>

		<section class="digimia-welcome__panel digimia-welcome__row">
			<span class="digimia-welcome__icon"><?php echo welcome_icon( 'star' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized in welcome_icon(). ?></span>
			<div>
				<h2><?php esc_html_e( 'Enjoying Digimia?', 'digimia' ); ?></h2>
				<p><?php esc_html_e( 'A review on WordPress.org helps other store owners find the theme.', 'digimia' ); ?></p>
			</div>
			<?php echo welcome_external_link( $links['review'], __( 'Leave a review', 'digimia' ), 'button' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in welcome_external_link(). ?>
		</section>
	</div>
	<?php
}

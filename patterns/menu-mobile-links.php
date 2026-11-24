<?php
/**
 * Title: Menu: mobile with shop button
 * Slug: digimia/menu-mobile-links
 * Description: A full-screen phone menu with the site menu, a shop button, and an account link.
 * Categories: digimia/menu
 * Keywords: menu, mobile, overlay, navigation
 * Viewport Width: 400
 * Block Types: core/template-part/navigation-overlay
 * Post Types: wp_template_part
 * Inserter: true
 */
?>
<!-- wp:group {"metadata":{"name":"Mobile menu"},"style":{"dimensions":{"minHeight":"100dvh"},"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|large"}},"backgroundColor":"base","textColor":"main","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group has-main-color has-base-background-color has-text-color has-background" style="min-height:100dvh;padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Top bar"},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group"><!-- wp:site-logo {"width":110,"shouldSyncIcon":false} /-->

<!-- wp:navigation-overlay-close /--></div>
<!-- /wp:group -->

<!-- wp:navigation {"overlayMenu":"never","showSubmenuIcon":false,"submenuVisibility":"always","layout":{"type":"flex","orientation":"vertical"},"style":{"typography":{"fontWeight":"500"}},"fontSize":"large"} /-->

<!-- wp:group {"metadata":{"name":"Actions"},"style":{"spacing":{"margin":{"top":"auto"},"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group" style="margin-top:auto"><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"style":{"dimensions":{"width":"100%"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( \Digimia\edd_archive_url() ); ?>"><?php esc_html_e( 'Browse downloads', 'digimia' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:paragraph {"style":{"typography":{"textAlign":"center"}},"textColor":"main-accent","fontSize":"small"} -->
<p class="has-text-align-center has-main-accent-color has-text-color has-small-font-size"><a href="<?php echo esc_url( \Digimia\edd_page_url( 'login_redirect_page', '/account/' ) ); ?>"><?php esc_html_e( 'Your account', 'digimia' ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

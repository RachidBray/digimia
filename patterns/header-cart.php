<?php
/**
 * Title: Header: with cart
 * Slug: digimia/header-cart
 * Description: Site title, navigation, theme switch, and the EDD mini cart with item count and total.
 * Categories: digimia/header
 * Keywords: header, navigation, cart, store, theme switch, EDD
 * Viewport Width: 1500
 * Block Types: core/template-part/header
 * Post Types: wp_template
 * Inserter: true
 */
?>
<!-- wp:group {"metadata":{"name":"Header"},"align":"full","className":"digimia-site-header is-style-section-soft","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull digimia-site-header is-style-section-soft" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Row"},"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group alignwide"><!-- wp:site-logo {"width":132,"shouldSyncIcon":false} /-->

<!-- wp:group {"metadata":{"name":"Actions"},"style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right","verticalAlignment":"center"}} -->
<div class="wp-block-group"><!-- wp:navigation {"overlayMenu":"mobile","overlay":"mobile-menu","icon":"menu","layout":{"type":"flex","justifyContent":"right"},"style":{"typography":{"fontSize":"var:preset|font-size|base","fontWeight":"500"}}} /-->

<!-- wp:digimia/theme-toggle /-->

<!-- wp:buttons {"metadata":{"name":"Account"},"className":"digimia-header-account"} -->
<div class="wp-block-buttons digimia-header-account"><!-- wp:button {"className":"digimia-account-link","digimiaIcon":"user","digimiaIconPosition":"only"} -->
<div class="wp-block-button digimia-account-link"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( \Digimia\edd_page_url( 'login_redirect_page', '/account/' ) ); ?>"><?php esc_html_e( 'Account', 'digimia' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:edd/cart {"mini":true,"show_quantity":true,"show_total":false,"link":true,"hide_on_checkout":false,"className":"digimia-mini-cart"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

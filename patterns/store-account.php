<?php
/**
 * Title: Customer account page
 * Slug: digimia/store-account
 * Description: A customer account with a section menu: downloadable files, license keys, subscriptions, order history, and profile settings from EDD. The Licenses and Subscriptions sections come with the pattern when EDD Software Licensing or Recurring Payments is active, and show to customers who have one.
 * Categories: digimia/store
 * Keywords: account, library, purchase history, downloads, profile, EDD
 * Viewport Width: 1500
 * Block Types: core/post-content
 * Post Types: page
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"section","metadata":{"name":"Account"},"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Heading"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"align":"wide","layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-group alignwide"><!-- wp:heading {"level":1,"fontSize":"x-large"} -->
<h1 class="wp-block-heading has-x-large-font-size"><?php esc_html_e( 'Your account.', 'digimia' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"main-accent","fontSize":"lead"} -->
<p class="has-main-accent-color has-text-color has-lead-font-size"><?php esc_html_e( 'Download your files, manage licenses and subscriptions, check past orders, and keep your details up to date.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"align":"wide","className":"digimia-account-layout","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|large","left":"var:preset|spacing|xx-large"}}}} -->
<div class="wp-block-columns alignwide digimia-account-layout"><!-- wp:column {"width":"200px","className":"digimia-account-aside"} -->
<div class="wp-block-column digimia-account-aside" style="flex-basis:200px"><!-- wp:group {"tagName":"nav","metadata":{"name":"Account sections"},"ariaLabel":"<?php esc_attr_e( 'Account sections', 'digimia' ); ?>","layout":{"type":"default"}} -->
<nav class="wp-block-group" aria-label="<?php esc_attr_e( 'Account sections', 'digimia' ); ?>"><!-- wp:list {"className":"digimia-account-nav"} -->
<ul class="wp-block-list digimia-account-nav"><!-- wp:list-item -->
<li><a href="#downloads"><?php esc_html_e( 'Downloads', 'digimia' ); ?></a></li>
<!-- /wp:list-item -->

<?php if ( \Digimia\account_section_available( 'licenses' ) ) : ?>
<!-- wp:list-item {"className":"digimia-account-nav__licenses"} -->
<li class="digimia-account-nav__licenses"><a href="#licenses"><?php esc_html_e( 'Licenses', 'digimia' ); ?></a></li>
<!-- /wp:list-item -->

<?php endif; ?>
<?php if ( \Digimia\account_section_available( 'subscriptions' ) ) : ?>
<!-- wp:list-item {"className":"digimia-account-nav__subscriptions"} -->
<li class="digimia-account-nav__subscriptions"><a href="#subscriptions"><?php esc_html_e( 'Subscriptions', 'digimia' ); ?></a></li>
<!-- /wp:list-item -->

<?php endif; ?>
<!-- wp:list-item -->
<li><a href="#orders"><?php esc_html_e( 'Orders', 'digimia' ); ?></a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="#profile"><?php esc_html_e( 'Profile', 'digimia' ); ?></a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></nav>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"digimia-account-main","style":{"spacing":{"blockGap":"var:preset|spacing|x-large"}}} -->
<div class="wp-block-column digimia-account-main"><!-- wp:group {"metadata":{"name":"Downloads"},"anchor":"downloads","className":"digimia-account-section","style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"default"}} -->
<div id="downloads" class="wp-block-group digimia-account-section"><!-- wp:group {"style":{"spacing":{"blockGap":"0.35rem"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"fontSize":"large"} -->
<h2 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Downloads', 'digimia' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:edd/user-downloads {"search":true} /--></div>
<!-- /wp:group -->

<?php if ( \Digimia\account_section_available( 'licenses' ) ) : ?>
<!-- wp:group {"metadata":{"name":"Licenses"},"anchor":"licenses","className":"digimia-account-section digimia-account-licenses","style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"default"}} -->
<div id="licenses" class="wp-block-group digimia-account-section digimia-account-licenses"><!-- wp:group {"style":{"spacing":{"blockGap":"0.35rem"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"fontSize":"large"} -->
<h2 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Licenses', 'digimia' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"main-accent","fontSize":"small"} -->
<p class="has-main-accent-color has-text-color has-small-font-size"><?php esc_html_e( 'Your license keys. Manage the sites each license is active on, or extend it.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:shortcode -->
[edd_license_keys]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->

<?php endif; ?>
<?php if ( \Digimia\account_section_available( 'subscriptions' ) ) : ?>
<!-- wp:group {"metadata":{"name":"Subscriptions"},"anchor":"subscriptions","className":"digimia-account-section digimia-account-subscriptions","style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"default"}} -->
<div id="subscriptions" class="wp-block-group digimia-account-section digimia-account-subscriptions"><!-- wp:group {"style":{"spacing":{"blockGap":"0.35rem"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"fontSize":"large"} -->
<h2 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Subscriptions', 'digimia' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"main-accent","fontSize":"small"} -->
<p class="has-main-accent-color has-text-color has-small-font-size"><?php esc_html_e( 'Plans that renew automatically. Update your payment method or cancel at any time.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:edd/subscriptions /--></div>
<!-- /wp:group -->

<?php endif; ?>
<!-- wp:group {"metadata":{"name":"Orders"},"anchor":"orders","className":"digimia-account-section","style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"default"}} -->
<div id="orders" class="wp-block-group digimia-account-section"><!-- wp:group {"style":{"spacing":{"blockGap":"0.35rem"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"fontSize":"large"} -->
<h2 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Orders', 'digimia' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:edd/order-history {"columns":3,"className":"digimia-order-history"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Profile"},"anchor":"profile","className":"digimia-account-section","style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"default"}} -->
<div id="profile" class="wp-block-group digimia-account-section"><!-- wp:group {"style":{"spacing":{"blockGap":"0.35rem"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"fontSize":"large"} -->
<h2 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Profile', 'digimia' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:edd/profile-editor /--></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
</section>
<!-- /wp:group -->

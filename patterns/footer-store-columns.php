<?php
/**
 * Title: Footer: store columns
 * Slug: digimia/footer-store-columns
 * Description: A four-column footer with site identity, shop links, customer links, and policy links.
 * Categories: digimia/footer
 * Keywords: footer, links, store, account, policies
 * Viewport Width: 1500
 * Block Types: core/template-part/footer
 * Post Types: wp_template
 * Inserter: true
 */
?>
<!-- wp:group {"metadata":{"name":"Footer"},"align":"full","className":"digimia-site-footer is-style-section-soft","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull digimia-site-footer is-style-section-soft" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Footer"},"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group alignwide"><!-- wp:columns {"align":"wide","verticalAlignment":"top","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|x-large","top":"var:preset|spacing|large"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-top"><!-- wp:column {"verticalAlignment":"top","width":"40%"} -->
<div class="wp-block-column is-vertically-aligned-top" style="flex-basis:40%"><!-- wp:group {"metadata":{"name":"Brand"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group"><!-- wp:site-logo {"width":116,"shouldSyncIcon":false} /-->

<!-- wp:paragraph {"textColor":"main-accent","fontSize":"small"} -->
<p class="has-main-accent-color has-text-color has-small-font-size"><?php esc_html_e( 'Independent digital goods for people who make things. Instant downloads, clear licenses, and free updates.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:social-links {"className":"is-style-logos-only"} -->
<ul class="wp-block-social-links is-style-logos-only"><!-- wp:social-link {"url":"#","service":"x"} /--><!-- wp:social-link {"url":"#","service":"instagram"} /--><!-- wp:social-link {"url":"#","service":"linkedin"} /--><!-- wp:social-link {"url":"#","service":"youtube"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top","width":"20%"} -->
<div class="wp-block-column is-vertically-aligned-top" style="flex-basis:20%"><!-- wp:group {"metadata":{"name":"Shop"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"digimia-footer-heading","fontSize":"x-small"} -->
<p class="digimia-footer-heading has-x-small-font-size"><?php esc_html_e( 'Shop', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"digimia-footer-links","fontSize":"small"} -->
<ul class="wp-block-list digimia-footer-links has-small-font-size"><!-- wp:list-item -->
<li><a href="<?php echo esc_url( \Digimia\edd_archive_url() ); ?>"><?php esc_html_e( 'All products', 'digimia' ); ?></a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="#"><?php esc_html_e( 'Bundles', 'digimia' ); ?></a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="#"><?php esc_html_e( 'Free resources', 'digimia' ); ?></a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top","width":"20%"} -->
<div class="wp-block-column is-vertically-aligned-top" style="flex-basis:20%"><!-- wp:group {"metadata":{"name":"Customers"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"digimia-footer-heading","fontSize":"x-small"} -->
<p class="digimia-footer-heading has-x-small-font-size"><?php esc_html_e( 'Customers', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"digimia-footer-links","fontSize":"small"} -->
<ul class="wp-block-list digimia-footer-links has-small-font-size"><!-- wp:list-item -->
<li><a href="<?php echo esc_url( \Digimia\edd_page_url( 'purchase_history_page', '/account/' ) ); ?>"><?php esc_html_e( 'Your library', 'digimia' ); ?></a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( \Digimia\edd_page_url( 'purchase_page', '/checkout/' ) ); ?>"><?php esc_html_e( 'Checkout', 'digimia' ); ?></a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="#"><?php esc_html_e( 'Support', 'digimia' ); ?></a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top","width":"20%"} -->
<div class="wp-block-column is-vertically-aligned-top" style="flex-basis:20%"><!-- wp:group {"metadata":{"name":"Policies"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"digimia-footer-heading","fontSize":"x-small"} -->
<p class="digimia-footer-heading has-x-small-font-size"><?php esc_html_e( 'Policies', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"digimia-footer-links","fontSize":"small"} -->
<ul class="wp-block-list digimia-footer-links has-small-font-size"><!-- wp:list-item -->
<li><a href="#"><?php esc_html_e( 'Licenses', 'digimia' ); ?></a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="#"><?php esc_html_e( 'Refund policy', 'digimia' ); ?></a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="#"><?php esc_html_e( 'Privacy', 'digimia' ); ?></a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:separator {"backgroundColor":"border-light","className":"is-style-wide"} -->
<hr class="wp-block-separator has-text-color has-border-light-color has-alpha-channel-opacity has-border-light-background-color has-background is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:group {"metadata":{"name":"Legal"},"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group alignwide"><!-- wp:paragraph {"textColor":"main-accent","fontSize":"small"} -->
<p class="has-main-accent-color has-text-color has-small-font-size">© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. <?php esc_html_e( 'All rights reserved.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

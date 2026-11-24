<?php
/**
 * Title: Checkout page
 * Slug: digimia/store-checkout
 * Description: The EDD checkout with a short reassurance note and buying assurances below.
 * Categories: digimia/store
 * Keywords: checkout, cart, payment, EDD, store
 * Viewport Width: 1500
 * Block Types: core/post-content
 * Post Types: page
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"section","metadata":{"name":"Checkout"},"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Heading row"},"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|large"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"metadata":{"name":"Heading"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-group"><!-- wp:heading {"fontSize":"x-large"} -->
<h2 class="wp-block-heading has-x-large-font-size"><?php esc_html_e( 'Checkout.', 'digimia' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"main-accent","fontSize":"lead"} -->
<p class="has-main-accent-color has-text-color has-lead-font-size"><?php esc_html_e( 'Review your cart and pay securely. Your files are ready the moment payment clears.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600"}}} -->
<p style="font-weight:600"><a href="<?php echo esc_url( \Digimia\edd_archive_url() ); ?>"><?php esc_html_e( 'Continue shopping', 'digimia' ); ?> →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:edd/checkout {"layout":"two-thirds","align":"wide","className":"digimia-checkout"} /--></section>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"digimia/feature-buying-assurances"} /-->

<?php
/**
 * Title: Page, checkout
 * Slug: digimia/template-page-checkout
 * Description: The EDD Checkout page: the title and a Continue shopping link at wide width, above the two-column checkout.
 * Categories: digimia/pages
 * Keywords: page, checkout, store, EDD
 * Viewport Width: 1500
 * Template Types: page
 * Inserter: false
 */
?>
<!-- wp:template-part {"slug":"header","tagName":"header","area":"header"} /-->

<!-- wp:group {"tagName":"main","metadata":{"name":"Content"},"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"default"}} -->
<main class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0"><!-- wp:group {"tagName":"section","metadata":{"name":"Checkout"},"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|x-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|large"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--x-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Page header"},"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group alignwide"><!-- wp:post-title {"level":1,"fontSize":"x-large"} /-->

<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"fontWeight":"600"}}} -->
<p class="has-small-font-size" style="font-weight:600"><a href="<?php echo esc_url( \Digimia\edd_archive_url() ); ?>"><?php esc_html_e( 'Continue shopping', 'digimia' ); ?> →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:post-content {"align":"wide","layout":{"type":"constrained","contentSize":"1200px"}} /--></section>
<!-- /wp:group --></main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer","area":"footer"} /-->

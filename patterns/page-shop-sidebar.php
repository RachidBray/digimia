<?php
/**
 * Title: Shop page with sidebar
 * Slug: digimia/page-shop-sidebar
 * Description: A shop page: header and every download in a grid beside a sidebar with search, categories, and tags.
 * Categories: digimia/pages
 * Block Types: core/post-content
 * Post Types: page, wp_template
 * Keywords: shop, products, downloads, EDD, sidebar, filters, page
 * Viewport Width: 1500
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"section","metadata":{"name":"Page header"},"align":"full","className":"is-style-section-soft","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xxx-large","bottom":"var:preset|spacing|xxx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull is-style-section-soft" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xxx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xxx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Heading"},"style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":1,"fontSize":"xxx-large"} -->
<h1 class="wp-block-heading has-text-align-center has-xxx-large-font-size"><?php esc_html_e( 'Find the right tool for the job.', 'digimia' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"main-accent","fontSize":"lead"} -->
<p class="has-text-align-center has-main-accent-color has-text-color has-lead-font-size"><?php esc_html_e( 'Browse every product, or narrow it down by category and tag.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"digimia/product-grid-sidebar"} /-->

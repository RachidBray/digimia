<?php
/**
 * Title: Product catalog with pagination
 * Slug: digimia/product-catalog
 * Description: A full Easy Digital Downloads archive with a product grid and pagination.
 * Categories: digimia/products
 * Keywords: downloads, archive, EDD, catalogue, products
 * Viewport Width: 1500
 * Post Types: download
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"section","metadata":{"name":"Catalog"},"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Heading"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":1,"fontSize":"x-large"} -->
<h1 class="wp-block-heading has-text-align-center has-x-large-font-size"><?php esc_html_e( 'All downloads.', 'digimia' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"main-accent","fontSize":"lead"} -->
<p class="has-text-align-center has-main-accent-color has-text-color has-lead-font-size"><?php esc_html_e( 'A useful collection of digital goods from independent designers and small studios.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:edd/downloads {"align":"wide","columns":3,"number":9,"orderby":"date","order":"DESC","title":true,"purchase_link":true,"price":true,"pagination":true,"image_link":true,"show_price":false,"content":"excerpt","image_location":"before_entry_title","image_size":"large","className":"digimia-download-grid"} /--></section>
<!-- /wp:group -->

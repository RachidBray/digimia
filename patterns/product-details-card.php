<?php
/**
 * Title: Product details card
 * Slug: digimia/product-details-card
 * Description: The current product's category, release and update dates, version, files, formats, and tags. Rows without a value are hidden.
 * Categories: digimia/products
 * Keywords: product, details, meta, files, formats, version, tags, EDD, sidebar
 * Viewport Width: 500
 * Inserter: true
 */
?>
<!-- wp:group {"metadata":{"name":"Details card"},"className":"digimia-details-card","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group digimia-details-card"><!-- wp:heading {"className":"digimia-details-card__title","fontSize":"base"} -->
<h2 class="wp-block-heading digimia-details-card__title has-base-font-size"><?php esc_html_e( 'Details', 'digimia' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:group {"metadata":{"name":"Category"},"className":"digimia-detail-row","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group digimia-detail-row"><!-- wp:paragraph {"className":"digimia-detail-label"} -->
<p class="digimia-detail-label"><?php esc_html_e( 'Category', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:post-terms {"term":"download_category","separator":", "} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Released"},"className":"digimia-detail-row","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group digimia-detail-row"><!-- wp:paragraph {"className":"digimia-detail-label"} -->
<p class="digimia-detail-label"><?php esc_html_e( 'Released', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:post-date {"format":"M j, Y"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Last updated"},"className":"digimia-detail-row","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group digimia-detail-row"><!-- wp:paragraph {"className":"digimia-detail-label"} -->
<p class="digimia-detail-label"><?php esc_html_e( 'Last updated', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:post-date {"format":"M j, Y","metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"modified"}}}}} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Version"},"className":"digimia-detail-row","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group digimia-detail-row"><!-- wp:paragraph {"className":"digimia-detail-label"} -->
<p class="digimia-detail-label"><?php esc_html_e( 'Version', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"digimia/product","args":{"key":"version"}}}}} -->
<p></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Files"},"className":"digimia-detail-row","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group digimia-detail-row"><!-- wp:paragraph {"className":"digimia-detail-label"} -->
<p class="digimia-detail-label"><?php esc_html_e( 'Files', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"digimia/product","args":{"key":"files"}}}}} -->
<p></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Formats"},"className":"digimia-detail-row","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group digimia-detail-row"><!-- wp:paragraph {"className":"digimia-detail-label"} -->
<p class="digimia-detail-label"><?php esc_html_e( 'Formats', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"digimia/product","args":{"key":"formats"}}}}} -->
<p></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:post-terms {"term":"download_tag","prefix":"","className":"is-style-term-button digimia-details-card__tags"} /--></div>
<!-- /wp:group -->

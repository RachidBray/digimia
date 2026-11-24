<?php
/**
 * Title: Products: grid with a sidebar
 * Slug: digimia/product-grid-sidebar
 * Description: Every download in a grid beside a sidebar with product search, categories, and tags.
 * Categories: digimia/products
 * Keywords: shop, products, downloads, EDD, sidebar, filters, categories, tags, search, grid
 * Viewport Width: 1500
 * Block Types:
 * Post Types:
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"section","metadata":{"name":"Shop"},"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|x-large","top":"var:preset|spacing|large"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"verticalAlignment":"top","width":"16rem"} -->
<div class="wp-block-column is-vertically-aligned-top" style="flex-basis:16rem"><!-- wp:group {"tagName":"aside","metadata":{"name":"Sidebar"},"className":"digimia-shop-sidebar","style":{"spacing":{"blockGap":"var:preset|spacing|large"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<aside class="wp-block-group digimia-shop-sidebar"><!-- wp:search {"label":"Search products","showLabel":false,"placeholder":"Search products\u2026","buttonText":"Search","buttonPosition":"no-button","query":{"post_type":"download"}} /-->

<!-- wp:group {"metadata":{"name":"Categories"},"className":"digimia-filter","style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group digimia-filter"><!-- wp:heading {"fontSize":"lead"} -->
<h2 class="wp-block-heading has-lead-font-size"><?php esc_html_e( 'Categories', 'digimia' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:categories {"taxonomy":"download_category","showPostCounts":true,"className":"digimia-filter-list"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Tags"},"className":"digimia-filter","style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group digimia-filter"><!-- wp:heading {"fontSize":"lead"} -->
<h2 class="wp-block-heading has-lead-font-size"><?php esc_html_e( 'Tags', 'digimia' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:tag-cloud {"taxonomy":"download_tag","numberOfTags":12,"smallestFontSize":"0.875rem","largestFontSize":"0.875rem","className":"is-style-outline"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Help"},"className":"digimia-filter","style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group digimia-filter"><!-- wp:paragraph {"textColor":"main-accent","fontSize":"small"} -->
<p class="has-main-accent-color has-text-color has-small-font-size"><?php esc_html_e( 'Need help choosing?', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600"}}} -->
<p style="font-weight:600"><a href="#"><?php esc_html_e( 'Talk to us', 'digimia' ); ?></a> →</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></aside>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:group {"metadata":{"name":"Products"},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:query {"queryId":51,"query":{"perPage":9,"pages":0,"offset":0,"postType":"download","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"digimia-product-query"} -->
<div class="wp-block-query digimia-product-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|large"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"14rem"}} -->
<!-- wp:group {"metadata":{"name":"Product card"},"className":"digimia-product-card","style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group digimia-product-card"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3"} /-->

<!-- wp:post-terms {"term":"download_category","textColor":"primary","fontSize":"x-small","style":{"typography":{"fontWeight":"600","textTransform":"uppercase","letterSpacing":"0.12em"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"className":"digimia-product-card__terms"} /-->

<!-- wp:post-title {"level":3,"isLink":true,"className":"digimia-product-card__title","fontSize":"medium"} /-->

<!-- wp:post-excerpt {"excerptLength":20,"className":"digimia-product-card__excerpt is-style-excerpt-truncate-2","textColor":"main-accent"} /-->

<!-- wp:group {"metadata":{"name":"Price and button"},"className":"digimia-product-card__buy","style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group digimia-product-card__buy"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"digimia/product","args":{"key":"price_from"}}}},"className":"digimia-product-card__price"} -->
<p class="digimia-product-card__price"></p>
<!-- /wp:paragraph -->

<!-- wp:edd/buy-button {"show_price":false} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"textColor":"main-accent"} -->
<p class="has-main-accent-color has-text-color"><?php esc_html_e( 'No products match. Try another category or search.', 'digimia' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->

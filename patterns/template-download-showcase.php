<?php
/**
 * Title: Product, showcase
 * Slug: digimia/template-download-showcase
 * Description: A product page led by the title and a large framed preview, with the description below it and a sticky purchase card and details beside. Related products follow. The default product template.
 * Categories: digimia/products
 * Keywords: product, download, single, showcase, preview, theme, template, sidebar, EDD
 * Viewport Width: 1500
 * Template Types: single-download
 * Inserter: false
 */
?>
<!-- wp:template-part {"slug":"header","tagName":"header","area":"header"} /-->

<!-- wp:group {"tagName":"main","align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"default"}} -->
<main class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0"><!-- wp:group {"tagName":"section","metadata":{"name":"Product"},"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|x-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--x-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Title"},"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:breadcrumbs {"separator":"›","className":"digimia-breadcrumbs"} /-->

<!-- wp:post-title {"level":1,"fontSize":"xx-large"} /-->

<!-- wp:group {"metadata":{"name":"Category and facts"},"style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group"><!-- wp:post-terms {"term":"download_category","className":"is-style-term-button"} /-->

<!-- wp:group {"metadata":{"name":"Facts"},"className":"digimia-product-meta","style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group digimia-product-meta"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"digimia/product","args":{"key":"rating"}}}},"className":"digimia-product-rating"} -->
<p class="digimia-product-rating"></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"digimia/product","args":{"key":"files"}}}}} -->
<p></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"digimia/product","args":{"key":"formats"}}}}} -->
<p></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"digimia-product-meta__updated","style":{"spacing":{"blockGap":"0.3em"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group digimia-product-meta__updated"><!-- wp:paragraph -->
<p><?php esc_html_e( 'Updated', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:post-date {"format":"M j, Y","metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"modified"}}}}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:columns {"align":"wide","className":"digimia-product-layout","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|x-large","left":"var:preset|spacing|xx-large"}}}} -->
<div class="wp-block-columns alignwide digimia-product-layout"><!-- wp:column {"width":"64%","className":"digimia-product-main","style":{"spacing":{"blockGap":"var:preset|spacing|x-large"}}} -->
<div class="wp-block-column digimia-product-main" style="flex-basis:64%"><!-- wp:post-featured-image {"aspectRatio":"4/3","className":"digimia-product-hero digimia-showcase-media"} /-->

<!-- wp:post-excerpt {"textColor":"main","fontSize":"lead"} /-->

<!-- wp:heading {"className":"screen-reader-text"} -->
<h2 class="wp-block-heading screen-reader-text"><?php esc_html_e( 'Description', 'digimia' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:post-content {"layout":{"type":"default"}} /--></div>
<!-- /wp:column -->

<!-- wp:column {"width":"36%","className":"digimia-product-aside","style":{"spacing":{"blockGap":"var:preset|spacing|medium"}}} -->
<div class="wp-block-column digimia-product-aside" style="flex-basis:36%"><!-- wp:pattern {"slug":"digimia/product-purchase-card"} /-->

<!-- wp:pattern {"slug":"digimia/product-details-card"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"digimia/product-related"} /--></main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer","area":"footer"} /-->

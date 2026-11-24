<?php
/**
 * Title: Editorial product shelf
 * Slug: digimia/product-editorial-shelf
 * Description: An editorial product shelf: the newest template, UI kit, font, icon, illustration, or presentation as a wide featured card, then the next three as product cards.
 * Categories: digimia/products
 * Keywords: products, downloads, EDD, collection, grid
 * Viewport Width: 1500
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"section","metadata":{"name":"Shelf"},"align":"full","className":"is-style-section-soft","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull is-style-section-soft" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Heading row"},"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|large"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"metadata":{"name":"Heading"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-group"><!-- wp:heading {"fontSize":"x-large"} -->
<h2 class="wp-block-heading has-x-large-font-size"><?php esc_html_e( 'Fresh from the makers.', 'digimia' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"main-accent","fontSize":"lead"} -->
<p class="has-main-accent-color has-text-color has-lead-font-size"><?php esc_html_e( 'A few thoughtful things to make your next project easier.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600"}}} -->
<p style="font-weight:600"><a href="<?php echo esc_url( \Digimia\edd_archive_url() ); ?>"><?php esc_html_e( 'View all downloads', 'digimia' ); ?> →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Products"},"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|large"}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:query {"queryId":23,"query":{"perPage":1,"offset":0,"pages":0,"postType":"download","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"include":{"download_category":<?php echo \Digimia\download_category_ids( 'templates,ui-kits,fonts,icons,illustrations,presentations' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JSON list of integers. ?>}}},"className":"digimia-shelf-featured"} -->
<div class="wp-block-query digimia-shelf-featured"><!-- wp:post-template -->
<!-- wp:group {"metadata":{"name":"Featured product"},"className":"digimia-product-card","layout":{"type":"default"}} -->
<div class="wp-block-group digimia-product-card"><!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|large","left":"var:preset|spacing|x-large"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"58%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:58%"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3"} /--></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"42%","style":{"spacing":{"blockGap":"var:preset|spacing|medium"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:42%"><!-- wp:post-title {"level":3,"isLink":true,"className":"digimia-product-card__title","fontSize":"x-large"} /-->

<!-- wp:post-excerpt {"excerptLength":32,"className":"digimia-product-card__excerpt is-style-excerpt-truncate-3","textColor":"main-accent","fontSize":"lead"} /-->

<!-- wp:group {"metadata":{"name":"Price and button"},"className":"digimia-product-card__buy","style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group digimia-product-card__buy"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"digimia/product","args":{"key":"price_from"}}}},"className":"digimia-product-card__price"} -->
<p class="digimia-product-card__price"></p>
<!-- /wp:paragraph -->

<!-- wp:edd/buy-button {"show_price":false} /--></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query -->

<!-- wp:query {"queryId":24,"query":{"perPage":3,"offset":1,"pages":0,"postType":"download","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"include":{"download_category":<?php echo \Digimia\download_category_ids( 'templates,ui-kits,fonts,icons,illustrations,presentations' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JSON list of integers. ?>}}},"className":"digimia-shelf-list"} -->
<div class="wp-block-query digimia-shelf-list"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|large"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"16rem"}} -->
<!-- wp:group {"metadata":{"name":"Product card"},"className":"digimia-product-card","style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group digimia-product-card"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3"} /-->

<!-- wp:post-title {"level":3,"isLink":true,"className":"digimia-product-card__title","fontSize":"medium"} /-->

<!-- wp:post-excerpt {"excerptLength":20,"className":"digimia-product-card__excerpt is-style-excerpt-truncate-2","textColor":"main-accent"} /-->

<!-- wp:group {"metadata":{"name":"Price and button"},"className":"digimia-product-card__buy","style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group digimia-product-card__buy"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"digimia/product","args":{"key":"price_from"}}}},"className":"digimia-product-card__price"} -->
<p class="digimia-product-card__price"></p>
<!-- /wp:paragraph -->

<!-- wp:edd/buy-button {"show_price":false} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

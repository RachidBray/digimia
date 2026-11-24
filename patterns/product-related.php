<?php
/**
 * Title: Related products
 * Slug: digimia/product-related
 * Description: Other downloads from the current product's categories, topped up with the latest ones. For product page templates.
 * Categories: digimia/products
 * Keywords: related, similar, more, products, downloads, EDD, cross-sell
 * Viewport Width: 1500
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"section","metadata":{"name":"Related products"},"align":"full","className":"digimia-related-section","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|x-large"},"border":{"top":{"color":"var:preset|color|border-light","width":"1px"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull digimia-related-section" style="border-top-color:var(--wp--preset--color--border-light);border-top-width:1px;margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Heading row"},"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|large"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group alignwide"><!-- wp:heading {"fontSize":"large"} -->
<h2 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'You might also like', 'digimia' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600"}}} -->
<p style="font-weight:600"><a href="<?php echo esc_url( \Digimia\edd_archive_url() ); ?>"><?php esc_html_e( 'Browse the shop', 'digimia' ); ?> →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":31,"query":{"perPage":3,"pages":0,"offset":0,"postType":"download","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"align":"wide","className":"digimia-product-query digimia-related-downloads"} -->
<div class="wp-block-query alignwide digimia-product-query digimia-related-downloads"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|large"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"16rem"}} -->
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
<!-- /wp:post-template --></div>
<!-- /wp:query --></section>
<!-- /wp:group -->

<?php
/**
 * Title: Product card grid
 * Slug: digimia/product-card-grid
 * Description: A grid of the latest downloads as cards with image, category, excerpt, price, and buy button.
 * Categories: digimia/products
 * Keywords: products, downloads, EDD, grid, cards, shop
 * Viewport Width: 1500
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"section","metadata":{"name":"Products"},"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Heading row"},"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|large"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"metadata":{"name":"Heading"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-group"><!-- wp:heading {"fontSize":"x-large"} -->
<h2 class="wp-block-heading has-x-large-font-size"><?php esc_html_e( 'Just released.', 'digimia' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"main-accent","fontSize":"lead"} -->
<p class="has-main-accent-color has-text-color has-lead-font-size"><?php esc_html_e( 'Fresh templates, kits, and assets from independent makers.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600"}}} -->
<p style="font-weight:600"><a href="<?php echo esc_url( \Digimia\edd_archive_url() ); ?>"><?php esc_html_e( 'Browse everything', 'digimia' ); ?> →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":21,"query":{"perPage":6,"pages":0,"offset":0,"postType":"download","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"align":"wide","className":"digimia-product-query"} -->
<div class="wp-block-query alignwide digimia-product-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|large"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"16rem"}} -->
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

<!-- wp:query-no-results -->
<!-- wp:paragraph {"textColor":"main-accent"} -->
<p class="has-main-accent-color has-text-color"><?php esc_html_e( 'New products are on their way. Check back soon.', 'digimia' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></section>
<!-- /wp:group -->

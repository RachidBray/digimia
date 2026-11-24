<?php
/**
 * Title: Marketplace home
 * Slug: digimia/page-home
 * Description: A complete storefront landing page for independent digital goods: editorial hero, shelf, bento features, maker story, FAQ, and a closing card.
 * Categories: digimia/pages
 * Block Types: core/post-content
 * Post Types: page, wp_template
 * Keywords: marketplace, home, digital products, storefront
 * Viewport Width: 1500
 * Inserter: true
 */
?>
<!-- wp:pattern {"slug":"digimia/hero-editorial-collection"} /-->

<!-- wp:pattern {"slug":"digimia/feature-bento-cards"} /-->

<!-- wp:pattern {"slug":"digimia/product-editorial-shelf"} /-->

<!-- wp:pattern {"slug":"digimia/feature-maker-story"} /-->

<!-- wp:group {"tagName":"section","metadata":{"name":"FAQ"},"align":"full","className":"is-style-section-soft","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull is-style-section-soft" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|large","left":"var:preset|spacing|xx-large"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"42%"} -->
<div class="wp-block-column" style="flex-basis:42%"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|large"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group"><!-- wp:heading {"fontSize":"x-large"} -->
<h2 class="wp-block-heading has-x-large-font-size"><?php esc_html_e( 'Questions, answered.', 'digimia' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"main-accent","fontSize":"lead"} -->
<p class="has-main-accent-color has-text-color has-lead-font-size"><?php esc_html_e( 'Everything you need to know about buying, downloading, and using our products.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Card"},"style":{"border":{"radius":"var:custom|radius|lg","width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|large","bottom":"var:preset|spacing|large","left":"var:preset|spacing|large","right":"var:preset|spacing|large"},"blockGap":"var:preset|spacing|medium"},"dimensions":{"minHeight":"100%"}},"borderColor":"border-light","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group has-border-color has-border-light-border-color" style="border-width:1px;border-radius:var(--wp--custom--radius--lg);min-height:100%;padding-top:var(--wp--preset--spacing--large);padding-right:var(--wp--preset--spacing--large);padding-bottom:var(--wp--preset--spacing--large);padding-left:var(--wp--preset--spacing--large)"><!-- wp:group {"metadata":{"name":"Person"},"style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group"><!-- wp:image {"width":"56px","sizeSlug":"thumbnail","linkDestination":"none","style":{"border":{"radius":"var:custom|radius|full"}}} -->
<figure class="wp-block-image size-thumbnail is-resized has-custom-border"><img src="<?php echo esc_url( get_template_directory_uri() . '/patterns/images/avatar-3.webp' ); ?>" alt="<?php esc_attr_e( 'Portrait of the support lead', 'digimia' ); ?>" style="border-radius:var(--wp--custom--radius--full);width:56px"/></figure>
<!-- /wp:image -->

<!-- wp:group {"metadata":{"name":"Text"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3,"fontSize":"medium"} -->
<h3 class="wp-block-heading has-medium-font-size"><?php esc_html_e( 'Still have questions?', 'digimia' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"main-accent"} -->
<p class="has-main-accent-color has-text-color"><?php esc_html_e( 'Talk to the people who made the product. We reply within one working day.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Contact us', 'digimia' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%"><!-- wp:group {"metadata":{"name":"Questions"},"style":{"spacing":{"blockGap":"var:preset|spacing|0"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group"><!-- wp:details {"showContent":true,"className":"is-style-accordion"} -->
<details class="wp-block-details is-style-accordion" open><summary><?php esc_html_e( 'What do I get when I buy?', 'digimia' ); ?></summary><!-- wp:paragraph -->
<p><?php esc_html_e( 'Every product comes as a download with its source files, documentation, and a license certificate. Files stay in your account library.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details {"className":"is-style-accordion"} -->
<details class="wp-block-details is-style-accordion"><summary><?php esc_html_e( 'Can I use the files for client work?', 'digimia' ); ?></summary><!-- wp:paragraph -->
<p><?php esc_html_e( 'Yes, with a Commercial or Extended license. The Personal license covers your own projects.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details {"className":"is-style-accordion"} -->
<details class="wp-block-details is-style-accordion"><summary><?php esc_html_e( 'How do updates work?', 'digimia' ); ?></summary><!-- wp:paragraph -->
<p><?php esc_html_e( 'New versions appear in your account automatically, free for the life of the product.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details {"className":"is-style-accordion"} -->
<details class="wp-block-details is-style-accordion"><summary><?php esc_html_e( 'Which file formats are included?', 'digimia' ); ?></summary><!-- wp:paragraph -->
<p><?php esc_html_e( 'Each product page lists its formats, such as Figma, HTML, SVG, or fonts in OTF and WOFF2.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details {"className":"is-style-accordion"} -->
<details class="wp-block-details is-style-accordion"><summary><?php esc_html_e( 'Do I need an account to buy?', 'digimia' ); ?></summary><!-- wp:paragraph -->
<p><?php esc_html_e( 'No. You can check out as a guest and your download links arrive by email.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details {"className":"is-style-accordion"} -->
<details class="wp-block-details is-style-accordion"><summary><?php esc_html_e( 'What if it isn\'t what I expected?', 'digimia' ); ?></summary><!-- wp:paragraph -->
<p><?php esc_html_e( 'Contact us within 14 days. We will help you get it working or refund you.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"digimia/cta-closing-note"} /-->

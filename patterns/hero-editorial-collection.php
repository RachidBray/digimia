<?php
/**
 * Title: Hero: editorial collection
 * Slug: digimia/hero-editorial-collection
 * Description: A headline, two actions, and short notes beside tilted store cards: best sellers, downloads this week, and a new sale.
 * Categories: digimia/hero
 * Keywords: storefront, digital products, marketplace, hero, downloads
 * Viewport Width: 1500
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"section","metadata":{"name":"Hero"},"align":"full","className":"digimia-home-hero is-style-section-soft","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xxx-large","bottom":"var:preset|spacing|xxx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull digimia-home-hero is-style-section-soft" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xxx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xxx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:columns {"align":"wide","verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|xx-large"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"49%","className":"digimia-home-copy","style":{"spacing":{"blockGap":"var:preset|spacing|large"}}} -->
<div class="wp-block-column is-vertically-aligned-center digimia-home-copy" style="flex-basis:49%"><!-- wp:group {"metadata":{"name":"Heading"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":1,"fontSize":"xxx-large"} -->
<h1 class="wp-block-heading has-xxx-large-font-size"><?php esc_html_e( 'Good things for people who', 'digimia' ); ?> <mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color"><?php esc_html_e( 'make', 'digimia' ); ?></mark> <?php esc_html_e( 'things', 'digimia' ); ?>.</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"digimia-home-intro","textColor":"main-accent","fontSize":"lead"} -->
<p class="digimia-home-intro has-main-accent-color has-text-color has-lead-font-size"><?php esc_html_e( 'Useful templates, design kits, and creative tools from independent makers. Find the right piece, download it, and get on with your next idea.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left"}} -->
<div class="wp-block-buttons"><!-- wp:button {"digimiaIcon":"arrow-right","digimiaIconPosition":"right"} -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( \Digimia\edd_archive_url() ); ?>"><?php esc_html_e( 'Browse all downloads', 'digimia' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#why-digimia"><?php esc_html_e( 'Why Digimia', 'digimia' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:group {"metadata":{"name":"Notes"},"className":"digimia-check-row","style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group digimia-check-row"><!-- wp:paragraph {"textColor":"main-accent","fontSize":"small"} -->
<p class="has-main-accent-color has-text-color has-small-font-size"><?php esc_html_e( 'Creator made', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"main-accent","fontSize":"small"} -->
<p class="has-main-accent-color has-text-color has-small-font-size"><?php esc_html_e( 'Instant download', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"main-accent","fontSize":"small"} -->
<p class="has-main-accent-color has-text-color has-small-font-size"><?php esc_html_e( 'Clear licenses', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"51%","className":"digimia-home-art-column"} -->
<div class="wp-block-column is-vertically-aligned-center digimia-home-art-column" style="flex-basis:51%"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"digimia-home-ui"} -->
<figure class="wp-block-image size-full digimia-home-ui"><img src="<?php echo esc_url( get_template_directory_uri() . '/patterns/images/digimia-ui-store.svg' ); ?>" alt="<?php esc_attr_e( 'Store cards: this week’s best sellers led by the Brand Starter Kit, 2,480 downloads up 18%, and a new sale', 'digimia' ); ?>"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->

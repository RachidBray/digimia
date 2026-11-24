<?php
/**
 * Title: Not found page
 * Slug: digimia/template-page-404
 * Description: The page that shows when no other page is found.
 * Categories: digimia/pages
 * Keywords: page, full-width
 * Viewport Width: 1500
 * Inserter: false
 */
?>
<!-- wp:template-part {"slug":"header","tagName":"header","area":"header"} /-->

<!-- wp:group {"tagName":"main","metadata":{"name":"Content"},"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"default"}} -->
<main class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0"><!-- wp:group {"tagName":"section","metadata":{"name":"Not found"},"align":"full","className":"is-style-section-soft","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xxx-large","bottom":"var:preset|spacing|xxx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull is-style-section-soft" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xxx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xxx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Heading"},"style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"align":"center","className":"digimia-pill"} -->
<p class="has-text-align-center digimia-pill"><strong><?php esc_html_e( '404', 'digimia' ); ?></strong> <?php esc_html_e( 'Page not found', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":1,"fontSize":"xxx-large"} -->
<h1 class="wp-block-heading has-text-align-center has-xxx-large-font-size"><?php esc_html_e( 'This page wandered off.', 'digimia' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"main-accent","fontSize":"lead"} -->
<p class="has-text-align-center has-main-accent-color has-text-color has-lead-font-size"><?php esc_html_e( 'The address may have changed. Search the site, or start again from the shop or the journal.', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"metadata":{"name":"Search form"},"layout":{"type":"constrained","contentSize":"560px"}} -->
<div class="wp-block-group"><!-- wp:search {"label":"<?php esc_attr_e( 'Search', 'digimia' ); ?>","showLabel":false,"placeholder":"<?php esc_attr_e( 'Search products and notes', 'digimia' ); ?>","buttonText":"<?php esc_attr_e( 'Search', 'digimia' ); ?>"} /--></div>
<!-- /wp:group -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( \Digimia\edd_archive_url() ); ?>"><?php esc_html_e( 'Browse the shop', 'digimia' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( get_permalink( (int) get_option( 'page_for_posts' ) ) ?: home_url( '/' ) ); ?>"><?php esc_html_e( 'Read the journal', 'digimia' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"digimia/product-card-grid"} /--></main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer","area":"footer"} /-->

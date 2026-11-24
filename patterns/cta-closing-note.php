<?php
/**
 * Title: Call to action: closing card with a workspace photo
 * Slug: digimia/cta-closing-note
 * Description: A rounded brand-color card inviting visitors to browse the collection, with two actions, short notes, and a photo of a maker at work.
 * Categories: digimia/call-to-action
 * Keywords: CTA, collection, storefront, downloads
 * Viewport Width: 1500
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"section","metadata":{"name":"CTA"},"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Panel"},"align":"wide","className":"is-style-section-brand","style":{"border":{"radius":"var:custom|radius|xl"},"spacing":{"padding":{"top":"var:preset|spacing|x-large","bottom":"var:preset|spacing|x-large","left":"var:preset|spacing|x-large","right":"var:preset|spacing|x-large"}}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group alignwide is-style-section-brand" style="border-radius:var(--wp--custom--radius--xl);padding-top:var(--wp--preset--spacing--x-large);padding-right:var(--wp--preset--spacing--x-large);padding-bottom:var(--wp--preset--spacing--x-large);padding-left:var(--wp--preset--spacing--x-large)"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|large","left":"var:preset|spacing|xx-large"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"verticalAlignment":"center","width":"55%","style":{"spacing":{"blockGap":"var:preset|spacing|medium"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%"><!-- wp:heading {"fontSize":"x-large"} -->
<h2 class="wp-block-heading has-x-large-font-size"><?php esc_html_e( 'Your next good idea starts here.', 'digimia' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"main-accent","fontSize":"lead"} -->
<p class="has-main-accent-color has-text-color has-lead-font-size"><?php esc_html_e( 'Find a useful starting point, then make it your own.', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"digimiaIcon":"arrow-right","digimiaIconPosition":"right"} -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( \Digimia\edd_archive_url() ); ?>"><?php esc_html_e( 'Browse the collection', 'digimia' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Talk to us', 'digimia' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:group {"metadata":{"name":"Notes"},"className":"digimia-check-row","style":{"spacing":{"blockGap":"var:preset|spacing|large"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group digimia-check-row"><!-- wp:paragraph {"textColor":"main-accent","fontSize":"small"} -->
<p class="has-main-accent-color has-text-color has-small-font-size"><?php esc_html_e( 'Instant download', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"main-accent","fontSize":"small"} -->
<p class="has-main-accent-color has-text-color has-small-font-size"><?php esc_html_e( 'Clear licenses', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"45%"} -->
<div class="wp-block-column" style="flex-basis:45%"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"digimia-media-fill","style":{"border":{"radius":"var:custom|radius|lg"}}} -->
<figure class="wp-block-image size-full has-custom-border digimia-media-fill"><img src="<?php echo esc_url( get_template_directory_uri() . '/patterns/images/workspace-sketch.webp' ); ?>" alt="<?php esc_attr_e( 'A man sketching lettering at a desk beside a camera and a notebook', 'digimia' ); ?>" style="border-radius:var(--wp--custom--radius--lg)"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

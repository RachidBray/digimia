<?php
/**
 * Title: Maker story
 * Slug: digimia/feature-maker-story
 * Description: A storefront story section highlighting independent creators.
 * Categories: digimia/features
 * Keywords: makers, creators, independent, design goods
 * Viewport Width: 1500
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"section","metadata":{"name":"Maker story"},"align":"full","anchor":"digimia-makers","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"constrained"}} -->
<section id="digimia-makers" class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:columns {"align":"wide","verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|xx-large","top":"var:preset|spacing|large"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"48%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:48%"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","style":{"border":{"radius":"var:custom|radius|lg"}}} -->
<figure class="wp-block-image size-large has-custom-border"><img src="<?php echo esc_url( get_template_directory_uri() . '/patterns/images/digimia-maker-work.svg' ); ?>" alt="<?php esc_attr_e( 'An illustrated creator profile card with a verified check', 'digimia' ); ?>" style="border-radius:var(--wp--custom--radius--lg)"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"52%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:52%"><!-- wp:group {"metadata":{"name":"Heading"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-group"><!-- wp:heading {"fontSize":"x-large"} -->
<h2 class="wp-block-heading has-x-large-font-size"><?php esc_html_e( 'A good find should have a name behind it.', 'digimia' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"main-accent","fontSize":"lead"} -->
<p class="has-main-accent-color has-text-color has-lead-font-size"><?php esc_html_e( 'Digimia is a small shop for independent designers and studios. Every download starts with someone who cared enough to make it, then share it so another project can move forward.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->

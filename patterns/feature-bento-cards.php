<?php
/**
 * Title: Bento feature cards
 * Slug: digimia/feature-bento-cards
 * Description: A centered heading over a wide tinted card with an image, and two cards below with images at their base.
 * Categories: digimia/features
 * Keywords: features, bento, cards, benefits, images
 * Viewport Width: 1500
 * Block Types:
 * Post Types:
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"section","metadata":{"name":"Features"},"align":"full","anchor":"why-digimia","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"constrained"}} -->
<section id="why-digimia" class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Heading"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","fontSize":"x-large"} -->
<h2 class="wp-block-heading has-text-align-center has-x-large-font-size"><?php esc_html_e( 'Less setup, more shipping.', 'digimia' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"main-accent","fontSize":"lead"} -->
<p class="has-text-align-center has-main-accent-color has-text-color has-lead-font-size"><?php esc_html_e( 'Every download is ready to use, clearly licensed, and kept up to date, so you can get straight to the work that matters.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Cards"},"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"metadata":{"name":"Wide card"},"style":{"border":{"radius":"var:custom|radius|xl"},"spacing":{"padding":{"top":"var:preset|spacing|large","bottom":"var:preset|spacing|large","left":"var:preset|spacing|x-large","right":"var:preset|spacing|large"}}},"backgroundColor":"primary-alt-accent","layout":{"type":"default"}} -->
<div class="wp-block-group has-primary-alt-accent-background-color has-background" style="border-radius:var(--wp--custom--radius--xl);padding-top:var(--wp--preset--spacing--large);padding-right:var(--wp--preset--spacing--large);padding-bottom:var(--wp--preset--spacing--large);padding-left:var(--wp--preset--spacing--x-large)"><!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|x-large"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"42%","style":{"spacing":{"blockGap":"var:preset|spacing|small"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:42%"><!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Ready on day one', 'digimia' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"main-accent"} -->
<p class="has-main-accent-color has-text-color"><?php esc_html_e( 'Templates, kits, and presets arrive complete, with source files and a short quick-start guide. Open them, swap in your content, and launch.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"58%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:58%"><!-- wp:image {"aspectRatio":"16/9","scale":"cover","sizeSlug":"large","linkDestination":"none","style":{"border":{"radius":"var:custom|radius|base"}}} -->
<figure class="wp-block-image size-large has-custom-border"><img src="<?php echo esc_url( get_template_directory_uri() . '/patterns/images/maker-laptop.webp' ); ?>" alt="<?php esc_attr_e( 'A creator working on a laptop at a desk by the window', 'digimia' ); ?>" style="border-radius:var(--wp--custom--radius--base);aspect-ratio:16/9;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Card row"},"style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"grid","columnCount":2,"minimumColumnWidth":"20rem"}} -->
<div class="wp-block-group"><!-- wp:group {"metadata":{"name":"Card"},"style":{"border":{"radius":"var:custom|radius|xl"},"spacing":{"padding":{"top":"var:preset|spacing|x-large","bottom":"0","left":"var:preset|spacing|x-large","right":"var:preset|spacing|x-large"},"blockGap":"var:preset|spacing|large"},"dimensions":{"minHeight":"100%"}},"backgroundColor":"border-light","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group has-border-light-background-color has-background" style="border-radius:var(--wp--custom--radius--xl);min-height:100%;padding-top:var(--wp--preset--spacing--x-large);padding-right:var(--wp--preset--spacing--x-large);padding-bottom:0;padding-left:var(--wp--preset--spacing--x-large)"><!-- wp:group {"metadata":{"name":"Text"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"},"layout":{"selfStretch":"fill","flexSize":null}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Licenses you can read', 'digimia' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"main-accent"} -->
<p class="has-main-accent-color has-text-color"><?php esc_html_e( 'Plain-language terms on every product page, so you know exactly where you can use what you buy.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:image {"aspectRatio":"16/10","scale":"cover","sizeSlug":"large","linkDestination":"none","style":{"border":{"radius":{"topLeft":"var:custom|radius|base","topRight":"var:custom|radius|base"}}}} -->
<figure class="wp-block-image size-large has-custom-border"><img src="<?php echo esc_url( get_template_directory_uri() . '/patterns/images/desk-notes.webp' ); ?>" alt="<?php esc_attr_e( 'An open notebook, pencil, and phone on a white desk', 'digimia' ); ?>" style="border-top-left-radius:var(--wp--custom--radius--base);border-top-right-radius:var(--wp--custom--radius--base);aspect-ratio:16/10;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Card"},"style":{"border":{"radius":"var:custom|radius|xl"},"spacing":{"padding":{"top":"var:preset|spacing|x-large","bottom":"0","left":"var:preset|spacing|x-large","right":"var:preset|spacing|x-large"},"blockGap":"var:preset|spacing|large"},"dimensions":{"minHeight":"100%"}},"backgroundColor":"tertiary","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group has-tertiary-background-color has-background" style="border-radius:var(--wp--custom--radius--xl);min-height:100%;padding-top:var(--wp--preset--spacing--x-large);padding-right:var(--wp--preset--spacing--x-large);padding-bottom:0;padding-left:var(--wp--preset--spacing--x-large)"><!-- wp:group {"metadata":{"name":"Text"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"},"layout":{"selfStretch":"fill","flexSize":null}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Updates for life', 'digimia' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"main-accent"} -->
<p class="has-main-accent-color has-text-color"><?php esc_html_e( 'Buy once and get every new version in your account, with release notes that explain each change.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:image {"aspectRatio":"16/10","scale":"cover","sizeSlug":"large","linkDestination":"none","style":{"border":{"radius":{"topLeft":"var:custom|radius|base","topRight":"var:custom|radius|base"}}}} -->
<figure class="wp-block-image size-large has-custom-border"><img src="<?php echo esc_url( get_template_directory_uri() . '/patterns/images/studio-workday.webp' ); ?>" alt="<?php esc_attr_e( 'A creator editing photos at a desktop computer', 'digimia' ); ?>" style="border-top-left-radius:var(--wp--custom--radius--base);border-top-right-radius:var(--wp--custom--radius--base);aspect-ratio:16/10;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

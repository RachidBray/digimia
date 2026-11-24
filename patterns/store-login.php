<?php
/**
 * Title: Sign in page
 * Slug: digimia/store-login
 * Description: An EDD sign-in form beside a tinted panel with account benefits and a review.
 * Categories: digimia/store
 * Keywords: login, sign in, account, EDD
 * Viewport Width: 1500
 * Block Types: core/post-content
 * Post Types: page
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"section","metadata":{"name":"Sign in page"},"align":"full","className":"digimia-auth","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|x-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull digimia-auth" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--x-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|x-large","left":"var:preset|spacing|xx-large"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"verticalAlignment":"center","style":{"spacing":{"padding":{"top":"var:preset|spacing|large","bottom":"var:preset|spacing|large"}}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="padding-top:var(--wp--preset--spacing--large);padding-bottom:var(--wp--preset--spacing--large)"><!-- wp:group {"metadata":{"name":"Form"},"className":"digimia-form-card","style":{"spacing":{"blockGap":"var:preset|spacing|large"}},"layout":{"type":"constrained","contentSize":"28rem","justifyContent":"left"}} -->
<div class="wp-block-group digimia-form-card"><!-- wp:group {"metadata":{"name":"Heading"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":1,"fontSize":"x-large"} -->
<h1 class="wp-block-heading has-x-large-font-size"><?php esc_html_e( 'Welcome back.', 'digimia' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"main-accent"} -->
<p class="has-main-accent-color has-text-color"><?php esc_html_e( 'Sign in to download your files, manage your licenses, and see your orders.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:edd/login /-->

<!-- wp:paragraph {"textColor":"main-accent","fontSize":"small"} -->
<p class="has-main-accent-color has-text-color has-small-font-size"><?php esc_html_e( 'New here?', 'digimia' ); ?> <a href="<?php echo esc_url( home_url( '/register/' ) ); ?>"><?php esc_html_e( 'Create an account', 'digimia' ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"stretch"} -->
<div class="wp-block-column is-vertically-aligned-stretch"><!-- wp:group {"metadata":{"name":"Panel"},"style":{"border":{"radius":"var:custom|radius|xl"},"spacing":{"padding":{"top":"var:preset|spacing|x-large","bottom":"var:preset|spacing|x-large","left":"var:preset|spacing|x-large","right":"var:preset|spacing|x-large"},"blockGap":"var:preset|spacing|x-large"},"dimensions":{"minHeight":"100%"}},"backgroundColor":"primary-alt-accent","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch","verticalAlignment":"space-between"}} -->
<div class="wp-block-group has-primary-alt-accent-background-color has-background" style="border-radius:var(--wp--custom--radius--xl);min-height:100%;padding-top:var(--wp--preset--spacing--x-large);padding-right:var(--wp--preset--spacing--x-large);padding-bottom:var(--wp--preset--spacing--x-large);padding-left:var(--wp--preset--spacing--x-large)"><!-- wp:group {"metadata":{"name":"Benefits"},"style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"fontSize":"large"} -->
<h2 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Everything you bought, in one library.', 'digimia' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:list {"className":"is-style-list-check"} -->
<ul class="wp-block-list is-style-list-check"><!-- wp:list-item -->
<li><?php esc_html_e( 'Download any file, on any device', 'digimia' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Get every update at no extra cost', 'digimia' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Find invoices and license keys in one place', 'digimia' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Review"},"className":"digimia-review","style":{"border":{"radius":"var:custom|radius|lg","width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|large","bottom":"var:preset|spacing|large","left":"var:preset|spacing|large","right":"var:preset|spacing|large"},"blockGap":"var:preset|spacing|medium"}},"backgroundColor":"base","borderColor":"border-light","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group digimia-review has-border-color has-border-light-border-color has-base-background-color has-background" style="border-width:1px;border-radius:var(--wp--custom--radius--lg);padding-top:var(--wp--preset--spacing--large);padding-right:var(--wp--preset--spacing--large);padding-bottom:var(--wp--preset--spacing--large);padding-left:var(--wp--preset--spacing--large)"><!-- wp:paragraph {"className":"digimia-stars"} -->
<p class="digimia-stars"><span aria-hidden="true">★★★★★</span><span class="screen-reader-text"><?php esc_html_e( 'Rated 5 out of 5', 'digimia' ); ?></span></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"main"} -->
<p class="has-main-color has-text-color"><?php esc_html_e( '“Saved me a full week on a client launch. The files are tidy and the docs answer every question.”', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"metadata":{"name":"Reviewer"},"className":"digimia-review__author","style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group digimia-review__author"><!-- wp:image {"width":"40px","sizeSlug":"thumbnail","linkDestination":"none","style":{"border":{"radius":"var:custom|radius|full"}}} -->
<figure class="wp-block-image size-thumbnail is-resized has-custom-border"><img src="<?php echo esc_url( get_template_directory_uri() . '/patterns/images/avatar-1.webp' ); ?>" alt="<?php esc_attr_e( 'Portrait of Leo Martins', 'digimia' ); ?>" style="border-radius:var(--wp--custom--radius--full);width:40px"/></figure>
<!-- /wp:image -->

<!-- wp:group {"metadata":{"name":"Name"},"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"style":{"typography":{"fontWeight":"600"}},"fontSize":"small"} -->
<p class="has-small-font-size" style="font-weight:600"><?php esc_html_e( 'Leo Martins', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"main-accent","fontSize":"small"} -->
<p class="has-main-accent-color has-text-color has-small-font-size"><?php esc_html_e( 'Freelance designer', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->

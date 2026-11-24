<?php
/**
 * Title: Sidebar
 * Slug: digimia/sidebar
 * Description: Sidebar with search, latest notes, topics, and a shop panel. Used by the Sidebar template part.
 * Categories: digimia/posts
 * Keywords: sidebar, aside, search, categories, latest posts
 * Viewport Width: 400
 * Block Types: core/template-part/sidebar
 * Inserter: false
 */
?>
<!-- wp:group {"metadata":{"name":"Sidebar"},"style":{"spacing":{"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group"><!-- wp:search {"label":"<?php esc_attr_e( 'Search', 'digimia' ); ?>","showLabel":false,"placeholder":"<?php esc_attr_e( 'Search', 'digimia' ); ?>","buttonText":"<?php esc_attr_e( 'Search', 'digimia' ); ?>"} /-->

<!-- wp:group {"metadata":{"name":"Latest notes"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group"><!-- wp:heading {"fontSize":"medium"} -->
<h2 class="wp-block-heading has-medium-font-size"><?php esc_html_e( 'Latest notes', 'digimia' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:latest-posts {"postsToShow":4,"displayPostDate":true,"fontSize":"small","className":"digimia-sidebar-posts"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Topics"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group"><!-- wp:heading {"fontSize":"medium"} -->
<h2 class="wp-block-heading has-medium-font-size"><?php esc_html_e( 'Topics', 'digimia' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:categories {"showPostCounts":true,"fontSize":"small","className":"digimia-sidebar-topics"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Shop"},"className":"is-style-section-brand","style":{"spacing":{"blockGap":"var:preset|spacing|large","padding":{"top":"var:preset|spacing|x-large","bottom":"var:preset|spacing|x-large","left":"var:preset|spacing|x-large","right":"var:preset|spacing|x-large"}},"border":{"radius":"var:custom|radius|lg"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group is-style-section-brand" style="border-radius:var(--wp--custom--radius--lg);padding-top:var(--wp--preset--spacing--x-large);padding-right:var(--wp--preset--spacing--x-large);padding-bottom:var(--wp--preset--spacing--x-large);padding-left:var(--wp--preset--spacing--x-large)"><!-- wp:heading {"level":3,"fontSize":"medium"} -->
<h3 class="wp-block-heading has-medium-font-size"><?php esc_html_e( 'Tools for people who make things.', 'digimia' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Templates, presets, and kits with instant downloads and clear licenses.', 'digimia' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( \Digimia\edd_archive_url() ); ?>"><?php esc_html_e( 'Browse the shop', 'digimia' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

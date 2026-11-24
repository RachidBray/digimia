<?php
/**
 * Title: Post grid for archives
 * Slug: digimia/blog-grid-archive
 * Description: A post grid that inherits the query on index and archive pages.
 * Categories: digimia/posts
 * Keywords: blog, posts, query, loop
 * Viewport Width: 1280
 * Block Types: core/query
 * Post Types:
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"section","metadata":{"name":"Posts"},"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:query {"queryId":62,"query":{"perPage":9,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-query alignwide"><!-- wp:group {"metadata":{"name":"Posts"},"style":{"spacing":{"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|large"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"16rem"}} -->
<!-- wp:group {"metadata":{"name":"Post card"},"className":"digimia-post-card","style":{"border":{"radius":"var:custom|radius|lg","width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|large","bottom":"var:preset|spacing|large","left":"var:preset|spacing|large","right":"var:preset|spacing|large"},"blockGap":"var:preset|spacing|medium"},"dimensions":{"minHeight":"100%"}},"borderColor":"border-light","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group digimia-post-card has-border-color has-border-light-border-color" style="border-width:1px;border-radius:var(--wp--custom--radius--lg);min-height:100%;padding-top:var(--wp--preset--spacing--large);padding-right:var(--wp--preset--spacing--large);padding-bottom:var(--wp--preset--spacing--large);padding-left:var(--wp--preset--spacing--large)"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","style":{"border":{"radius":"var(--wp--custom--radius--base)"}}} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group"><!-- wp:post-terms {"term":"category","textColor":"primary","fontSize":"x-small","style":{"typography":{"fontWeight":"600","textTransform":"uppercase","letterSpacing":"0.12em"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}}} /-->

<!-- wp:post-title {"level":2,"isLink":true,"fontSize":"medium"} /-->

<!-- wp:post-excerpt {"moreText":"","excerptLength":24,"className":"is-style-excerpt-truncate-2","textColor":"main-accent"} /--></div>
<!-- /wp:group -->

<!-- wp:post-date {"textColor":"main-accent","fontSize":"small"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"textColor":"main-accent"} -->
<p class="has-main-accent-color has-text-color"><?php esc_html_e( 'No posts yet. New notes are on the way.', 'digimia' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:group --></div>
<!-- /wp:query --></section>
<!-- /wp:group -->

<?php
/**
 * Title: Post card
 * Slug: digimia/card-post
 * Description: A post card with featured image, title, date, and excerpt for query loops.
 * Categories: digimia/card, digimia/posts
 * Keywords: card, image, text, box, content, link, button
 * Viewport Width: 600
 * Block Types:
 * Post Types:
 * Inserter: true
 */
?>
<!-- wp:group {"metadata":{"name":"Post card"},"className":"digimia-post-card","style":{"border":{"radius":"var:custom|radius|lg","width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|large","bottom":"var:preset|spacing|large","left":"var:preset|spacing|large","right":"var:preset|spacing|large"},"blockGap":"var:preset|spacing|medium"},"dimensions":{"minHeight":"100%"}},"borderColor":"border-light","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group digimia-post-card has-border-color has-border-light-border-color" style="border-width:1px;border-radius:var(--wp--custom--radius--lg);min-height:100%;padding-top:var(--wp--preset--spacing--large);padding-right:var(--wp--preset--spacing--large);padding-bottom:var(--wp--preset--spacing--large);padding-left:var(--wp--preset--spacing--large)"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","style":{"border":{"radius":"var(--wp--custom--radius--base)"}}} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group"><!-- wp:post-terms {"term":"category","textColor":"primary","fontSize":"x-small","style":{"typography":{"fontWeight":"600","textTransform":"uppercase","letterSpacing":"0.12em"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}}} /-->

<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"medium"} /-->

<!-- wp:post-excerpt {"moreText":"","excerptLength":24,"className":"is-style-excerpt-truncate-2","textColor":"main-accent"} /--></div>
<!-- /wp:group -->

<!-- wp:post-date {"textColor":"main-accent","fontSize":"small"} /--></div>
<!-- /wp:group -->

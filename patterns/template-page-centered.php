<?php
/**
 * Title: Page, centered
 * Slug: digimia/template-page-centered
 * Description: A centered page layout where the content sits in a container in the middle of the page.
 * Categories: digimia/pages
 * Keywords: page, centered
 * Viewport Width: 1500
 * Template Types: page
 * Inserter: false
 */
?>
<!-- wp:template-part {"slug":"header","tagName":"header","area":"header"} /-->

<!-- wp:group {"tagName":"main","metadata":{"name":"Content"},"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"default"}} -->
<main class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0"><!-- wp:group {"tagName":"section","metadata":{"name":"Page"},"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Page header"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-title {"level":1,"fontSize":"xx-large"} /--></div>
<!-- /wp:group -->

<!-- wp:post-featured-image {"aspectRatio":"16/9","style":{"border":{"radius":"var(--wp--custom--radius--lg)"}}} /-->

<!-- wp:post-content {"layout":{"type":"constrained"}} /--></section>
<!-- /wp:group --></main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer","area":"footer"} /-->

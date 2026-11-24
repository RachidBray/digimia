<?php
/**
 * Title: Archive page
 * Slug: digimia/template-page-archive
 * Description: The page that shows archives for categories, tags, and more.
 * Categories: digimia/pages
 * Keywords: page, full-width
 * Viewport Width: 1500
 * Inserter: false
 */
?>
<!-- wp:template-part {"slug":"header","tagName":"header","area":"header"} /-->

<!-- wp:group {"tagName":"main","metadata":{"name":"Content"},"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"default"}} -->
<main class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0"><!-- wp:group {"tagName":"section","metadata":{"name":"Page header"},"align":"full","className":"is-style-section-soft","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull is-style-section-soft" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Heading"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:query-title {"type":"archive","showPrefix":false,"level":1,"textAlign":"center","fontSize":"xx-large"} /-->

<!-- wp:term-description {"textAlign":"center","textColor":"main-accent","fontSize":"lead"} /--></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"digimia/blog-grid-archive"} /--></main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer","area":"footer"} /-->

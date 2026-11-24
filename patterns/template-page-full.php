<?php
/**
 * Title: Page, full width without title
 * Slug: digimia/template-page-full
 * Description: A full-width page layout without a title, for building pages with patterns.
 * Categories: digimia/pages
 * Keywords: page, full-width
 * Viewport Width: 1500
 * Template Types: page
 * Inserter: false
 */
?>
<!-- wp:template-part {"slug":"header","tagName":"header","area":"header"} /-->

<!-- wp:group {"tagName":"main","metadata":{"name":"Content"},"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"default"}} -->
<main class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0"><!-- wp:post-content {"layout":{"type":"constrained"}} /--></main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer","area":"footer"} /-->

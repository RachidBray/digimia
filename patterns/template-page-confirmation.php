<?php
/**
 * Title: Page, purchase confirmation
 * Slug: digimia/template-page-confirmation
 * Description: The EDD purchase confirmation page: a success mark above the title, then the order and its files.
 * Categories: digimia/pages
 * Keywords: page, confirmation, thank you, receipt, store, EDD
 * Viewport Width: 1500
 * Template Types: page
 * Inserter: false
 */
?>
<!-- wp:template-part {"slug":"header","tagName":"header","area":"header"} /-->

<!-- wp:group {"tagName":"main","metadata":{"name":"Content"},"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"default"}} -->
<main class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0"><!-- wp:group {"tagName":"section","metadata":{"name":"Confirmation"},"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|large"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Page header"},"className":"digimia-confirmation-header","layout":{"type":"constrained"}} -->
<div class="wp-block-group digimia-confirmation-header"><!-- wp:post-title {"level":1,"fontSize":"x-large"} /--></div>
<!-- /wp:group -->

<!-- wp:post-content {"className":"digimia-confirmation-content","layout":{"type":"constrained"}} /--></section>
<!-- /wp:group --></main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer","area":"footer"} /-->

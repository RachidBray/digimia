<?php
/**
 * Title: Product purchase card
 * Slug: digimia/product-purchase-card
 * Description: The current product's price, license options, and buy button in a card. For product page templates.
 * Categories: digimia/products
 * Keywords: product, price, buy, purchase, license, EDD, sidebar
 * Viewport Width: 500
 * Inserter: true
 */
?>
<!-- wp:group {"metadata":{"name":"Purchase card"},"anchor":"purchase","className":"digimia-purchase-card","style":{"spacing":{"blockGap":"var:preset|spacing|medium"}},"layout":{"type":"default"}} -->
<div id="purchase" class="wp-block-group digimia-purchase-card"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"digimia/product","args":{"key":"price"}}}},"className":"digimia-product-price","fontSize":"x-large"} -->
<p class="digimia-product-price has-x-large-font-size"></p>
<!-- /wp:paragraph -->

<!-- wp:edd/buy-button {"show_price":false} /-->

<!-- wp:list {"className":"digimia-purchase-assurances","fontSize":"small"} -->
<ul class="wp-block-list digimia-purchase-assurances has-small-font-size"><!-- wp:list-item -->
<li><?php esc_html_e( 'Instant download after checkout', 'digimia' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Free updates in your account', 'digimia' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Secure payment', 'digimia' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group -->

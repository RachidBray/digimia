<?php
/**
 * Title: Pricing: comparison table
 * Slug: digimia/pricing-comparison
 * Description: Licenses compared feature by feature in a table, with a buy action below.
 * Categories: digimia/pricing
 * Keywords: pricing, comparison, compare, table, license, plans, features
 * Viewport Width: 1500
 * Block Types:
 * Post Types:
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"section","metadata":{"name":"Pricing"},"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xx-large","bottom":"var:preset|spacing|xx-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"blockGap":"var:preset|spacing|x-large"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xx-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--xx-large);padding-left:var(--wp--preset--spacing--medium)"><!-- wp:group {"metadata":{"name":"Heading"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","fontSize":"x-large"} -->
<h2 class="wp-block-heading has-text-align-center has-x-large-font-size"><?php esc_html_e( 'Every license, side by side.', 'digimia' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"main-accent","fontSize":"lead"} -->
<p class="has-text-align-center has-main-accent-color has-text-color has-lead-font-size"><?php esc_html_e( 'All licenses are one-time payments with lifetime updates. Pick the one that matches how you will use it.', 'digimia' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:table {"hasFixedLayout":true,"align":"wide","className":"is-style-comparison"} -->
<figure class="wp-block-table alignwide is-style-comparison"><table class="has-fixed-layout"><thead><tr><th><?php esc_html_e( 'License', 'digimia' ); ?></th><th><?php esc_html_e( 'Personal', 'digimia' ); ?></th><th><?php esc_html_e( 'Commercial', 'digimia' ); ?></th><th><?php esc_html_e( 'Extended', 'digimia' ); ?></th></tr></thead><tbody><tr><td><?php esc_html_e( 'Price', 'digimia' ); ?></td><td><?php esc_html_e( '$29', 'digimia' ); ?></td><td><?php esc_html_e( '$79', 'digimia' ); ?></td><td><?php esc_html_e( '$249', 'digimia' ); ?></td></tr><tr><td><?php esc_html_e( 'End products', 'digimia' ); ?></td><td><?php esc_html_e( '1', 'digimia' ); ?></td><td><?php esc_html_e( 'Unlimited', 'digimia' ); ?></td><td><?php esc_html_e( 'Unlimited', 'digimia' ); ?></td></tr><tr><td><?php esc_html_e( 'Client work', 'digimia' ); ?></td><td>—</td><td><strong>✓</strong></td><td><strong>✓</strong></td></tr><tr><td><?php esc_html_e( 'Use in items for sale', 'digimia' ); ?></td><td>—</td><td>—</td><td><strong>✓</strong></td></tr><tr><td><?php esc_html_e( 'Source files', 'digimia' ); ?></td><td><strong>✓</strong></td><td><strong>✓</strong></td><td><strong>✓</strong></td></tr><tr><td><?php esc_html_e( 'Lifetime updates', 'digimia' ); ?></td><td><strong>✓</strong></td><td><strong>✓</strong></td><td><strong>✓</strong></td></tr><tr><td><?php esc_html_e( 'Priority support', 'digimia' ); ?></td><td>—</td><td><strong>✓</strong></td><td><strong>✓</strong></td></tr><tr><td><?php esc_html_e( 'Team seats', 'digimia' ); ?></td><td><?php esc_html_e( '1', 'digimia' ); ?></td><td><?php esc_html_e( '3', 'digimia' ); ?></td><td><?php esc_html_e( '10', 'digimia' ); ?></td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Buy a license', 'digimia' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Ask a question', 'digimia' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></section>
<!-- /wp:group -->

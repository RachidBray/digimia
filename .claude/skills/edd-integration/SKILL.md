---
name: edd-integration
description: Use when adding, changing, or debugging Easy Digital Downloads (EDD) support in the Digimia theme — download grids, single download pages, price and license options, buy buttons, cart, checkout, receipts, and account pages. Covers the EDD block suite, theme.json block styles, pattern composition, template overrides, and plugin guards.
license: GPL-2.0-or-later
metadata:
  audience: developers
  domain: edd
  plugin: easy-digital-downloads
---

## What I do

Guide EDD integration inside an FSE block theme, in the order of preference that keeps the theme update-safe and editor-friendly.

## When to use me

Use this before writing any EDD PHP, CSS, or template file. Also use it during review to check that EDD work follows the integration ladder instead of reaching for `edd_templates/` first.

## Inventory: what is actually installed

- Plugin: Easy Digital Downloads **Pro 3.7.3** (`wp-content/plugins/easy-digital-downloads-pro`), plus the extensions listed in `AGENTS.md` (Software Licensing, Recurring Payments, Reviews, Checkout Fields Manager, Variable Pricing Descriptions and Switcher; Social Login is installed but inactive).
- WordPress **7.1.5**. Theme targets block themes, so EDD's block suite is the primary surface.
- The theme has a presentation-only EDD layer: `templates/archive-download.html`, `templates/single-download.html`, `patterns/product-*.php`, store page patterns (`store-checkout`, `store-confirmation`, `store-receipt`, `store-account`, `store-sign-in`), `inc/edd.php`, and `src/scss/blocks/_edd-{downloads,buy-button,terms,cart}.scss`.
- `edd/buy-button` falls back to `get_the_ID()`, so it works inside a core Query Loop over `download` posts. Prefer that for custom product cards.

## The integration ladder — use the highest rung that works

1. **`theme.json` block styles.** EDD blocks are real blocks and accept `styles.blocks` overrides. Start here for color, typography, spacing, border, and button treatment.
   ```json
   "styles": {
     "blocks": {
       "edd/downloads": { "spacing": { "blockGap": "var:preset|spacing|medium" } },
       "edd/buy-button": { "color": { "background": "var:preset|color|primary" } }
     }
   }
   ```
2. **`src/scss/blocks/_edd-*.scss` for block-level CSS.** Each file compiles to `assets/styles/<name>.css` and is auto-enqueued per block by `inc/` wiring. Use `.edd-*` selectors and theme preset variables, never new `:root` tokens.
3. **Patterns using EDD blocks.** Compose `edd/downloads`, `edd/buy-button`, `edd/cart`, etc. into `digimia/*` patterns. This is the main deliverable for page layouts.
4. **Filters and hooks.** Use when markup structure is fine but content or attributes must change (`edd_purchase_link_args`, `edd_get_download_price`, `edd_downloads_query`, `edd_checkout_cart_item_title_after`, etc.).
5. **Template overrides in `edd_templates/`.** Last resort. You take ownership of that file across plugin updates.

Do **not** copy plugin templates until rungs 1–4 are exhausted. Document every override in `docs/developer/edd-integration.md`.

## EDD block inventory (3.7.3)

| Block | Use |
| --- | --- |
| `edd/downloads` | Product grid/query. Attributes: `columns`, `number`, `orderby`, `order`, `category`, `tag`, `featured`, `price`, `purchase_link`, `pagination`, `image_location`, `image_size`, `content`. |
| `edd/buy-button` | Add-to-cart / purchase button for a single download. |
| `edd/cart` | Cart contents. |
| `edd/checkout` | Full checkout form (cart + purchase form + gateways). |
| `edd/confirmation` | Purchase confirmation. |
| `edd/receipt` | Receipt page. |
| `edd/user-downloads` | Customer's downloadable files. |
| `edd/order-history` | Customer order list. |
| `edd/login` / `edd/register` / `edd/profile-editor` | Account surfaces. |
| `edd/terms` | Terms agreement. |
| `edd/currency-selector` (Pro) | Currency switcher. |
| `edd/checkout-cart`, `edd/checkout-discount-form`, `edd/checkout-payment-info`, `edd/checkout-personal-info` (3.7) | Checkout parts as separate blocks, for custom checkout layouts. `edd/checkout` still renders the whole form. |
| `edd/subscriptions`, `edd/subscription-details` (Recurring Payments) | Customer subscriptions in the account. |
| `edd-reviews/edd-review-block` (Reviews) | Embeds one review. The product reviews section itself is appended to the description; see `inc/edd-reviews.php`. |

Checkout Fields Manager replaces the checkout's personal info with its own `#edd_checkout_user_info.cfm-form` fieldset; style both markups (see `docs/developer/edd-integration.md` → Checkout).

## Template override map (`edd_templates/`)

EDD resolves overrides in this order: child theme → parent theme → plugin `templates/`. Always mirror the plugin's relative path.

```
<theme>/edd_templates/
├── shortcode-content-price.php      # price output on listings
├── shortcode-content-title.php
├── shortcode-content-excerpt.php
├── shortcode-content-image.php
├── widget-cart.php                  # sidebar cart
├── widget-cart-item.php
├── widget-cart-empty.php
├── history-purchases.php            # account
├── history-downloads.php
└── checkout_cart.php
```

The block-based checkout and cart do **not** use these; they render through `includes/blocks/views/`. Overriding block views means copying from the plugin's `views/` tree, which is fragile. Prefer block attributes, `theme.json`, and CSS for those.

## Hard rules

- Guard every EDD call. In PHP: `if ( ! function_exists( 'edd_get_download' ) ) { return; }`. In templates/patterns, check `is_plugin_active()` only in admin context; on the front end prefer `function_exists()`.
- Never re-register an EDD block. Only style it.
- Escape everything: `esc_html( edd_get_download_price() )` is wrong because it returns formatted HTML — use `wp_kses_post()` for price output, `esc_url()` for links, `esc_attr()` for attributes.
- Prices: `edd_price()` echoes formatted HTML; `edd_get_download_price()` returns a raw number; `edd_get_download()` returns the post object. Do not mix them.
- Variable pricing: check `edd_has_variable_prices( $download_id )` before rendering price options. Do not assume a single price.
- Cart state is session-backed. Do not read `$_SESSION` directly; use `edd_get_cart_contents()`, `edd_get_cart_total()`, `edd_get_cart_quantity()`.
- Checkout must be a real EDD checkout page (`edd_is_checkout()`) for its scripts to load. Do not hand-roll a purchase form.
- Keep the `digimia` text domain and namespace conventions. Do not prefix EDD strings.

## Verification for EDD changes

1. `yarn build` (or `yarn build:dev`) if Sass/JS changed.
2. Visit: a download single page, `/downloads` archive, cart page, checkout page, purchase confirmation, and an account page while logged in.
3. Test logged out AND logged in.
4. Test light AND dark mode (`data-theme` attribute).
5. Test with an EDD page that has **variable pricing** and one with a **sale price**.
6. Confirm the EDD debug log (`Downloads → Tools → Debug Log`) stays clean.
7. Run `composer run wpcs:scan` on any new PHP (patterns are excluded by CI).

## Do not

- Do not edit files under `wp-content/plugins/easy-digital-downloads-pro/`.
- Do not add `!important` to fight EDD's own styles; increase specificity with the theme's block wrapper first.
- Do not create a new `:root` token for an EDD color. Reuse palette slugs.
- Do not override EDD templates "just in case". Each override is a maintenance liability.

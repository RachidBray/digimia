# Easy Digital Downloads presentation

Digimia uses EDD's block suite for the storefront. This layer is presentation only: EDD owns product data, purchase handling, order records, license behavior, and checkout. No legacy `edd_templates/` PHP overrides are present.

## Templates

- `templates/archive-download.html` composes `digimia/product-catalog` (the `edd/downloads` grid with pagination). The block runs its own query, so WordPress lazy-loads all its images; on the shop page its first image is the largest paint, so `edd_shop_first_image()` (`inc/edd.php`) loads it eagerly with high priority.
- Product pages use `templates/single-download.html` (the Showcase layout), a thin file referencing the `template-download-showcase` pattern: title and facts, then a large framed preview with the description below it, and a sticky aside beside it. It suits any product, image-led goods especially. Digimia Pro adds more product layouts, picked per download (editor → Template); without Pro, a download set to one of them shows this one.

The template keeps the price and purchase button above the fold on a 1440×900 screen. The purchase card carries the `purchase` anchor, so a `#purchase` link jumps to it (smooth, unless reduced motion is set).

The aside holds `product-purchase-card` (price, Buy Button, assurances) and `product-details-card` (category, released, last updated, version, files, formats, tags). The template ends with `product-related`. On stacked screens the columns step aside (`display: contents`) so the order is title → purchase → description → details (`_product-page.scss`).

## Patterns

| Pattern | Category | EDD blocks | Notes |
| --- | --- | --- | --- |
| `product-card-grid` | Products | `edd/buy-button` in a core Query Loop | Custom cards; the buy button resolves the looped download through `get_the_ID()`. |
| `product-spotlight` | Products, Hero | `edd/buy-button` in a core Query Loop | Latest download presented large. Change the query to pick another product. |
| `product-category-tiles` | Products | `edd/terms` | Tiles use the EDD term image when set. |
| `product-staff-picks` | Products | `edd/downloads` (`featured: "yes"`) | Shows only downloads marked featured in EDD, with a themed badge. |
| `product-editorial-shelf` | Products | `core/query` + `edd/buy-button` | Editorial shelf on the store home: a wide featured card over three product cards, limited to the store categories through `\Digimia\download_category_ids()`. |
| `hero-store-search` | Hero | `edd/terms` (chips) | Core search scoped to `post_type=download`. |
| `store-checkout` | Store Pages | `edd/checkout` | Starter pattern for the EDD checkout page. |
| `store-confirmation` | Store Pages | `edd/confirmation` | Starter pattern for the success page. |
| `store-receipt` | Store Pages | `edd/receipt` | Starter pattern for the receipt page. |
| `store-account` | Store Pages | `edd/user-downloads`, `[edd_license_keys]`, `edd/subscriptions`, `edd/order-history`, `edd/profile-editor` | Customer account with a section menu. |
| `store-sign-in` | Store Pages | `edd/login`, `edd/register` | Side-by-side sign-in and registration. |
| `store-login` | Store Pages | `edd/login` | Sign-in form beside a tinted benefits panel with a review; links to `/register/`. |
| `store-register` | Store Pages | `edd/register` | Registration form beside a tinted benefits panel with a review; links to the EDD login page. |
| `header-cart` | Headers | `edd/cart` (mini) | Header with the item-count cart link. |
| `page-shop`, `page-product-sales` | Pages | — | Compositions of the sections above. |

Pricing (`pricing-two-plans`, `pricing-three-plans`, `pricing-single-product`, `pricing-comparison`, `pricing-bundle-offer`), reviews, FAQ, how-it-works, what's-included, assurances, free-sample CTA, announcement bar, and store footer are static core-block sections written for digital goods.

Store page patterns declare `Block Types: core/post-content` and `Post Types: page`, so they are offered in the new-page pattern picker. Assign the resulting pages in **Downloads → Settings → Pages**.

## Buttons, borders, and forms inherit the theme

`inc/edd.php` makes EDD output theme components instead of its own styles:

- `edd_button_color_class` drops EDD's default `blue` class, and `edd_get_option_button_style` drops its `button` class (which paints buttons gray), on the front end, when the store owner has not saved a choice in **Downloads → Settings → Styles**. A saved choice is still respected.
- `edd_purchase_link_args` and `edd_checkout_button_purchase` add `.wp-element-button`, so theme.json button styles, section styles, and dark mode apply to purchase, add-to-cart, and checkout buttons.

`src/scss/_edd-elements.scss` maps the rest to tokens: EDD's button base (shape and size from `--wp--custom--button--*`), colors for EDD buttons that cannot carry the class (login, register, profile), `--edd-blocks-light-grey` → the semantic border, and the theme field size inside EDD block forms. Sign-in, registration, and lost-password forms get one full-width submit, a quiet "Lost password?" link, inline checkbox rows, and a tinted password-strength row. The strength row is the one place with fixed hues (red and amber for weak and medium, since the palette has no status colors). No `!important`.

### Store screens

EDD frames its store surfaces with a few shared classes (`.edd-blocks-form`, `.edd-blocks-orders__order`, `.edd-blocks__user-downloads`, `.edd-blocks-receipt__items` / `__totals`, the checkout cart `#edd_checkout_cart`, profile fieldsets). `_edd-elements.scss` turns each into the theme panel (`panel` mixin: padding large, radius lg, semantic border) and styles rows, legends, labels, `.edd-button-secondary`, the password meter, and `.edd-alert`. Inside a pattern card (`.digimia-form-card`) the card is the panel, so EDD's form frame is removed.

The checkout pattern uses EDD's native `two-thirds` layout (details and payment left, summary right); `_edd-checkout.scss` sets full-width theme-size fields, cart thumbnails, a prominent total, and a full-width purchase button.

### Single download template

`templates/single-download.html` places the EDD Buy Button block beside the product image. EDD also prints a purchase button after the content (`edd_after_download_content`); `inc/edd.php` removes that one only when the active block template already contains an `edd/buy-button` block, looking inside the patterns it references (`content_has_block()`), so a customized template without the block keeps EDD's button. The "Choose your license" heading (`digimia-license-heading`) only shows for products with license options.

### Product facts (block bindings)

`inc/edd-product.php` registers the `digimia/product` block bindings source. A Paragraph bound to it shows a fact of the download in context (product page or Query Loop item):

```json
"metadata":{"bindings":{"content":{"source":"digimia/product","args":{"key":"files"}}}}
```

| Key | Shows |
| --- | --- |
| `price` | "Free", the price, or for license options the preselected option's price. `edd-product-price.js` updates a `.digimia-product-price` in a `.digimia-purchase-card` when another license is picked. |
| `price_from` | "From $49" for license options, otherwise as `price` |
| `buy_label` | "Choose a license" for license options, otherwise "Buy now" (bound to a Button's text) |
| `files` | "3 files" |
| `formats` | File extensions, e.g. "FIG, PDF, ZIP" |
| `version` | `_edd_sl_version` (EDD Software Licensing), when set |
| `sales` | "1,240 sales". Not placed by the templates; add it where social proof helps. |
| `rating` | "4.7 (3 reviews)" with a star, linked to the product's reviews (EDD Reviews). First fact in the Banner, Showcase, and Guide meta rows. |

A fact that does not apply removes its block, and a `digimia-detail-row` group left with only its `digimia-detail-label` is removed too, so products never show empty rows. In the editor, `product-bindings.js` lists the facts in the block's Attributes panel and shows each fact's name in place of its value.

### Related products and breadcrumbs

A Query Loop with the `digimia-related-downloads` class (pattern `product-related`) lists other downloads from the product's categories, topped up with the latest ones, never the product itself. The product ID reaches the loop through `render_block_context` (a `render_block_data` change does not reach the Post Template because the Query block's attributes are already cached). Outside a product page the loop shows the latest downloads.

Core Breadcrumbs go through `download_category` on product pages (`block_core_breadcrumbs_post_type_settings`).

### Reviews (EDD Reviews)

EDD Reviews appends its section (`#edd-reviews`) to the product description. `inc/edd-reviews.php` changes its presentation through the extension's filters, without a template override:

- Each review renders through `review_markup()` (`edd_reviews_render_reviews_args` callback): CSS stars, the title, the text, then reviewer, date (no time), and a "Verified buyer" badge for customers who bought the product. EDD Reviews' IDs, hooks, voting, and reply link stay.
- A summary under the Reviews heading (`edd_reviews_title_after`): stars, "4.7 out of 5", "Based on 3 reviews".
- Stars are `.digimia-rating-stars` with `--digimia-rating` (0–5) set inline: one star mask filled to the rating in the `warning` color, so halves show and no Dashicons font is needed. EDD Reviews' star picker in the form still uses Dashicons and its script, in the theme colors.
- EDD Reviews loads its stylesheet and Dashicons (35 KB, holding up the first paint) on every page. `limit_review_assets()` keeps them to pages that can show reviews: product pages, the vendor feedback page, and posts using the `review` or `average_rating` shortcode or the review block, the same rule as the extension's own script. A page that asked for Dashicons while it rendered (EDD's register, password reset, and profile forms) keeps them, and the admin bar still pulls them in as its own dependency.
- The vote reads "Helpful? Yes No"; the extension's intro line is hidden. Yes, No, and Reply (shown to anyone signed in) are outline pills on one row (`.digimia-review__actions`).
- The reply form (`div#edd-reviews-reply`, printed after the section and moved under the review by WordPress's `comment-reply` script) is a panel with the same field and button styles as the review form. Its textarea carries the same ID, hence the `div` in the selector.
- Signed-out visitors see one line, "Sign in to write a review." ("Bought this product? …" when only buyers may review), linking to the EDD login page with `redirect_to` back to the reviews. The login form EDD Reviews prints after it is hidden.
- `review_stats()` gives the average and count of approved reviews (owner replies left out) for the `rating` fact and the summary.

Styles: `src/scss/_product-reviews.scss`. The submit button takes the theme button styles in `_edd-elements.scss`.

### Product cards with license options

A product with variable prices (Personal, Commercial, Extended) would list every license inside a narrow product card. `edd_card_license_link()` in `inc/edd.php` filters `edd_purchase_download_form`: anywhere except that product's own page, the form becomes a "Choose options" button linking to the product page, where the license selector shows ("From $X – Options" when the block shows the price on its button). This covers both the Buy Button block in Query Loop cards and EDD's Downloads block grid. Simple-priced products keep their Purchase button.

The theme's cards show the price beside the button, not on it: Query Loop cards bind a Paragraph to the `price_from` fact ("From $49" for license options), and `edd_downloads_price_beside_button()` moves the Downloads grid's price into the card footer, with "From" and the lowest price in place of EDD's price range.

## Linking pricing buttons to EDD

Pricing patterns (`pricing-*`) are static and their buttons link to `#`. Point each button at an EDD "add to cart" URL for the matching download and price option:

```
/checkout/?edd_action=add_to_cart&download_id=123&edd_options[price_id]=2
```

`download_id` is the download's post ID; `price_id` is the variable price index from the download's pricing options (omit it for single-price downloads).

## Archive page size

`Digimia\download_archive_page_size()` (`inc/edd.php`) shows nine downloads a page on the shop (`/downloads/`) and the product category and tag archives, to match the three-column grids. WordPress counts archive pages with the Reading setting, so with ten a page the shop grid (nine a page) would link to a last page that returns a 404.

## URL helpers

`inc/edd.php` provides display-only helpers used by patterns:

- `\Digimia\edd_page_url( $option, $fallback )` returns the permalink of an EDD page setting such as `purchase_page`, `success_page`, or `purchase_history_page`, or `home_url( $fallback )` when EDD or the page is missing.
- `\Digimia\edd_archive_url()` returns the `download` archive URL, falling back to `/downloads/`.

## Styles

Block-specific Sass compiles to `assets/styles/edd-*.css` and is enqueued only when the block is present (see `enqueue_block_stylesheets()` in `functions.php`):

- `_edd-downloads.scss` — card grid, home shelf variant, featured badge colors, and a fix for EDD's `repeat(2, 50%)` grid overflowing at tablet widths.
- `_edd-buy-button.scss` — variable prices as selectable license cards (price at the right edge), add-to-cart and checkout buttons. With EDD Variable Pricing Descriptions the whole option becomes the card, with its description under the name and the card clickable.
- `_edd-terms.scss` — category tiles (`digimia-term-grid`) and chips (`digimia-term-chips`).
- `_edd-cart.scss` — header mini cart and quantity badge.

Shared section styles (product cards, license tiers, reviews, store page panels) live in `src/scss/_storefront-sections.scss`.

## Requirements

- Easy Digital Downloads must be active for product and purchase blocks to render.
- With EDD off, pages still render without PHP notices: EDD blocks print nothing, and `skip_categories_without_taxonomy()` (`inc/blocks.php`) skips a Categories block set to product categories, which core would otherwise read without checking the taxonomy exists.
- Variable pricing and sale prices are rendered by EDD; do not replace its purchase form with a hand-built form.

## Verification

Check product cards, the spotlight, category tiles, and the single-download template in light and dark mode at ~600px, ~781px, and desktop widths. Confirm single price, variable pricing, sale pricing, and free downloads render through EDD. The checkout, confirmation, receipt, and account blocks still use EDD's default internal styling.

## Checkout

- EDD creates its Checkout page with a bare `edd/checkout` block. `inc/edd.php` (`edd_checkout_default_layout`) gives that block EDD's `two-thirds` layout at wide width when no layout is chosen; a layout picked in the block settings wins.
- `templates/page-checkout.html` (pattern `template-page-checkout`) is used for a page with the slug `checkout`: the title and a Continue shopping link at wide width above the checkout. A checkout page with another slug uses the normal page template and still gets the two columns.
- `src/scss/blocks/_edd-checkout.scss`: the form panels (Personal info, Payment method, gateway fieldsets) share one panel style with numbered step badges; first and last name sit side by side from 600px; payment methods are selectable cards with a radio mark; the order summary is a sticky panel on the right (columns 3:2) with one-line item rows and a label / amount total. Rules hang off `#edd_checkout_form_wrap.wp-block-edd-checkout` to outrank EDD's ID selectors without `!important`.
- Discounts (in the order summary): the code field spans the row with an outline Apply at the same height; an applied code reads like the Total row (label left, amount right) with the theme trash icon; the "invalid" message is a full-width error alert. EDD sets several of these with ID selectors, inline `display`, and `padding: 0 !important` on the wrapper, so spacing uses margins and gaps.
- EDD Checkout Fields Manager replaces the personal info with its own fieldset (`#edd_checkout_user_info.cfm-form`, fields in `.cfm-el`) and leaves EDD's user details wrapper empty. The checkout styles cover both: the same numbered panel and paired names, help text under the field as in EDD's form, every CFM field type (text, select, radio and checkbox lists, textarea, date, URL, section break as a sub-heading under a hairline), and no extra gap from the empty wrapper. CFM's own fixed select height and grey borders, and EDD's border-less radios, are overridden in the checkout scope.
- PayPal: `edd_paypal_smart_button_style` sets `shape: pill`. PayPal draws its buttons in frames, so colors stay PayPal's; the containers get `color-scheme: light` so the frames stay transparent in dark mode. Google Pay renders in the page and gets the pill radius from CSS.

## Add to cart

- EDD's "Added to cart" note stays in the page for screen readers (its wrapper is `aria-live`) but is visually hidden: it no longer covers the button for its 3 seconds. The next step shows at once.
- `src/js/edd-cart-feedback.js` (built to `assets/js/edd-cart-feedback.js`, enqueued in `inc/edd.php` with `edd-ajax` as a dependency, so it only prints where EDD's AJAX cart runs) listens to EDD's jQuery `edd_cart_item_added` event. It adds `.digimia-just-added` to the clicked button's `.edd_purchase_submit_wrapper` for 2.4 seconds and bumps the header cart count (`.digimia-bump`).
- The Checkout link always carries a check icon (the product is in the cart, also after a reload); right after an add the check pops in and the button rings once. In EDD's multi-option mode, where the Add button can stay, it gets the check briefly. No animation with `prefers-reduced-motion`.
- Works with every EDD cart setting: **Redirect to Checkout** leaves the page before the feedback runs; **Cart Preview** opens its drawer from the same event.
- Cart Preview drawer: EDD only loads it when buy buttons or the mini cart are in the page content, which block templates never are, so `inc/edd.php` returns true from `edd_cart_preview_should_load` (EDD still skips the checkout page and the disabled setting). The drawer renders in Shadow DOM: `_edd-elements.scss` sets EDD's `--edd-cart-preview-*` variables on the `edd-cart-preview` host (page styles outrank its `:host` defaults and follow palette and dark mode) and styles the exposed `::part()`s (title, item rows, pill buttons, the floating trigger).

## After purchase and account

- `templates/page-confirmation.html` (pattern `template-page-confirmation`) is used for EDD's `confirmation` page: a success mark above the title, and EDD's default "Thank you for your purchase!" paragraph as the intro line.
- Confirmation, receipt, and Account share one look for purchased files: product names at full strength, every file as an outline download chip (`download-simple` icon), and the order status as a chip in the status colors. `inc/edd.php` turns the receipt's "Products" h3 into an h2 so headings do not skip a level.
- `store-account` has a section menu (`digimia-account-nav`, sticky beside the sections from 782px, a scrolling row of chips on phones) and five sections with anchors: Downloads, Licenses, Subscriptions, Orders, Profile. `inc/edd-account.php` removes Licenses and Subscriptions, and their menu links, unless EDD Software Licensing / Recurring Payments is active and the customer has a license / subscription. The pattern itself only includes those sections while the extension is active (`account_section_available()`), so a store without Recurring Payments never sees an unsupported Subscriptions block in the editor; a page saved with a section keeps it, hidden until the extension is active. Sections are separated by CSS hairlines, so a removed section leaves no double line. `src/js/edd-account.js` marks the menu link of the section in view (`aria-current`) and adds a Copy button to each license key. Styles: `src/scss/_account.scss`.
- Licenses (`[edd_license_keys]`): the extension's table becomes one card per license with CSS only (cells are `display: contents`; parts are ordered in a flex row): product and status chip, the key in a monospace field with Copy, expiry and activations, then Manage Sites / Extend / Upgrades as outline pills, the purchase link, and the renewal note. Manage Sites and the per-order overview (`?action=manage_licenses`) replace the account content; their tables, the add-site form, and the outline Go back button are styled too. Set EDD's Purchase History page to the Account page so these links open there.
- Subscriptions (`edd/subscriptions`): each subscription is a panel with a status chip; `inc/edd-account.php` adds the status class (`is-active`, `is-cancelled`, …) and `#subscriptions` to the links between the list, the details, and the payment update, so the reloaded page opens at the section. All Subscriptions, Subscription Details, and Cancel are outline buttons (Cancel in the error color); the payment update form is a panel.
- `store-account` keeps its section groups in default layout: as flex items, EDD's auto-fit grid rows are measured before their width is known and the Downloads panel grew by about one row of empty space. Profile fields sit in pairs from 600px.
- Header account link: `header-cart` and `header-banner` place an icon-only Button (`user` icon, class `digimia-account-link`) before the mini cart. It links to EDD's Login Redirect Page (falling back to `/account/`); for visitors who are not signed in, `inc/edd.php` points it to the EDD login page with the label "Sign in".
- Local demo setup (not shipped): an Account page from `store-account`, EDD's Login Redirect Page and Purchase History page set to it, and a `testbuyer` customer with Store Gateway orders, including Formwise Pro (a licensed, yearly product) with a license on two sites and an active subscription.

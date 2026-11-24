---
name: pattern-authoring
description: Use when creating or editing a Digimia block pattern — new layout patterns, card patterns, page compositions, or template/part changes that reference patterns. Enforces the header format, category slugs, translation rules, and image path conventions this repo uses.
license: GPL-2.0-or-later
metadata:
  audience: developers
  domain: patterns
---

## What I do

Produce patterns that match the existing files and survive the pattern tool.

## The free set

The theme's `patterns/` holds only what the free demo pages and the theme's templates use (51 patterns); other designs belong in Digimia Pro. A free pattern, template, or part never references a Pro design.

## When to use me

Use for any new file in `patterns/`, any change to `templates/*.html` or `parts/*.html` that composes patterns, or when a design request is best solved by a pattern rather than PHP.

## Header contract

Every pattern is a PHP file beginning with a docblock:

```php
<?php
/**
 * Title: Card — Product
 * Slug: digimia/product-card
 * Description: A downloadable product card with image, title, price, and buy button.
 * Categories: digimia/products
 * Keywords: card, product, download, edd
 * Viewport Width: 1500
 * Block Types:
 * Post Types:
 * Inserter: true
 */
?>
```

Rules:

- `Slug` is `digimia/<filename without .php>`. The file name and slug must agree.
- `Categories` must be one of the registered slugs in `functions.php`:
  `digimia/products`, `digimia/store`, `digimia/hero`, `digimia/features`, `digimia/pricing`, `digimia/testimonial`, `digimia/faq`, `digimia/call-to-action`, `digimia/card`, `digimia/pages`, `digimia/posts`, `digimia/header`, `digimia/footer`, `digimia/menu`.
- Store page starter patterns (checkout, account, …) use `Block Types: core/post-content` and `Post Types: page` so they appear in the new-page pattern picker.
- Link to EDD pages with `\Digimia\edd_page_url( '<edd option>', '/fallback/' )` and to the shop with `\Digimia\edd_archive_url()` from `inc/edd.php`.
- `Inserter: true` only when the pattern is safe to insert anywhere. Template-only patterns use `Inserter: false`.
- `Block Types` is normally empty. Do not scope patterns to a block unless there is a real reason.

## Markup rules

- Use core blocks first. Reach for a plugin block (e.g. `edd/downloads`) only when the core equivalent cannot express the design.
- Use theme tokens, not hex codes: `var:preset|color|primary`, `var:preset|spacing|medium`, `var:preset|font-size|large`, `var:custom|radius|medium`.
- Reuse existing block style variations registered in `functions.php` (`is-style-list-check`, `is-style-excerpt-truncate-2`, `is-style-accordion`, …) before writing new CSS.
- Keep block markup valid. No unclosed comments, no attributes that the block does not support.
- Prefer `<!-- wp:pattern {"slug":"digimia/..."} /-->` for composition inside templates and parts, and for large sections inside other patterns.

## Translation and images

- All user-facing strings go through `esc_html_e()`, `esc_attr_e()`, or `esc_html__()` with text domain `digimia`.
- Bundled images use `esc_url( get_template_directory_uri() . '/patterns/images/<file>' )`.
- After editing, run `yarn translate:patterns`. Review the diff: it rewrites strings and image paths, so a noisy diff means the source markup drifted from convention.

## Templates and parts

- `templates/*.html` and `parts/*.html` should stay thin. Most should be a single pattern reference or a small composition of parts.
- Do not paste a large pattern body into a template. Change the referenced pattern instead.
- Keep template slugs stable; saved Site Editor templates in the database can override file templates, so a rename can silently do nothing on an existing site.

## Verification

1. Pattern appears in the inserter under the right category.
2. Renders at ~600px and ~781px without overflow.
3. Renders in light and dark mode.
4. `yarn translate:patterns` diff is clean or only contains intended string/path changes.
5. If the pattern is used in a template, open that template in the Site Editor and confirm it resolves.

## Do not

- Do not invent a new pattern category without adding it to `register_pattern_categories()` in `functions.php`.
- Do not hardcode `http://` image URLs.
- Do not embed raw HTML `<style>` blocks inside patterns.
- Do not duplicate an existing pattern with a slightly different name; extend the existing one.

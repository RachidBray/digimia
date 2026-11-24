# Digimia AI Onboarding Guide

This guide is for AI coding assistants that need to understand, maintain, debug, or extend this project. It is project-specific and was written from the committed files, not from generic WordPress assumptions.

## What This Project Is

Digimia is a WordPress Full Site Editing block theme. It ships design tokens, style variations, templates, template parts, many file-based patterns, a small PHP setup layer, compiled front-end assets, and a couple of custom editor/front-end enhancements.

The product direction is a modern digital-products storefront: clean layout, strong typography, token-driven colors, pattern-first page building, and deep commerce integration. The theme supports both light and dark mode via a toggle, with light as the default.

Commerce is the core use case. The theme integrates Easy Digital Downloads exclusively (no WooCommerce or other store plugins). Its EDD presentation layer covers product grids and cards, single download templates, checkout, confirmation, receipt, account (with Software Licensing and Recurring Payments), and EDD Reviews; see `docs/developer/edd-integration.md`.

The flagship demo is a nameless digital-products store selling templates, UI kits, and design assets, aimed at the theme's core buyers: freelancers, small agencies, and founders who sell digital goods.

## Source Of Truth

Use these in this order when facts conflict:

1. Current code and committed configuration.
2. WordPress theme metadata in `style.css`, `theme.json`, and `readme.txt`.
3. Build and CI files: `package.json`, `webpack.config.js`, `composer.json`, `.github/workflows/`.
4. Existing developer docs in `docs/developer/`.
5. Marketing README or older AI instructions.

When a fact is inconsistent, document the inconsistency and ask for confirmation only if it blocks the change.

## The Running Site

Use WP-CLI from the WordPress root to inspect or change the local site. Confirm live facts such as the active theme, active plugins, saved Site Editor templates, pages, media, EDD downloads, and WordPress/PHP/plugin versions before relying on them. Create drafts by default.

## AI Tooling Map

| Path | Purpose |
| --- | --- |
| `AGENTS.md` | Canonical rules for every assistant. |
| `CLAUDE.md` | Claude Code's pointer file to `AGENTS.md`. |
| `.claude/skills/*/SKILL.md` | Claude Code project skills. |
| `.env.example` | Settings template for `yarn test:visual`. Copy to `.env`; never commit `.env`. |
| `.githooks/pre-commit` | Secret-scanning commit guard. Enable with `git config core.hooksPath .githooks`. |
| `docs/ai/security.md` | Secret handling policy and incident guidance. |

Skills available:

- `edd-integration` — the EDD integration ladder, block inventory, template override map, guards, and EDD verification.
- `pattern-authoring` — pattern header contract, markup rules, translation, image paths.
- `design-tokens` — exact preset/alias/radius/shadow slugs and dark-mode rules.
- `verification` — command matrix and manual checks.

## Where To Start

Start Claude Code from the theme directory, not the WordPress root, which is not a git repository. This repository is the free theme only; for Digimia Pro, see `AGENTS.md` → Digimia Pro.

## Repository Map

| Path | Purpose | Notes for AI assistants |
| --- | --- | --- |
| `theme.json` | Global settings, palettes, font sizes, spacing scale, shadows, block styles, template parts | Prefer this for design decisions before CSS/PHP. Uses schema `https://schemas.wp.org/wp/6.9/theme.json` and `"version": 3`. |
| `styles/` | Theme style variations, color variations, typography presets, button block styles | Keep schemas/version fields. Use the existing palette slugs. |
| `templates/` | Block template HTML files | Thin files that often reference patterns. Keep valid block grammar. |
| `parts/` | Header, footer, sidebar template parts | Also thin pattern references. |
| `patterns/` | The 51 free file-based PHP block patterns plus their images (CC0 photos and original illustrations, credited in `readme.txt`) | Pattern headers register title/slug/category. Strings are translated with `esc_html_e()`/`esc_attr_e()`. |
| `functions.php` | Theme bootstrap and global hooks | Loads `inc/blocks.php` and `inc/extensions/button-icon.php`; registers styles, pattern categories, block styles, dark-mode bootstrap, and sidebar part area. |
| `inc/blocks.php` | Registers custom blocks | Registers `digimia/theme-toggle` from `blocks/theme-toggle`. |
| `blocks/theme-toggle/` | Dynamic theme toggle block metadata and render callback | Front-end behavior comes from `assets/js/theme-toggle.js`. Editor JS is `assets/js/editor.js`. |
| `inc/extensions/button-icon.php` | Server-side button icon extension | Discovers SVGs, enqueues editor assets, injects icons into `core/button` on render. |
| `src/scss/` | Main Sass source | Compiles to root `style.css`. |
| `src/scss/blocks/` | Block-specific Sass source | Each `_core-*.scss` compiles to `assets/styles/*.css`; loaded through `wp_enqueue_block_style()`. |
| `src/js/` | Theme JS source | `src/js/main.js` imports the theme toggle script and compiles to `assets/js/theme-toggle.js`. |
| `src/extensions/button-icon/` | Button icon editor JS/Sass source | Compiles to `assets/js/button-icon-editor.js` and `assets/styles/button-icon-editor.css`. |
| `assets/` | Tracked compiled CSS/JS, fonts, images, icons | Do not treat as disposable. Source maps are committed. |
| `icons.mjs` | Icon set CLI (Icon block + button icons) | Uses `@phosphor-icons/core` and `svgo`. See `docs/developer/icons.md`. |
| `theme-utils.mjs` | Pattern translation/image-path CLI | Used by `yarn dev` and `yarn translate:patterns`. |
| `docs/developer/` | Feature/subsystem docs | Update when implementation behavior changes. |
| `docs/ai/security.md` | Secret handling policy | Read before touching credentials. |
| `.claude/skills/` | Project skills | Loaded by Claude Code. |
| `.env.example` | Settings template for `yarn test:visual` | Copy to `.env`; `.env` is gitignored. |
| `.githooks/pre-commit` | Secret-scanning guard | Enable with `git config core.hooksPath .githooks`. |
| `.github/workflows/` | CI/release/deploy workflows | PR WPCS excludes `patterns/`; release builds with Node 20/Yarn. |

## Source And Generated Files

Webpack entries in `webpack.config.js` generate:

- `src/scss/style.scss` -> `style.css`.
- `src/scss/blocks/_core-button.scss` -> `assets/styles/core-button.css`, and similarly for every Sass partial in `src/scss/blocks/`.
- `src/js/main.js` -> `assets/js/theme-toggle.js`.
- `src/extensions/button-icon/index.js` -> `assets/js/button-icon-editor.js`.
- `src/extensions/button-icon/editor.scss` -> `assets/styles/button-icon-editor.css`.

The generated files and source maps are committed. When changing source, rebuild and include generated output. If rebuilding is impossible, mention that in the final summary.

Caveat: `assets/js/editor.js` is registered for `digimia/theme-toggle`, but no matching `src/` source file or Webpack entry was found. Treat it as source of truth for now.

## Design System

`theme.json` is the primary design system. Confirmed default token slugs include:

- Colors: `primary`, `primary-accent`, `primary-alt`, `primary-alt-accent`, `main`, `main-accent`, `base`, `secondary`, `tertiary`, `border-light`, `border-dark`.
- Font sizes: `x-small`, `small`, `base`, `lead` (intro paragraphs, 20px), `medium`, `large`, `x-large`, `xx-large`, `xxx-large`, `xxxx-large`, `display` (one oversized headline per page).
- Spacing: `small`, `medium`, `large`, `x-large`, `xx-large`, `xxx-large`, `xxxx-large`.
- Font families: `primary` (body, Inter by default), `heading` (headings, Funnel Sans by default), and `monospace`. Typography presets redefine all three.
- Custom groups: `fontWeight`, `lineHeight`, `radius`, `semantic`, `transition`.
- Shadows: `small`, `medium`, `large`, `x-large`, `glow`, `inner`.

CSS should prefer `var(--wp--preset--*)` and `var(--wp--custom--*)` values. Existing Sass contains tactical hardcoded values for browser fixes, exact icon sizing, and editor UI; do not expand that pattern without reason.

Dark mode works by applying `data-theme="dark"` or `data-theme="light"` on `<html>`. The inline script in `functions.php` prevents flash of unstyled content, and `src/js/theme-toggle.js` persists the preference under `digimia-theme`.

## Patterns And Templates

Patterns are PHP files with WordPress pattern headers and block markup. Keep these conventions:

- Slugs use `digimia/<filename-without-extension>`.
- Categories match those registered in `functions.php`: `digimia/products`, `digimia/store`, `digimia/hero`, `digimia/features`, `digimia/pricing`, `digimia/testimonial`, `digimia/faq`, `digimia/call-to-action`, `digimia/pages`, `digimia/posts`, `digimia/header`, `digimia/footer`, `digimia/menu` (phone menu overlays only).
- User-facing strings should be translated with the `digimia` text domain.
- Pattern image URLs should use `get_template_directory_uri()` and `esc_url()`.
- After editing patterns, run `yarn translate:patterns` when the Node/Yarn toolchain is available.
- Write new buttons in the current format: width as `"style":{"dimensions":{"width":"100%"}}` and text alignment as `"style":{"typography":{"textAlign":"left"}}`. The wrapper `div` gets no width classes, because WordPress adds them at render time. The old `"width":100` attribute still validates, but when the editor upgrades it, any `"textAlign"` is lost. Older patterns that use `"width":100` without `textAlign` render the same either way, so they were left as they are.

Templates and parts usually contain only pattern references such as `<!-- wp:pattern {"slug":"digimia/template-index-grid"} /-->`. Prefer changing the referenced pattern unless the template composition itself needs to change.

## PHP Architecture

The PHP layer is intentionally small:

- `functions.php` is namespaced `Digimia` and wires global theme behavior.
- `inc/blocks.php` is namespaced `Digimia` and declares strict types.
- `inc/extensions/button-icon.php` is namespaced `Digimia\Extensions\ButtonIcon` and declares strict types.
- `blocks/theme-toggle/render.php` declares strict types and renders escaped markup.

Follow WordPress APIs, escape output, translate strings, and guard optional plugins. There is no `inc/setup.php` in the current repo despite older Copilot instructions mentioning it.

## JavaScript And Sass

Front-end JS currently uses a vanilla IIFE for theme toggling. Editor JS uses WordPress block/editor APIs for the button icon extension. The WordPress Interactivity API is not currently used.

Sass organization:

- `src/scss/style.scss` imports main partials.
- Block-specific styles live in `src/scss/blocks/` and are loaded only when the relevant block is present.
- Use explanatory comments for `!important`; several existing comments already explain admin/mobile menu constraints.

## Commands

Package manager: Yarn. This is confirmed by `yarn.lock`, `package.json`, and CI.

| Task | Command |
| --- | --- |
| Install JS dependencies | `yarn install --frozen-lockfile` |
| Watch Sass/JS and pattern processing | `yarn dev` |
| Production build | `yarn build` |
| Development build | `yarn build:dev` |
| Process pattern translations/image paths | `yarn translate:patterns` |
| Search icons | `yarn icons:search <term>` |
| Add icons | `yarn icons:add <name...>` |
| List icons | `yarn icons:list` |
| Remove icons | `yarn icons:remove <name...>` |
| Optimize icons | `yarn icons:optimize` |
| PHP syntax lint | `composer run lint` |
| WPCS scan | `composer run wpcs:scan` |
| WPCS autofix | `composer run wpcs:fix` |

No Composer lockfile, PHPUnit config, JS test runner config, ESLint config, Stylelint config, or Prettier config was found.

Local environment note: `node` v22.15.0, `yarn` 4.14.1, `php` 8.4.6, and `composer` 2.8.8 are all on `PATH`. `node_modules/` is installed. Run `composer install` once for the PHP lint/WPCS tools (`phpcs.xml.dist` holds the rules). Older audits claimed the toolchain was missing; that note is resolved.

## CI And Release Behavior

- Every push to `main` and every pull request runs `.github/workflows/wpcs.yml`: `composer run lint`, `composer run wpcs:scan` (the `phpcs.xml.dist` rules, which exclude `patterns/`), and the release checklist's PHP 7.4 compatibility check.
- Pushing a version tag (`v1.0.0`) runs `.github/workflows/create-release.yml`: it checks the tag matches `Version` in `style.css`, takes that version's changelog entry from `readme.txt`, zips the theme with `git archive` (as `yarn dist` does), and publishes a GitHub release. Pushes to `main` publish nothing.

## Known Unknowns And Conflicts

- Supported versions are settled: WordPress 7.1 or later and PHP 7.4 or later (see `AGENTS.md`). `composer.json`'s `php` constraint only covers the development tools.
- The older Copilot file claimed WordPress 6.6+/PHP 8.1+ and `inc/setup.php`; those were not confirmed in the repo.
- Digimia is confirmed as EDD-first, and EDD Pro 3.7.3 is active on the development site, with the extensions listed in `AGENTS.md`. The theme has a presentation-only EDD layer (see `docs/developer/edd-integration.md`); checkout, receipt, and account block styling is the next step. See `AGENTS.md` → Current Focus.

# Digimia AI Task Playbooks

Use these playbooks to keep future AI work consistent with the actual repository.

## Before Any Change

1. Read `AGENTS.md`, `docs/ai/README.md`, and `docs/ai/security.md`.
2. Identify the source-of-truth file for the task: `theme.json`, pattern, Sass source, JS source, PHP module, or tracked generated asset.
3. Check for existing docs under `docs/developer/`.
4. Load the matching skill from `.claude/skills/` (`edd-integration`, `pattern-authoring`, `design-tokens`, `verification`).
5. Check `git status --short` and `git diff --cached` for unrelated user changes and for secrets before staging anything.
6. Decide the smallest useful verification command before editing.

## New Feature

1. Prefer core blocks, `theme.json`, style variations, and patterns before adding PHP or JS.
2. If PHP is required, place it near the existing ownership boundary:
   - Global theme wiring: `functions.php` only when it is small bootstrap-level behavior.
   - Blocks: `blocks/<name>/` plus registration in `inc/blocks.php`.
   - Extensions: `inc/extensions/<feature>.php` and matching `src/extensions/<feature>/` if editor assets are needed.
3. If JS/Sass is required, add or extend source under `src/` and update `webpack.config.js` only if a new entry is needed.
4. Add or update docs in `docs/developer/<feature>.md`.
5. Rebuild and include generated assets if source assets changed.

## Bug Fix

1. Reproduce or locate the bug in code before editing.
2. Prefer a targeted fix over broad cleanup.
3. Check whether the bug exists in source, generated output, or both.
4. For UI bugs, verify light/dark mode, admin bar offset, mobile menu behavior, and widths around 600px and 781px.
5. Update docs only if behavior, setup, or developer-facing usage changes.

## Refactor

1. Keep public behavior and block markup stable unless the task says otherwise.
2. Preserve pattern slugs, block names, style variation slugs, CSS class names, and text domain values.
3. Avoid moving files unless the new location matches an existing convention.
4. Rebuild after source moves or imports change.
5. Call out any residual risk where WordPress editor serialization or saved block markup could be affected.

## Pattern Work

1. Start from an existing pattern with the closest category and layout.
2. Keep the pattern header complete: title, slug, description, categories, keywords, viewport width, and inserter status where relevant.
3. Use existing token classes and inline `var(--wp--preset--*)` values rather than new hardcoded styling.
4. Translate text with `esc_html_e()` or `esc_attr_e()` using the `digimia` text domain.
5. Use `esc_url( get_template_directory_uri() )` for bundled pattern images.
6. Run `yarn translate:patterns` if available.

## EDD Integration

Load the `edd-integration` skill first.

1. Decide the owner first: display-only changes (layout, labels, styling) stay in the theme; anything that changes stored data, grants access, or must survive a theme switch belongs in a plugin, not the theme.
2. Work the integration ladder in order: `theme.json` block styles → block Sass → patterns → filters/hooks → `edd_templates/` overrides last.
3. Prefer EDD's block suite (`edd/downloads`, `edd/buy-button`, `edd/cart`, `edd/checkout`, `edd/receipt`, `edd/user-downloads`, `edd/order-history`, `edd/login`, `edd/register`, `edd/profile-editor`, `edd/terms`, `edd/confirmation`, `edd/currency-selector`) over hand-built forms.
4. Guard every EDD API call with `function_exists()`/`class_exists()`.
5. Read but never edit `wp-content/plugins/easy-digital-downloads-pro/`.
6. Handle variable pricing and sale prices explicitly; do not assume a single price.
7. Create `docs/developer/edd-integration.md` for the first implementation and update it for every behavior change, including a list of any `edd_templates/` overrides and why each was necessary.
8. Verify against the EDD checklist in the `verification` skill.

## Security Review

1. Inspect the staged diff for credentials before anything else.
2. Confirm `.env` and `.claude/settings.local.json` are ignored: `git check-ignore -v .env .claude/settings.local.json`.
3. If a secret is found, stop, report it, and follow `docs/ai/security.md` (revoke → rotate → purge history).

## Live WordPress Content Work

1. Use WP-CLI from the WordPress root to confirm the site URL, active theme, active plugins, and target content type.
2. List existing posts/pages/products/downloads before creating new content to avoid duplicates.
3. Create drafts by default. Publish only when the user explicitly asks.
4. Read the created or updated item back and verify title, slug, status, and block content.
5. Use Browser/Playwright for visual QA when the change affects layout or theme rendering.

## Theme JSON And Style Variations

1. Keep `"version": 3` and the existing schema style.
2. Reuse existing slugs when changing palette, typography, spacing, shadow, or button style behavior.
3. Add new slugs only when an existing token cannot express the design.
4. Check style variations in `styles/` for compatibility with changed token meanings.
5. Avoid manually duplicating global token values in Sass.

## Sass And CSS

1. Edit `src/scss/` first.
2. Add block-specific CSS as `src/scss/blocks/_<block-name>.scss`; Webpack generates `assets/styles/<block-name>.css`.
3. Keep broad/base styles in the existing main partials imported by `src/scss/style.scss`.
4. Use token variables where possible.
5. Explain any new `!important` with a short comment.
6. Run `yarn build` or `yarn build:dev`.

## JavaScript

1. Use WordPress packages for editor behavior and vanilla JS for small front-end behavior, matching current code.
2. Avoid jQuery unless a plugin integration makes it unavoidable.
3. Keep user-facing strings translated with `@wordpress/i18n` where editor JS is involved.
4. Remember that `assets/js/editor.js` currently has no discovered `src/` source; edit carefully or create a proper source path and build entry as part of the change.
5. Run `yarn build` or `yarn build:dev`.

## PHP

1. Use namespaces consistent with the target module.
2. Use WordPress APIs for theme paths, URLs, scripts, styles, block registration, hooks, escaping, and translation.
3. Escape output at render time.
4. Guard optional integrations with `function_exists()` or `class_exists()`.
5. Do not directly query the database unless there is no suitable WordPress API and the task explicitly requires it.
6. Run PHP lint/WPCS when available.

## Code Review

Prioritize findings over summary. Look for:

- Regressions in saved block markup or front-end rendering.
- Missing escaping, translation, capability checks, nonces, or plugin guards.
- Source/generated asset drift.
- Pattern translation/image-path mistakes.
- Accessibility regressions: missing labels, keyboard traps, focus visibility, reduced-motion issues.
- Mobile/admin-bar/dark-mode regressions.
- Commands or docs that no longer match the code.

If no issues are found, say so and mention any verification you could not perform.

## Final Response Checklist

When finishing AI work, report:

- Files created or updated.
- Why those files changed.
- Verification run and results.
- Anything not verified because tools or environment were unavailable.
- Any owner confirmations still needed.

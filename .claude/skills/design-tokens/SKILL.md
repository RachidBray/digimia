---
name: design-tokens
description: Use when writing CSS, Sass, theme.json block styles, or pattern markup for Digimia and you need the correct preset slugs, semantic aliases, radius values, dark-mode behavior, or shadow names. Prevents inventing new tokens or hardcoding colors.
license: GPL-2.0-or-later
metadata:
  audience: developers
  domain: design-system
---

## What I do

Give the exact token names this theme ships, and the decision rule for which layer to use.

## When to use me

Use before adding any color, spacing, radius, shadow, font size, or transition in CSS, Sass, `theme.json`, or pattern/block markup.

## Layers, in priority order

1. **Semantic aliases** (`var(--wp--custom--semantic--*)`) — use these for UI surfaces, text, borders, and forms. They already handle dark mode.
2. **Preset palettes/spacing/typography** (`var(--wp--preset--*)`) — use for brand and layout decisions where semantics do not apply.
3. **Custom groups** (`var(--wp--custom--radius--*, --wp--custom--lineHeight--*, --wp--custom--fontWeight--*, --wp--custom--transition)`) — use for shape, rhythm, weight, motion.
4. **Hardcoded values** — only for browser fixes, exact icon geometry, or editor chrome, and only with a comment explaining why.

Never add a new `:root` custom property.

## Colors (preset slugs)

`primary`, `primary-accent`, `primary-alt`, `primary-alt-accent`, `main`, `main-accent`, `base`, `secondary`, `tertiary`, `border-light`, `border-dark`.

In JSON: `var:preset|color|primary`. In CSS: `var(--wp--preset--color--primary)`.

## Semantic aliases (preferred for components)

| Alias | Resolves to |
| --- | --- |
| `text-primary` | `main` |
| `text-secondary` | `main-accent` |
| `text-tertiary` | `secondary` |
| `surface-0` | `base` |
| `surface-1` | `tertiary` |
| `surface-2` | `border-light` |
| `surface-3` | `border-dark` |
| `border` | `border-light` |
| `border-hover` | `border-dark` |
| `brand` | `primary` |
| `brand-hover` | `primary-accent` |
| `brand-muted` | translucent `primary` (`color-mix`, 10% light / 14% dark) |
| `focus-ring` | solid `primary`; `base` in Brand sections, `main` in Accent sections and accent cards |
| `brand-button` / `brand-button-text` | button fill and label in Brand sections: `primary-alt` / `main` in the light palette, `base` / `main` in the dark |
| `on-accent` | text on `primary-alt` (Brand alt): `main` in the light palette, `base` in the dark |
| `marker` / `marker-text` | marked words in headings: a `primary-alt` band / the text color in the light palette; no band / `primary` in the dark palette; no band / `brand-button` in Brand sections |
| `error` / `success` / `warning` / `info` | status hues (red, green, amber, blue), lighter in the dark palette. Use for tints, borders, and icons (`color-mix` with `surface-0`); keep text `text-primary`. Alerts: `.edd-alert` in `_edd-elements.scss` |
| `input-bg` | `surface-1` |
| `input-border` | `border` |
| `input-text` | `text-primary` |
| `input-placeholder` | `text-tertiary` |

## Spacing

`small`, `medium`, `large`, `x-large`, `xx-large`, `xxx-large`, `xxxx-large`.

CSS: `var(--wp--preset--spacing--medium)`. JSON: `var:preset|spacing|medium`.

## Font sizes

`x-small`, `small`, `base`, `lead`, `medium`, `large`, `x-large`, `xx-large`, `xxx-large`, `xxxx-large`, `display`.

`display` (7rem, 3.5rem on phones) is for one oversized headline per page; `.has-display-font-size` also sets weight 700, line height 0.95, and tighter tracking.

Font families: `primary` (body text, Inter by default), `heading` (headings and display-size paragraphs, Funnel Sans by default), `monospace`. Typography presets redefine all three, so use the slug, never a font name.

## Radius (note the short slugs)

`sm` (6px), `base` (8px), `lg` (12px), `xl` (20px, filled feature and stat cards), `full` (9999px).

CSS: `var(--wp--custom--radius--base)`. There is **no** `--radius--medium` or `--radius--large`.

## Shadows

`small`, `medium`, `large`, `x-large`, `glow`, `inner` → `var(--wp--shadow--small)` etc.

## Other custom groups

- `fontWeight` — see `theme.json` for named weights.
- `lineHeight` — see `theme.json`.
- `transition` — `var(--wp--custom--transition)` for the standard easing/duration.

## Dark mode

- Applied via `data-theme="dark"` on `<html>`, defaulting to `light`.
- The dark palette is `settings.custom.color.dark` in `theme.json`; each color preset in `styles/colors/` defines its own. `src/scss/_variables.scss` maps the presets to it on `[data-theme=dark] body` and in Contrast sections (see `docs/ai/design-system.md` §3a).
- Do not write parallel dark-mode rules for colors already covered by presets/semantics, and do not hardcode dark hex values in Sass. A new palette-dependent value goes in the `palette-light` / `palette-dark` mixins.
- `style.css` is generated. Edit `src/scss/**` and run `yarn build`.

## Block-level styling

- Prefer `theme.json` → `styles.blocks["core/..."]` or `styles.blocks["edd/..."]` for block defaults.
- For CSS that must ship only when a block is present, add `src/scss/blocks/_core-<block>.scss` (or `_edd-<block>.scss` if wiring allows). Each compiles to `assets/styles/<name>.css` and is enqueued per block by `functions.php`.
- Block style variations (e.g. `is-style-list-check`) are registered in `functions.php`; reuse them before creating a new variation.

## Do not

- Do not use raw hex values in patterns or new Sass.
- Do not invent slugs. If a token is genuinely missing, propose it in `theme.json` and update `docs/ai/README.md`'s token list in the same change.
- Do not use `!important` to override tokens; fix specificity at the block wrapper.

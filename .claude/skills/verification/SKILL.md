---
name: verification
description: Use before finishing any change in the Digimia repo to pick and run the right checks — PHP lint/WPCS, Sass/JS build, pattern translation, and the manual WordPress checks for light/dark mode, mobile widths, and EDD pages. Includes known environment caveats.
license: GPL-2.0-or-later
metadata:
  audience: developers
  workflow: verification
---

## What I do

Map a change type to the narrowest useful verification and report honestly when a check could not run.

## When to use me

Use at the end of any task, and before claiming a change is complete.

## Environment facts (verified)

- `node` v22.15.0, `yarn` 4.14.1, `php` 8.4.6, `composer` 2.8.8 are all on `PATH`.
- `node_modules/` is present.
- `vendor/` (Composer) is installed from `composer.lock`; on a fresh clone run `composer install`. Rules: `phpcs.xml.dist`. The WPCS scan is clean, so any new report comes from your change.
- There are no unit, integration, JS, or browser tests. Verification is build + manual.

## Command matrix

| Change type | Commands |
| --- | --- |
| Sass / JS / icons | `yarn build` (production) or `yarn build:dev` |
| Patterns (only) | `yarn translate:patterns`, then review `git diff patterns/` |
| PHP | `composer install` once, then `composer run lint` and `composer run wpcs:scan` |
| `theme.json` | No build. Validate JSON parses; open Site Editor and confirm styles apply |
| Docs / config only | Validate JSON/YAML parses; `bash -n` any shell script |
| Store pages, EDD or extension updates | `yarn test:visual` (baseline first with `--update-baseline` before an update); open each listed `.diff.png`. See `docs/developer/visual-regression.md` |

`yarn build` runs `icons:optimize` first, so it touches `assets/icons/`. A clean run should not change generated assets unexpectedly.

## Manual checks (always, for UI work)

1. Logged in **and** logged out.
2. Admin bar visible **and** hidden.
3. Light **and** dark mode (`data-theme` on `<html>`).
4. Widths around **600px** and **781px** — the theme's bootstrap-style breakpoints.
5. Mobile menu open/closed.
6. Reduced motion: `prefers-reduced-motion: reduce` must not break layout.

## EDD-specific checks

When the change touches commerce:

1. A download single page with a **single price**.
2. A download with **variable pricing**.
3. A download with a **sale price**.
4. `/cart` and `/checkout` while logged out.
5. Purchase confirmation and receipt pages.
6. Account pages while logged in: order history, downloads, profile.
7. `Downloads → Tools → Debug Log` is clean.

## Reporting

State exactly:

- Which commands ran and their result.
- Which checks were manual vs automated.
- What could not be verified and why (e.g. "no live EDD products exist yet").
- Any generated files that were or were not refreshed.

Never claim "verified" for a check you did not run.

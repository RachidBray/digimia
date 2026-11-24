# Icons

Digimia ships one icon set, used in two places:

- **The core Icon block** (`core/icon`, WordPress 7.1+). The set is registered as the **Digimia** collection, so it appears in the block's own icon picker next to the WordPress icons. Patterns use it as `"icon":"digimia/<slug>"`.
- **Button icons**, the theme's extension for `core/button` ([button-icon-extension.md](button-icon-extension.md)). Its picker lists the same icons.

## Source and license

[Phosphor Icons](https://phosphoricons.com/), regular weight, from the `@phosphor-icons/core` package (MIT). The license text ships in `assets/icons/LICENSE`, and `readme.txt` credits it.

Why Phosphor: the core Icon block sanitizes icon SVG down to `<path>` and `<polygon>` with fill attributes, and colors icons with `fill: currentColor`. Stroke-based sets (Lucide, Tabler, Heroicons outline) lose their strokes and render as solid shapes or nothing. Phosphor draws every icon, including the outline-style regular weight, as one filled path, so it renders correctly in the Icon block, in buttons, and in both color modes.

## Files

| File | Purpose |
|---|---|
| `assets/icons/*.svg` | The icon set (97 icons, `viewBox="0 0 256 256"`, one filled path each) |
| `assets/icons/LICENSE` | Phosphor's MIT license |
| `inc/icons.php` | `icon_set()` (slug → translated label), `icon_path()`, and the Icon block collection registration |
| `inc/extensions/button-icon.php` | Reads `icon_set()` for the button picker and front-end injection |
| `icons.mjs` | CLI for adding, searching, optimizing, listing, and removing icons |

## Adding or removing an icon

```bash
yarn icons:search cart        # Search the Phosphor library
yarn icons:add shopping-bag   # Copy into assets/icons/ and optimize with SVGO
yarn icons:remove shopping-bag
```

Then add (or remove) its entry in `icon_set()` in `inc/icons.php`. The label is what users see in both pickers, so write it for them ("License key", not "key"). An icon without a label is not registered.

`yarn build` runs `icons:optimize` first. SVGO keeps the `viewBox` and the filled path and sets `fill="currentColor"`.

Keep the set curated: icons a digital-goods store needs, in one style. Do not mix in icons from another library.

Brand icons (Slack, Notion, Stripe, GitHub, Figma, …) are Phosphor's own drawings, so they share the set's style and license. They name real products as integration examples in patterns (`feature-integrations`); they are not endorsements, and buyers replace them with their own integrations.

## Theme switch

The Icon block saves only the icon name and renders it at view time. If Digimia is deactivated, `digimia/*` icons render nothing (core icons keep working). Digimia Pro is optional, so the collection stays in the theme; registering it in a plugin is what would let icons survive a theme switch.

## Tooling note

Use Yarn 1 for this project (`yarn.lock` is a v1 lockfile). If `yarn --version` prints 4.x (Corepack), run commands through Yarn 1, for example `npx -p yarn@1.22.22 -c 'yarn build'`. Yarn 4 rewrites the lockfile, switches to Plug'n'Play, and removes `node_modules`.

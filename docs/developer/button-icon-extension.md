# Button Icon Extension

Adds SVG icon support to the core/button block without creating a custom block. Content editors pick from a visual grid in the sidebar, and the icon renders on the front end via server-side injection (zero front-end JS).

## Architecture

```
Editor (JS)                          Front End (PHP)
┌──────────────────────┐             ┌──────────────────────┐
│ blocks.registerBlock  │             │ render_block filter   │
│  → custom attributes  │             │  → reads attributes   │
│                       │             │  → injects SVG into   │
│ editor.BlockEdit      │             │    <a> inside button  │
│  → InspectorControls  │             │  → adds .has-icon     │
│    (icon picker,      │             │    CSS classes        │
│     position, size)   │             └──────────────────────┘
│                       │
│ editor.BlockListBlock │             Icon Registry (PHP)
│  → wrapperProps with  │             ┌──────────────────────┐
│    CSS custom props   │             │ Reads icon_set()      │
│  → mask-image preview │◄────────────│ inc/icons.php set     │
└──────────────────────┘             │ Sanitizes via wp_kses │
                                     │ Caches per-request    │
                                     └──────────────────────┘
```

### Why this approach?

| Decision | Reason |
|----------|--------|
| Block extension, not a new block | Preserves all core/button features (colors, styles, link settings) |
| Server-side SVG injection | Zero front-end JS — icon is baked into HTML at render time |
| CSS mask-image for editor preview | Works inside WP 6.6+ iframe-based editor canvas |
| Shared icon set | Same icons as the core Icon block (see [icons.md](icons.md)) |
| wp_kses sanitization | Strips anything dangerous from SVGs |
| Static cache in PHP | Filesystem scanned once per request |

## Files Involved

| File | Purpose |
|------|---------|
| `inc/extensions/button-icon.php` | Icon registry, editor asset enqueuing, `render_block` server-side injection |
| `src/extensions/button-icon/index.js` | Editor UI — attribute registration, InspectorControls picker, CSS mask preview |
| `src/extensions/button-icon/editor.scss` | Editor-only styles — icon picker grid + mask-image preview |
| `src/scss/blocks/_core-button.scss` | Front-end icon alignment (flexbox, gap, sizing via CSS custom property) |
| `inc/icons.php`, `assets/icons/*.svg` | The shared Digimia icon set ([icons.md](icons.md)) |
| `icons.mjs` | CLI tool — add, search, optimize, list, remove icons |
| `functions.php` | Loads the extension via `require_once` |
| `webpack.config.js` | Compiles the JS (Babel/JSX) and editor SCSS |

## How to Use (Content Editors)

1. Add a **Button** block in the editor
2. Open the sidebar → **Button Icon** panel
3. Pick an icon from the visual grid (or ✕ to remove)
4. Set **position**: Left, Right, or **Icon Only** (text becomes an accessible `aria-label`)
5. Publish — the icon renders inline with the button text

The icon has no size setting of its own. It is 1.25× the button's font size, so changing the button's font size resizes both, and an icon never makes a button taller than a plain one. Icon-only buttons are squares as tall as text buttons.

## Icon Management (Developers)

Buttons use the shared Digimia icon set. Adding, removing, and the rules for icon files are in [icons.md](icons.md).

## Block Attributes

These attributes are added to `core/button` via the `blocks.registerBlockType` filter:

| Attribute | Type | Default | Description |
|-----------|------|---------|-------------|
| `digimiaIcon` | `string` | `''` | Icon slug from `icon_set()` (filename without `.svg`) |
| `digimiaIconPosition` | `string` | `'left'` | `'left'`, `'right'`, or `'only'` (icon only) |

## CSS Classes & Custom Properties

### Front end (added by `render_block`)

| Selector | Purpose |
|----------|---------|
| `.wp-block-button__link.has-icon` | Enables `inline-flex` + `gap` layout |
| `.wp-block-button__link.icon-position-{left\|right}` | Position indicator (PHP injects icon in correct DOM order) |
| `.wp-block-button__link.is-icon-only` | Icon-only mode — square (`2 × --wp--custom--button--padding-block + 1lh`), text visually hidden |
| `.wp-block-button__icon` | Icon wrapper `<span>`; its SVG is `1.25em` with `-0.125em` block margins, so its layout height is 1em |

### Editor (added by `editor.BlockListBlock` filter)

| Selector / Property | Purpose |
|---------------------|---------|
| `.has-digimia-icon` | Enables `::before` pseudo-element icon |
| `.icon-pos-{left\|right}` | Controls `::before` order via `order: 999` |
| `.is-icon-only` | Icon-only mode — same square as the front end; the label stays editable but invisible (`-webkit-text-fill-color: transparent`) |
| `--digimia-icon-svg` | Data URI for `mask-image` (the SVG keeps `viewBox` in that exact case; XML is case-sensitive) |

## Hooks & Filters

### PHP

| Hook | Type | Callback | Description |
|------|------|----------|-------------|
| `enqueue_block_editor_assets` | Action | `enqueue_editor_assets()` | Loads editor JS/CSS + localizes icon data |
| `render_block` | Filter | `render_button_with_icon()` | Injects SVG into `core/button` HTML on front end |

### JavaScript

| Filter | Namespace | Description |
|--------|-----------|-------------|
| `blocks.registerBlockType` | `digimia/button-icon-attributes` | Adds custom attributes to `core/button` |
| `editor.BlockEdit` | `digimia/button-icon-controls` | Adds InspectorControls sidebar panel |
| `editor.BlockListBlock` | `digimia/button-icon-preview` | Adds CSS custom properties for mask-image preview |

## Dependencies

- **WordPress:** Works with the theme's supported WordPress baseline; WP 6.6+ is recommended for iframe-based editor style behavior.
- **PHP:** 7.4 or later, the theme's baseline; the extension code uses no newer syntax.
- **Node (dev):** `svgo` (SVG optimization), `@phosphor-icons/core` (icon source), `babel-loader` + `@babel/preset-react` (JSX compilation)

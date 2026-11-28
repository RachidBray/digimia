# Digimia pattern design system (approved 2026-10-30)

This is the rulebook every pattern follows. The consistency pass applies it one category at a time; new patterns follow it from the start.

Every value is an existing token from `theme.json`. Nothing new goes in `:root`. The only new things are block styles (sections, eyebrow), registered the same way as `styles/blocks/button/*.json`.

## Measured today (non-template, non-menu patterns)

| Area | Today | Problem |
|---|---|---|
| Section padding | 10 different top/bottom combinations: `xx-large` ×26, `xxxx-large` ×17, `large` ×13, `0` ×7, … | No shared rhythm: the store patterns feel twice as airy as the rest. |
| Section H2 | 7 sizes, 4 of them hand-written `clamp()` values (in my store patterns) | Ignores the type scale and style variations. |
| Radius | `5px` hardcoded ×61, plus `100px` and `500px` | Not tokens. Matches neither `sm` (6px) nor `base` (8px). |
| Colors | 12 patterns with hex codes (`#E3E3F0`, `#14111f`, `#4d34fa`, …) | Breaks dark mode and the 7 color variations. |
| Surfaces | `backgroundColor` + `textColor` set by hand on each section | The user cannot switch a section between light, contrast, and brand. |
| Eyebrow labels | Inline styles copied into every pattern | Cannot be restyled globally. |

## 1. Section rhythm

Every top-level section is a full-width group: `align: full`, constrained layout, margin `0`.

| Section size | Top / bottom padding | Used for |
|---|---|---|
| **Default** | `xx-large` / `xx-large` | Almost everything: features, pricing, reviews, FAQ, product grids |
| **Spacious** | `xxx-large` / `xxx-large` | Heroes and closing calls to action, at most 2 per page |
| **Compact** | `large` / `large` | Logo rows, stats strips, banners inside a page |
| **Flush** | `0` | Covers and announcement bars, which carry their own height |

- Side padding is always `medium`, which matches the global root padding.
- Gap from the section header to the content: `x-large`. Inside the header (H2, intro): `small`. Grid and column gap: `large` (2rem). Gap inside a card: `medium`.
- Content width: section headers `contentSize` (720px); grids and columns `align: wide` (1200px).

## 2. Typography

| Role | Token | Notes |
|---|---|---|
| Hero H1 | `xxx-large` (3.75rem → 2.5rem) | One per page. Most home heroes use `xxxx-large` (below) |
| Section H2 | `x-large` (3rem → 2.125rem) | Replaces every custom `clamp()` |
| Card / step H3 | `medium` (1.25rem) | |
| Lead / intro | `lead` (18px, 17px on phones), color `main-accent` | Max 2 sentences. The paragraph under every hero and section heading |
| Body | `base` | |
| Meta, captions | `small`, color `secondary` | |
| **Eyebrow** | new paragraph style `is-style-eyebrow`: `x-small`, 600, uppercase, `0.12em` tracking, color `primary` | One registered style instead of inline styles. Not above headings; it stays for card metadata, calendar day labels, and mockups (§4i-0) |

Heading weight, line height, and tracking come from `theme.json` elements, so patterns set only the size. H1 and H2 use `text-wrap: balance` (`_reset.scss`), so a heading splits into even lines and never leaves its last word alone. Every hero and page-header H1 is `xxx-large`, except the home heroes, where a short headline is the message: the SaaS glow, store (`hero-editorial-collection`), plugin, and book launch heroes at `xxxx-large`, and the fitness hero at `display` (the course hero, led by its photo, stays `xxx-large`). The store and plugin heroes moved up on 2026-11-27 because 60px looked small beside their cards, and `xxxx-large` went from 76px to 70px on 2026-11-28 because 76px felt too large. In a split hero, widen the text column rather than set the headline smaller or let it run to four lines: the store hero is split 53/47 and the plugin hero 56/44, so their headlines keep two or three lines from 1024px up. A headline that still runs long is shortened (the plugin hero: "Better WordPress sites, built faster.").

The scale follows exbit.webflow.io (2026-11-09): hero 60px, section titles 48px (raised from 42px on 2026-11-14: the reference sites use 48–64px, and 48px keeps Optimize's 1.25 ratio to the hero while most headings stay on one or two lines; 64px wrapped nearly every heading and outranked the hero), `large` 32px, card titles 20px, lead 18px, buttons 18px medium with 14px × 28px padding. `xx-large` (3.25rem) is for stat numbers and statements, `xxxx-large` (4.375rem, 70px) for an oversized display line, and `display` (7rem → 3.5rem, added 2026-11-12) for a hero whose headline is the whole message, such as the fitness hero. `display` is not fluid in `theme.json`: its own `clamp(3.5rem, 0.25rem + 8.2vw, 7rem)` grows with a half-width column, so "Stronger every week." stays on two lines from 782px up, where WordPress's fluid curve broke it into three. `.has-display-font-size` (`_helpers.scss`) sets it at weight 700, line height 0.95, and `-0.04em` tracking, so the large type stays one tight shape.

Fonts: by default headings use Funnel Sans (`heading`) and body text uses Inter (`primary`), both OFL and bundled in `assets/fonts/`. Paragraphs at `x-large` and up (stat numbers, statements) also take the heading font and a 1.3 line height (`_helpers.scss`). The reading sizes `x-small` (13px), `small` (14px), and `base` (16px) are not fluid, so text never shrinks on a phone; sizes from `lead` up still scale.

Font files are split by script, the way Google Fonts serves them: every face has a `unicodeRange`, and the browser downloads only the files whose characters are on the page. Each font has a Latin file and a Latin Extended file (which also covers Vietnamese). Inter adds Cyrillic, Greek, and a symbols file with the arrows, shapes, stars, and checks that patterns use (`→`, `★`, `✓`). Inter's Latin file carries those symbols too, so an English page on Default loads one 77 KB Inter file instead of the old 343 KB.

The other body fonts lack Cyrillic, Greek, and those symbols, so each preset adds Inter's three fallback files to its body family. They must copy that family's `fontWeight` and `fontStretch`. WordPress renames every face to its family's name, and faces with different descriptors count as a separate font: the browser uses one set and drops the other. Editorial body text fell back to Georgia until they matched. Heading stacks list the body family second to reach the same fallbacks.

The files are built from the Google Fonts sources with fontTools `pyftsubset`. They keep the layout features a browser applies by default (kerning, ligatures, marks, contextual alternates, fractions) plus `tnum`; opt-in alternates (`cv*`, `ss*`, `case`, small caps, oldstyle figures) are dropped, since no pattern turns them on. That took Inter's Latin file from 109 KB to 77 KB and Literata's files down by about 30% (2026-11-16). Every trimmed file was checked by rendering all its characters at several weights and sizes beside the original: the pixels match. Funnel Sans and Space Grotesk stay as Google Fonts ships them: trimmed, they rendered a little differently, for 2 KB and 10 KB. Fraunces is fixed at its default SOFT 0 and WONK 1, and Literata is limited to optical sizes 12 to 24, since it only sets text. Avoid fonts with a Reserved Font Name (IBM Plex, Mona Sans): a subset is a modified version and could not keep the name.

Arabic (2026-11-17): every preset adds one Arabic font to its body and heading families, as one more script file with the Arabic `unicodeRange`, so a page downloads it only when it shows Arabic letters, and English words in Arabic text keep the preset's Latin font. Default uses Vazirmatn (45 KB), Editorial and Print use Markazi Text (40 KB), Technical uses Readex Pro (22 KB), and Bold uses Alexandria (30 KB); the user chose them from a comparison of three candidates per preset. They are Google Fonts' Arabic files as served (Arabic needs its joining and mark features, so they are not trimmed). Like Inter's fallback files, each Arabic face copies its family's `fontWeight`, `fontStretch`, and `fontStyle`, one face per combination (an italic family gets an italic Arabic face, which draws upright: Arabic has no italics); with its own weight range the browser split the family and fell back to system fonts. Markazi draws small beside Latin text, so its faces have `sizeAdjust: 115%`. Readex Pro's license reserves the name "RevReading Lexend", not "Readex Pro", so the subset keeps its name. In Styles › Typography a family lists each script file as a separate, identical-looking variant (Inter shows five "Inter 100 900" rows); unticking one removes that script.

Typography presets (`styles/typography/`) change the body font as well as the headings, because body text is over 90% of the characters on a page; a heading-only swap barely shows. Each preset lists all three families (`primary`, `heading`, `monospace`) so applying one never drops a theme font. A preset may also restyle the Eyebrow paragraph style through `styles.blocks.core/paragraph.variations.eyebrow`.

| Preset | Headings | Body | Eyebrow | Weight | `h1`/`h2` tracking |
| --- | --- | --- | --- | --- | --- |
| Default | Funnel Sans | Inter | Inter caps | 600 | -0.025em |
| Editorial | Fraunces | Literata, with italics | Literata italic, sentence case | 500 | -0.02em |
| Technical | Space Grotesk | Sora | JetBrains Mono caps; also the `monospace` font | 600 | -0.035em |
| Bold | Archivo Expanded | Archivo | heading font caps | 800 | -0.02em |
| Print | Montagu Slab | Schibsted Grotesk | body font caps | 500 | -0.03em |

Archivo Expanded is the Archivo files with `fontStretch: 115%`. At 125%, the SaaS hero headline broke into four lines on a phone. Geometric (DM Sans) was dropped on 2026-11-13 because next to Funnel Sans it looked the same.

Site styles (`styles/*.json`) pair one color preset with one typography preset, copied verbatim: Atelier (Oxblood + Editorial), Poster (Ink + Bold), Studio (Violet + Print), Blueprint (Cobalt + Technical). When a color or typography preset changes, update the site style that uses it.

## 3. Surfaces: section styles

Section styles are registered as theme.json block style variations in `styles/sections/*.json`, the same mechanism as the button styles. They apply to `core/group`, `core/columns`, and `core/column`.

| Style | Background → text | Links, buttons, borders inside |
|---|---|---|
| **Default** (none) | `base` → `main` | theme defaults |
| **Soft** `section-soft` | `tertiary` → `main` | defaults |
| **Contrast** `section-contrast` | `main` → `base` | light buttons, `border-dark` borders |
| **Brand** `section-brand` | `primary` → `base` | accent buttons (`brand-button`: `primary-alt` in light mode, `base` in dark mode, where the section itself is the light brand color) |
| **Accent** `section-accent` | `primary-alt` → `main`, in both modes | the light palette applies inside, so it stays the accent color with dark ink in dark mode too; tiles (`tertiary`) are a lighter wash of the accent and marked words take a `base` band. Default and outline buttons; not Brand alt (it would vanish) |

- Contrast stays correct in both modes because the presets swap.
- A user can switch any section between surfaces from the block sidebar. That is the standard answer to "a light pattern can be used in a dark theme".
- There are no "… contrast" copies of patterns (removed 2026-11-02): a pattern is one layout, and users pick its surface with the section style.
- Patterns stop setting `backgroundColor` / `textColor` on sections.
- Bordered cards (`border-light` border, no background of their own) on a Soft section take the `base` background (`_components.scss`), because the border alone barely shows on Soft.
- Header and footer patterns use Soft, so the header blends into a Soft hero and the page is framed top and bottom. The header has no divider border; the footer template part has a 1px top line of three parts `border` to one part `border-hover` (a `color-mix`), light enough not to read as a heavy rule, strong enough to show in dark mode (`_components.scss`), so it stays separate from a Soft closing section.

## 3a. Color palettes and dark mode

The default palette (2026-11-03) is deep teal, lime, and white, after exbit.webflow.io: white page, grey-green Soft surface, lime on large areas (accent buttons, tinted cards, stat cards). Color presets in `styles/colors/`: Oxblood (red-brown, apricot), Ink (near-black, vermilion), Violet (violet, rose), Cobalt (blue, tangerine), Pine (green-black, sand, cream; after sasico.pikathemes.site/digital-agency). Each is a different hue family from the default, so presets never look like near-copies. Pine is the exception that shares the default's green family; it differs by mood instead: monochrome and warm, with a cream Soft surface and sand accent buttons instead of lime. Site styles pair these with typography presets (see Typography).

Each palette fills the 11 slots with these meanings:

| Slot | Used for | Target |
|---|---|---|
| `main` / `main-accent` / `secondary` | text, muted text, meta text | 4.5:1 on `base` and `tertiary` |
| `primary` | buttons, Brand sections, icons | `base` on it 4.5:1 |
| `primary-alt` | accent buttons | `on-accent` on it 4.5:1 |
| `primary-alt-accent` | icon tiles on white, light tints | `primary` on it 3:1 |
| `base` / `tertiary` / `border-*` | page, Soft surface, borders | — |

Both palettes come from theme.json, so the active preset drives light mode, dark mode, and Contrast sections:

- Light: `settings.color.palette`.
- Dark: `settings.custom.color.dark`. Every color preset in `styles/colors/` must define its own. It sits under a `color` key because the editor lists a variation as a color preset only when every key it sets is named `color`.
- `settings.custom.color.light` references the light presets. Dark mode overrides the presets on `body`, not `:root`, so these keep the light values for Contrast sections inside dark mode.
- `brand-muted` is derived from `primary` with `color-mix`. `focus-ring` is `primary` itself, solid, so the ring reaches 3:1 on every surface; Brand sections set it to `base` and Accent sections and accent cards to `main`, their text colors.

Bento and tinted cards put `main-accent` text on `primary-alt-accent` and `border-light`, so those pairs need 4.5:1 too. In Brand sections muted and meta text are the section text at 88% and 78%, the lowest that keeps 4.5:1 on the brightest preset brand color.

Check a new or changed palette with the contrast targets above, in both modes, before shipping it.

## 4. Shape

| Element | Radius | Border | Shadow |
|---|---|---|---|
| Cards, panels, images | `lg` (12px) | 1px `border-light` | none |
| Featured card (most popular plan, spotlight) | `lg` | 1px `primary` | `medium` |
| Filled feature and stat cards (tinted background, no border: bento cards) | `xl` (20px) | none | none |
| Buttons | One source: `settings.custom.button` tokens (after exbit.webflow.io: `padding-block` 0.875rem, `padding-inline` 1.75rem, `font-size` lead, `font-weight` 500, `line-height` 1.5556 (28px), `radius` pill). `styles.elements.button`, `core/button`, and its outline variation all read them, so block buttons, search and form buttons, and EDD buttons match (56px tall). Purchase buttons inside product cards use `base` text and `small` side padding so the price label stays on one line in narrow grids | — | — |
| Inputs | `base` (8px) | — | — |
| Search fields | pill, from the `custom.button` radius and inline padding (`_core-search.scss`), so the field matches its button | — | — |
| Chips, badges | `full` | — | — |
| Avatars | `full` | — | — |

- All 61 hardcoded `5px` radii become `lg` or `base`.
- `100px` / `500px` become `full`.
- Card shadows are the theme's shadow presets, set with the block's Shadow control (`medium` on most cards, `x-large` on featured ones), not a custom `box-shadow`.
- Shadows are soft washes in light mode (theme.json: 4–18% black, a tight contact layer plus a wide blur), so a shadowed card still reads by its border. They vanish on dark surfaces, so the dark palette (`palette-dark` in `_variables.scss`) swaps in stronger ones (30–40%).

## 4a. Split media

Image + text side by side: the image uses the `digimia-media-fill` class (no aspect ratio on the block) in a column without vertical alignment, and the text column is vertically centered. From 782px the image fills the text column's height (min 22rem); stacked on phones it is 4:3.

A floating info card can sit on the image: wrap image and card in a `digimia-floating-media` group and give the card `digimia-floating-card` (`base` background, `lg` radius, `large` shadow). It is at most 22rem wide, overlaps the image's lower edge and, from 782px, hangs past its left edge (`feature-split-icons`).

A Cover can take `digimia-media-fill` too (`hero-card-video`): 4:3 on phones, the column height from 782px, so it matches a card beside it. Center a "Watch demo" link on it with a Button that has the `digimia-play-button` class and the `play` icon on the left: a `base` pill with `large` shadow and a `primary` disc with a filled triangle (`_core-button.scss`). Link it to the video page; there is no lightbox.

## 4b. Icons

Use the core Icon block (`core/icon`, WordPress 7.1+) with a Digimia icon (`digimia/download-simple`, `digimia/shield-check`, …; see `docs/developer/icons.md`) as an **icon tile**: `textColor` `primary`, `backgroundColor` `primary-alt-accent` on a white surface and `base` where the tile sits straight on Soft. The lime tint on Soft measures 1.02:1, two pale greens the eye cannot separate; a white tile matches the white cards beside it and follows them into dark mode. The same goes for any small pale fill, such as the release-note pills: its fill is its whole shape, so it needs a surface of a different lightness. Check the surface the tile actually renders on: a card with a `border-light` border and no fill turns white on Soft (`_components.scss`), so its tile stays lime. Soft tiles: `feature-curriculum`, `page-home-plugins`, `hero-contact`, `feature-split-icons`. Cards: width `4.25rem`, padding `0.75rem`, radius `lg` (68px tile, 44px glyph). Compact rows: `3.25rem`, padding `0.75rem`, radius `base` (52px tile, 28px glyph). Write the radius as `var(--wp--custom--radius--lg)`: the Icon block renders on the server and the PHP style engine does not resolve `var:custom|…`. Never use text glyphs (`✴`) as icons.

Layout notes from Chrome testing: vertical flex stacks use `justifyContent: stretch`; do not nest a grid inside a vertical flex stack (use Columns), and keep icon + text stacked, not in a horizontal row, inside grids.

## 4c. Pricing plans

Every pricing section uses one plan card (`digimia-plan`): name (+ badge on the featured plan), price at `xx-large` with a short term (`one-time` or `/ year`), muted description, `is-style-list-check` features, and a full-width button pinned to the bottom. Only the featured plan has the primary button and the featured card treatment; the others use outline. License prices are one-time, matching EDD variable prices. Comparisons use the core Table block with the registered `Comparison` table style (`is-style-comparison`); bold text (`✓`) marks an included feature, `—` a missing one. Wide tables scroll inside their frame on phones.

Split pricing (`pricing-plans-split`, after the Mouly template): a compact plan (40%) beside a featured plan on a Contrast card (60%) on a Soft section. Each card has the name with a badge on the right (`digimia-badge`; the featured one `digimia-badge--accent`), a `lead` description, checks (the wide card in two columns, `digimia-list-columns`), and a bottom row with the price and its button (`digimia-plan__footer`: hairline on top, pinned to the bottom). The compact plan's button is Tint, the featured one primary. The columns are a size container: below 70rem the narrow card cannot fit price and button side by side, so both footers stack them and the dividers stay aligned.

## 4d. Reviews

Review cards (`digimia-review`) hold stars (`digimia-stars`, with screen-reader text "Rated 5 out of 5"), the quote in `main`, and the reviewer (48px round avatar, name, role) pinned to the bottom (`digimia-review__author`). Rating summaries show the score at `xxx-large` with stars and a muted count. Platform icons use `core/social-links` (`is-style-logos-only`) and follow the text color.

The review wall (`review-wall`) puts 9 cards in 3 columns inside `digimia-review-wall`: a 38rem window (44rem on phones) that fades out at the top and bottom, with the middle column raised. Reviews without a photo show name and role only; never repeat one photo under two names.

Stat cards (`stats-split-cards`) are filled, full-width cards at `xl` radius in a vertical stack, one per surface (`primary`, `main`, `tertiary`) inside a Contrast section, so they swap with the palette. The number is a paragraph at `xx-large` (heading font), weight 600, line height 1.

## 4e. FAQ

Questions use the core Details block with the registered `Accordion` style (`is-style-accordion`, CSS in `src/scss/blocks/_core-details.scss`): question at `lead` size, `+` / `−` marker in the brand color, muted answer, hairline dividers. Open the first question by default.

On a Soft section use the `Card` style (`is-style-card`) instead: one white card per question with a `border` hairline and `lg` radius (`faq-buying`). Same marker and typography.

## 4f. Cards

Query Loop cards (`card-post`, `card-image-text`, `card-text-link`, `card-post-list`, `card-author`) use post blocks only, so they work for posts and any custom post type inside a Query Loop. Their terms block uses `category`; switch the taxonomy (for example `download_category`) in the block settings for other post types. Static cards reuse the shared components: plan card, review card, contact card (Contrast panel), product details card (spec rows), and CTA panels (Brand or Contrast).

## 4g. Product cards

One definition for every product card: the `product-card` mixins in `src/scss/_mixins.scss` (padding `large`, radius `lg`, 1px semantic border, soft hover, 4:3 media at radius `base`, title at `medium`/600, purchase area pinned to the bottom above a hairline). Applied to the Query Loop card (`.digimia-product-card`) and to EDD Downloads grid cards (`.digimia-download-grid`). Prefer the Query Loop card where design matters; use EDD's Downloads block only for its features (pagination, featured only).

- Purchase area (2026-11-17): the price at the start, the buy button at its natural width at the end (side padding `medium`, a size down from the theme button). The footer is a size container (`digimia-buy`): below 18rem, the width "From $199.00" beside "Choose options" needs, every card stacks the price over a full-width button, so the hairlines in a grid row stay level. A container can't size itself from its content, so the footer always has a set width (100%, or 100% minus its side margins beside the shop sidebar), never `auto`. The price is never repeated on the button (`show_price: false`). In Query Loop cards it is a "Price and button" group (`digimia-product-card__buy`): a Paragraph bound to the `price_from` product fact (`digimia-product-card__price`) and the Buy Button. In Downloads grids `inc/edd.php` moves EDD's price into the footer. Price in the heading font at `medium`/700 (`large` in the shelf's featured card and the spotlight); for a product with options, "From" stays small and muted before the amount (`digimia-price-amount`), and the button reads "Choose options".

- Product art carries the product name, so every product image stays 4:3 and is never cropped to another shape: in cards, and in all four single-product templates (Showcase, Banner, Guide, Classic). The editorial shelf (`product-editorial-shelf`, reworked 2026-11-13) is one wide featured card (a 58% image beside the title at `x-large`, a three-line excerpt at `lead`, and the buy button) over a row of three standard cards; no card stretches to match another's height, so the art stays large. It shows the store categories only (`templates, ui-kits, fonts, icons, illustrations, presentations`), so a demo with other niches does not put a fitness membership on the store home. Shelf cards carry no category label (§4i-0).

## 5. Buttons (3 roles only)

| Role | Style |
|---|---|
| Primary action | default button (brand fill) |
| Secondary action | `is-style-outline` |
| On Contrast or Brand surfaces | the same two; the section style adapts them (no extra class): the primary becomes the accent color |

The primary button in heroes and calls to action carries an arrow (`digimiaIcon` `arrow-right`, position right). Secondary buttons have no icon.

There is at most one primary button per section. The stray `is-style-fill`, `is-style-default`, and `is-style-wp-block-button` classes on buttons are removed.

## 5a. Interaction states

Hover never swaps colors, so it reads in every variation, section style, and color mode (rules in `src/scss/_buttons.scss`, mixins `tint` / `button-states` in `_mixins.scss`).

| Element | Hover | Press |
|---|---|---|
| Buttons (all variations, EDD buttons) | wash of the button's own text color, 12% (inset shadow) | 20% |
| Outline buttons | ring plus the same 12% wash | ring plus 20% |
| Header icon controls (theme switch, mini cart) | round 10% wash | — |
| Text links | keep color; underline goes from 40% to full strength | — |
| Nav, title, and sidebar links (no underline at rest) | underline appears | — |
| Cards | `border-hover` border, `small` shadow, 1.03 image zoom | — |
| Chips, pagination, inputs | `border-hover` border (pagination adds `surface-1`) | — |

Keyboard focus is a 2px `focus-ring` outline with a 2px offset on every control (`_accessibility.scss`). It is an outline, not a shadow: buttons, EDD buttons, and social links set `box-shadow: none`, which hid the old shadow ring, and Windows High Contrast drops shadows. Inputs also turn their border `primary`.

Do not set `:hover` colors in `theme.json`, section styles, or button variations. A color-only change fails WCAG 1.4.1 and, between the near-black text and the dark brand green, is nearly invisible. Buttons were measured at 4.5:1 or better at rest and on hover in all 4 sections and both modes.

Status colors are `custom.semantic.error`, `success`, `warning`, and `info`: fixed hues, lighter in the dark palette, so they do not change with color presets. Alerts are a 10% tint of the status color with a 40% border and a status icon (`warning-circle`, `check-circle`, `warning`, `info`); the text stays `text-primary`. Required-field asterisks and the password strength meter use the same tokens.

Button variations live only in `styles/blocks/button/*.json`. Text on `primary-alt` (Brand alt) uses `custom.semantic.on-accent`, which is `main` in the light palette and `base` in the dark one.

## 4h. Templates

Every file in `templates/` is one pattern reference (`template-*`, Inserter false), so a template and its Site Editor starting pattern never drift. Template patterns hold the header and footer parts and a `<main>` of full-width sections.

- **Posts:** category eyebrow, H1 at `xx-large`, byline (avatar, author, date, reading time), a 16:9 image at the text width (one column and one left edge; `template-post-wide` keeps a wide image), content, then tags (`is-style-term-button` chips), the author card, and comments in the same section. A Soft "Keep reading" section follows; its Post Template class `digimia-related` leaves out the current post, and the section hides itself when no other posts exist.
- **Pages:** H1 at `xx-large`, image at the text width, content. Full width has no title or padding, for pages built from section patterns.
- **Listings** (archive, index, search): a Soft title band, then the shared post grid or list. 404 is a Soft spacious hero with search and two buttons, followed by the product grid.
- **Sidebar:** the Sidebar part references `digimia/sidebar` (search, latest notes, topics, Brand shop panel).
- **Front page:** there is no `front-page.html`, so Settings › Reading decides: latest posts use `index.html`, a static page uses its page template (pick "Page (no title)" for a homepage built from sections). Every `page-*` pattern is a starter pattern (`Block Types: core/post-content`, `Post Types: page, wp_template`), offered when a new page is created; `page-home` is the marketplace homepage and `page-home-saas` the SaaS homepage (see `docs/developer/storefront-design.md`).

## 4i. SaaS and service sections

Sections for the niche homepages (SaaS & Software first), added 2026-11-05. CSS in `src/scss/_marketing-sections.scss` and `src/scss/blocks/_core-tabs.scss`.

- **Product hero** (`hero-saas-dashboard`): Soft, spacious. A rating row (`digimia-avatar-row` of three 40px avatars, stars, muted count), H1, lead, two buttons, a `secondary` note, then the `digimia-saas-dashboard.svg` illustration at wide width and a client-logo row.
- **Photo heroes** (`hero-cover-split`, `hero-cover-glass`, `hero-cover-actions`): a Cover with the `digimia-photo-hero` class. A photo looks the same in both color modes, so the class gives the whole cover the **dark palette in both modes**: the overlay is `base` (a dark scrim) and the text, buttons, and pills are the dark-mode colors. Never put a Contrast section inside one. Overlays stay light enough to show the photo (20–60%; the split hero fades a 90% `base` gradient from the left).
  - Split (`digimia-photo-hero--split`): text in a 38rem column on the left, with the gradient behind it. Below 782px the gradient becomes an even 80% scrim, because the text spans the width.
  - Glass: the text sits in a `digimia-glass-card` (60% `base`, 18px backdrop blur, `xl` radius, `large` shadow).
  - Centered: an even scrim, for one bold statement.
- **Tabs** use the core Tabs block (WordPress 7.1) with the `digimia-tabs` class: a pill switch centered above the panels; the selected tab is a raised `surface-0` chip. The product tour (`feature-product-tabs`) puts text and an image in each panel.
- **Monthly / yearly pricing** (`pricing-billing-switch`) is the same Tabs block (`digimia-tabs--billing`) with one plan grid per panel, so it needs no custom script. Each panel holds its own prices; the yearly plans state what is billed per year.
- **Before / after** (`feature-comparison`): two cards in Columns. The old way is a plain card with the `Cross` list style (`is-style-list-cross`, muted ✕); the product is the featured card with checks and the section's one primary button. Use the Comparison table instead when comparing several plans or products on many rows.
- **Integrations** (`feature-integrations`): Split header beside a 3-column grid of `digimia-integration` tiles (1px border, `lg` radius, compact icon tile, name at 600). Brand icons are Phosphor's (see `docs/developer/icons.md`); the last tile is "40+ more".

## 4i-0. Rules across the homepages

Set 2026-11-13 in a consistency pass over the six demo homes, after the user's references (optimize.framer.website/home-1, exbit.webflow.io, zaplytic.webflow.io). New homes and sections follow them too.

- **No labels above section headings.** The heading stands alone with a lead line under it. The uppercase eyebrow reads as template filler, and the references use none. The same goes for page and hero H1s, and for card titles when the label only restates the title. A pill is fine only when it carries a fact: tags, a "New release" or "Book one" note, a "New" announcement, a 404 status, a program length, a "Most popular" badge. Small uppercase labels stay where they are data, not decoration: post categories and "Client · Field" on cards, day names in the weekly plan, and labels inside product mockups (UI cards, a lesson player), because those imitate an interface. Sidebar widget titles are headings (H2 at `medium`), and the caption over a logo row is plain `small` text in `main-accent`.
- **One highlighted word, in the hero headline only.** Section headings carry no `<mark>`. A book title in the hero gets none.
- **The main hero button is visible without scrolling** at 1440 × 900 (bottom edge between 518 and 693px on the six homes).
- **Section backgrounds alternate** plain and Soft; Contrast sections count as breaks. A logo strip directly under the hero belongs to the hero.
- **Every section uses `xx-large` (96px) padding** top and bottom, except heroes, logo strips, and a photo card section with none.
- **The recommended plan is a Brand card** on a light section (`is-style-section-brand`, plain `digimia-badge`) and an Accent card on a Contrast section. The coaching row follows the same rule.
- **Every home ends with the FAQ, then a closing Brand card** with two buttons and a visual, in a section that alternates with the FAQ. The store, plugins, and fitness closings use the same markup as `cta-brand-panel`. `cta-closing-note` (the store's) uses a photo (`workspace-sketch.webp`) that fills its column with `digimia-media-fill`, like the fitness card; the marketplace illustration was dropped there on 2026-11-13.

## 4i-1. SaaS homepage sections

The SaaS homepage (`page-home-saas`, rebuilt 2026-11-11, replacing the earlier calmer version, after keydesign's web-app, analytics, and AI-software demos and Nexsas automation). Same palette, but the accent colors cover large areas. CSS at the end of `src/scss/_marketing-sections.scss`.

- **Marked words:** a heading can mark one or two words with the core Highlight format left without a background (`<mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color">`, the transparent background the editor writes itself; a mark with no `style` crashes the editor's Highlight tool when the word is clicked). Light surfaces draw a `marker` band behind the word; dark surfaces (dark palette, Brand) color the word instead (`marker` / `marker-text` tokens, set per palette in `_variables.scss`). A background picked in the editor overrides both; a text color picked there keeps the band. Only the hero headline marks a word (see §4i-0).
- **Pill** (`digimia-pill`, on a paragraph): a small rounded label for a fact, such as tags, a release note, or a program length; not above section headings (§4i-0). A bold first word becomes an accent tag ("**New** …").
- **Glow hero** (`hero-saas-glow`): a curved stage lit by `primary-alt` and `primary` glows at its lower corners ends 42% of the way down the product screenshot (`digimia-glow-hero__stage`). The stage is the section's own color, so the section style picks the look: Soft (the pattern's default and the SaaS home's), Contrast for a dark stage (dark in light mode, light in dark mode, like every Contrast section), or none for the page color. A strip in the page color brings the page back below the curve; the ellipse cut out of its top edge draws the curve, and Contrast reads the page palette's `base` for it. The section is a size container, so the cut follows the screenshot's 1200 × 820 artwork at every width. The top stays plain, so the stage meets the header without a seam. The screenshot stays light in every mode. Two `digimia-float-chip` notes sit on its edges from 1024px. Client logos follow in their own section.
- **Product rows** (`feature-ui-rows`): a centered heading over a `tertiary` panel (`xl` radius) with two alternating rows: H3, checklist, and a Brand alt button beside a layered product visual.
- **Bento** (`feature-bento-automation`): Soft section, two rows of Columns (64/36, then 36/64). Cards: white with a visual, an accent card (`digimia-accent-card`: `primary-alt` with `on-accent` text, a big number), and a Contrast card with a checklist.
- **How it works** (`feature-steps-panel`): Contrast section, three `tertiary` step cards with a `digimia-badge` step number, then a wide panel with a CTA beside a product visual that stays light (`digimia-visual-light`).
- **Pricing** (`pricing-plans-brand`): `pricing-billing-switch` with the featured plan filled with the Brand section style (`is-style-section-brand` on the plan card) and an `x-large` shadow. On Brand surfaces check marks and the badge take the section's text and button colors.
- **FAQ** (`faq-split`): Soft; heading, lead, and a white contact card on the left (40%) beside the accordion (60%).
- **CTA** (`cta-brand-panel`): a Brand panel (`xl` radius) inside a plain section with `xx-large` padding: H2, lead, two buttons, notes, and a product visual tilted −4° from 782px (`digimia-tilt`).
- **Product visuals:** `digimia-saas-workflow.svg` (hero) and `digimia-ui-*.svg` (insights, runs, integrations, branches, activity) follow the illustration rules in §6, so they take the active palette, Contrast cards, and dark mode.

## 4i-2. Fitness homepage sections

The fitness homepage (`page-home-fitness`, rebuilt 2026-11-12, replacing the earlier version, after activeaura, zenlift, ironwood, and lemongym on Webflow): dark sections, black-and-white coach portraits, and the accent color on cards and highlights, not on whole sections. The photos (replaced 2026-11-12, CC0 from StockSnap and PxHere) mix bright outdoor shots and dark gym shots of people training in training clothes, across ages. The header and the training section are Soft, with the full-width photo hero between them. CSS at the end of `src/scss/_marketing-sections.scss`.

- **Photo hero** (`hero-fitness-photo`, full width since 2026-11-12): a full-width photo Cover (`digimia-fitness-hero`, a `section`, content at the bottom) whose content group holds wide columns, so the text and card line up with the header's logo and cart. The photo is bright, so the scrim is solid `base` to 25% and fades out by 80%, like `hero-cover-split`, and the text column is 52%. Tag pills, an H1 at `display` with a marked word, two buttons, and a program card that keeps the light palette on the photo (`digimia-card-light`), pinned to the bottom right at 24rem. The content group has `xx-large` padding at the bottom. The Cover's content position is bottom center, not bottom left: core shrinks the content to fit for the left and right positions, which would break the wide columns. Below 782px the scrim becomes even (`digimia-photo-hero--split`).
- **Training at your pace** (`feature-fitness-pace`): Soft, like the header: a heading beside three `base` tiles with accent icon tiles, then a wide photo with stat pills.
- **Program tiles** (`feature-program-tiles`): a checkerboard of Contrast text tiles (program-length pill, H3, checks, price, button) and photo Covers with pills (`digimia-media-fill`), two rows, alternating.
- **Tracking** (`feature-fitness-tracker`): Soft bento: an accent stats card beside a photo, then two cards with app views (`digimia-ui-goals.svg`, `digimia-ui-week.svg`). A stats grid inside a card that fills its column uses a fixed column count, not a minimum width: WordPress makes a minimum-width grid a size container, and its rows then grow to fill the card.
- **Coaches** (`team-coaches-mono`): Contrast, a split heading over four portrait Covers in black and white (`digimia-photo-mono`) with an accent badge, name, and role.
- **Member quote** (`review-accent-quote`): a black-and-white portrait beside a large quote on an accent card with the result as badges.
- **Memberships** (`pricing-membership-accent`): Contrast, three cards; the featured one takes the Accent section style.
- **FAQ** (`faq-accent-photo`): heading, a help card on the accent color (`digimia-accent-card`), and a photo with pills beside the accordion.
- **Closing card**: the standard Brand card on Soft (§4i-0), with the dumbbell photo. Until 2026-11-13 the home ended with the FAQ after `cta-split-band`, which stays in the library: `digimia-split-band` paints its top half in the Contrast surface and its bottom half in the page color, so a card bridges a Contrast section above and the page below. It only works directly under a Contrast section.

## 4j. Plugin and theme shop sections

Sections for the Plugin & Theme Shop homepage, added 2026-11-06. CSS in `src/scss/_marketing-sections.scss`.

- **Plugin hero** (`hero-plugin-shop`): Soft, spacious, split 56/44. H1 at `xxxx-large`, lead, two buttons, then a `digimia-hero-stats` grid of three numbers (`large`, 700) with short `small` labels, three columns at every width; on the right `digimia-ui-plugins.svg`: tilted cards for installed plugins (one update ready), a Business license on 3 of 5 sites, and a PageSpeed score.
- **Catalog in tabs** (`product-catalog-tabs`): Split header row, then `digimia-tabs digimia-tabs--start` (the pill switch aligned left, under a left heading). Each panel is a Query Loop of the three latest downloads in one download category (`plugins`, `themes`, `bundles`), with the standard product card. Query blocks store term IDs, so the pattern prints them with `\Digimia\download_category_ids( '<slug>' )`, which also takes several slugs separated by commas; missing categories are skipped, and if none exist the query shows all downloads. The header link is the section's one "see all" link; panels have none (a second link under each panel was dropped on 2026-11-15).
- **Developer code** (`feature-developer-code`): text and checklist beside a `digimia-code-window` (title bar with dots and file name, then a Code block). Like the photo heroes, the window keeps the **dark palette in both modes**.
- **Release notes** (`product-release-notes`): rows split by 1px rules. Each row is Columns: version badge, product name, and date on the left; a `digimia-release__notes` list on the right where each item starts with `<strong>New|Improved|Fixed</strong>`, shown as a pill: pale lime on white, white on Soft (the same rule as icon tiles). Also the base for a Changelog page.
- **Support resources** (`feature-support-resources`): Soft, four cards (icon tile, H3, text, link). Not on the plugin home any more: its channels moved into the FAQ there.
- **Plugin home, reworked 2026-11-12**: the principles are a two-column list (icon tile, title, one line, no per-item links) beside `digimia-ui-performance.svg` (front-end weight against a typical plugin, three figures, two scores), so the section proves "small and fast" instead of repeating a card grid. The featured All Access plan is a Brand card, like the SaaS plan. Reviews sit on Soft. The FAQ is split: heading, lead, and a `tertiary` card of four help channels (Docs, Videos, Priority support, Community) beside the accordion, which replaces both the separate support section and the "Still have questions" card.
- Layout note: a **vertical flex** group that holds Columns, a grid, or a Query Loop turns wrapping off (`"flexWrap":"nowrap"`, "Allow to wrap to multiple lines" in the editor), or is a flow group (`"layout":{"type":"default"}`). Flex groups wrap by default, and in a wrapping stack Chrome lays each item out at its content width before stretching it, so a row of columns is measured narrow and keeps that height: the fitness stats card grew from 586px to 928px, with the photo beside it stretched to match (`feature-fitness-tracker`, `feature-program-tiles`, `pricing-single-product`, fixed 2026-11-14). A grid with a minimum column width is worse: WordPress makes it a size container, which has no content width, so a wrapping stack lays it out almost zero wide (the plugin home's principles grew to 7,453px). Give that stack `"flexWrap":"nowrap"` too.

## 4k. Courses and coaching sections

Sections for the Courses & Coaching homepage, added 2026-11-06. CSS in `src/scss/_marketing-sections.scss`.

- **Instructor hero** (`hero-course-instructor`, reworked 2026-11-12): Soft, split 46/54. Rating row, H1, lead, two buttons, a `digimia-check-row` of promises; on the right a lesson player (`digimia-course-stage`): a photo Cover (`digimia-course-video`, 4:3 from 1024px) with a `digimia-play-button` (a light pill on the dark photo palette) centered on the whole player by a three-row grid (`1fr auto 1fr`, the bar in the bottom row) and a frosted `digimia-lesson-bar` whose bottom edge is the lesson's progress (`--digimia-progress`). From 1200px a "Live Q&A" note (`digimia-float-chip--start`) and the progress card (`digimia-ui-course.svg`, `digimia-float-art--end`) hang off its corners, only as far as the page margin allows (`--digimia-hang`), so nothing scrolls sideways.
- **Curriculum** (`feature-curriculum`): Soft, split 40/60. Header, a 2-column grid of course facts (compact icon tile + bold text), one primary button; on the right one Details block per module in the `Card` style, the first open. Each module has a `small` meta line and a `digimia-lessons` list (play marker per lesson).
- **Instructor** (`feature-instructor`): 1:1 photo beside header, one paragraph, three numbers (`digimia-hero-stats`), and a link.
- **Coaching sessions** (`pricing-coaching-sessions`): header and a 3:2 photo beside `digimia-session` rows (name and description left, price and Book button right). The recommended row is `digimia-session--featured` (brand border, `medium` shadow, primary button); the others use outline buttons. The recommended row is a Brand card (`is-style-section-brand`, no border, `x-large` shadow), like the featured plans elsewhere.
- **Courses home, reworked 2026-11-12** (`page-home-courses`): how it works is a Contrast section with a split header and three `tertiary` step cards led by a `digimia-step__badge` (the number in a filled circle); the FAQ is split with the contact card on the left; the FAQ is Soft and the closing call to action is a Brand card on the page color with a tilted certificate of completion (`digimia-ui-certificate.svg`, kept light with `digimia-visual-light`).

## 4l. Book and author sections

Sections for the Books & Writers homepage, added 2026-11-06. CSS in `src/scss/_marketing-sections.scss`.

- **Book covers** are Image blocks with the `digimia-book-cover` class at 2:3: a square spine edge, rounded fore-edge, a `large` shadow, and an inner spine shade. On phones a cover is at most 15rem wide.
- **Book launch hero** (`hero-book-launch`, rebuilt 2026-11-13 after the Blocksy Book Store starter site): Soft, Columns 44/56 whose columns end on the same line. Left: a "New release" pill, H1 at `xxxx-large`, author at `large`, buy and sample buttons, then a `primary-alt-accent` trilogy link card that fills the rest of the column (`style.layout.selfStretch: fill`, at least 28rem): the three covers fanned (`digimia-cover-fan`, the new release in front at 1.12×, each cover at most 9rem wide) sit on the title, so the arrow's corner stays free at every width. Right: the blurb at `lead`, then a two-column grid that fills the rest: a Contrast link card with the chapter's first line as a teaser above a white box-set offer, and a tall photo link card (`reader-park.webp`, focal point on the reader). The grid has a column count but no minimum width: WordPress makes a minimum-width grid a size container, and inside this fill-height stack Chrome then grows it without limit (2,578px). Phones get one grid column from CSS. Before 2026-11-13 the buttons sat under the cover at 1125px, and a Soft band cut through the text.
- **Link card** (`digimia-link-card`, on a Group or a photo Cover): the H3 link covers the whole card (`::after`, focus ring on the card), and a round `arrow-up-right` Icon block (`digimia-link-card__arrow`) sits in the top corner, rotating 45° on hover. The chip takes the card's `main` and `base` colors, so it is light on photos and dark cards and dark on a light card. Every card puts its title and meta line in one group with `small` gap and its arrow `large` from the top and side. On a Cover the inner container fills the card, so the arrow can sit at its top; core shrinks that container for a bottom-left position with five classes, so the full-width rule uses the same weight. A first-line teaser takes `digimia-link-card__teaser` to keep clear of the arrow.
- **Series** (`product-book-series`): centered header, three covers in reading order, each with a "Book one" pill, H3, one-line hook, and link; a centered box-set link below.
- **Excerpt** (`feature-book-excerpt`): Soft, a 3:4 photo beside the opening of a chapter in `medium` text with a 36em measure. The first paragraph has a drop cap restyled in the brand color (bold, three lines tall), because core's thin 8.4em letter does not suit the body font.
- **Press praise** (`review-press-quotes`): one centered x-large quote (weight 500, line height 1.3, balanced) with stars and source, three quote cards, and award badges.
- **Books home, reworked 2026-11-12** (`page-home-books`): the newsletter photo is a rounded wide Cover instead of a full-bleed band; the FAQ is split (heading, lead, and the contact card beside the questions), so the contact card no longer trails the list; the FAQ is Soft and the closing call to action is a Brand card on the page color with the trilogy fanned on the right (`digimia-cover-fan`: the middle cover in front, the outer two tilted 8° and tucked behind).

## 4m. Health and fitness sections

Sections for the Health & Fitness homepage, added 2026-11-06. CSS in `src/scss/_marketing-sections.scss`.

- **Goal cards** (`feature-goal-cards`): four 26rem Cover cards (`digimia-photo-hero digimia-goal`, `lg` radius, `medium` shadow) with a fade from 25% down to `base` and the text at the bottom left: H3, one line, link. Like the photo heroes, the cards keep the dark palette in both modes. The shadow keeps the edge when a photo is light.
- **Weekly plan** (`feature-weekly-plan`): Soft. Split header row with one primary button, then a 7-column grid (8rem minimum) of `digimia-day` tiles: day eyebrow, session at 600, `small` duration. Rest days use `digimia-day--rest` (dashed border, no fill, secondary text).
- **Member results** (`review-results`): three cards led by a `digimia-result` (the result at `xx-large` 700 in the brand color, with a `small` label), then stars, the quote, and the member with avatar and program. Results copy says what is typical, not promised.

## 4n. Inner pages: contact, changelog, pricing

Shared inner pages, added 2026-11-06. CSS in `src/scss/_marketing-sections.scss`.

- **Contact** (`hero-contact`, `page-contact`): Soft, spacious, split 45/55. H1, lead, and four `digimia-contact-method` rows (compact icon tile, title at 600, `small` text or link); on the right a `digimia-message-card` (card with `surface-0` fill and `medium` shadow) with an H2 and a `digimia-form-slot` (dashed box) that the buyer replaces with their form plugin's block. The theme ships no form: the global field styles cover inputs, and the card spaces labels and gives a plain submit input the button look (button tokens, `button-states`). The demo uses Contact Form 7.
- **Changelog** (`page-changelog`): a Soft intro with H1, lead, and two buttons, then `digimia-release` rows (see §4j) for every release, newest first.
- **Pricing for software** (`page-pricing-saas`): the billing switch with its heading as the H1, the comparison table in SaaS terms, FAQ, and a call to action. `page-pricing` stays the store version.

## 4o. Inner pages: features, integrations, how it works

Added 2026-11-06. CSS in `src/scss/_marketing-sections.scss`.

- **Page header** (`hero-page-header`): Soft, spacious, centered H1 (`xxx-large`), lead, and up to two buttons. Use it at the top of any inner page.
- **Alternating rows** (`feature-alternating-rows`, `digimia-feature-rows`): 45/55 Columns that swap sides each row (`xx-large` H2, `medium` text, checklist beside an illustration or 4:3 photo), `xxx-large` space between rows.
- **Integration directory** (`feature-integration-directory`): a 4-column grid of `digimia-integration digimia-integration--card` tiles (compact icon tile with the category at the top right, name at 600, `small` description, link pinned to the bottom).
- **Steps timeline** (`feature-steps-timeline`): a centered 48rem `digimia-timeline` of `digimia-timeline__step` rows, each a 3rem brand circle (`digimia-timeline__number`) joined by a 2px line, beside H3, text, and checklist.

- **Team grid** (`team-grid`): centered header, a 3-column grid (9rem minimum, so phones keep two per row) of `digimia-member`: 4:5 portrait, H3 name, role in `small` brand color, one `small` line.
- **Open positions** (`careers-openings`): left header and a wide list of `digimia-job` rows split by rules: H3 title, a `digimia-job__meta` row (team in brand color, place, type, dot-separated), and an Apply link on the right.
- **Service cards** (`services-cards`): three `digimia-service` cards (icon tile, H3, text, checklist, "From" price, full-width quote button pinned to the bottom); the middle one is featured.
- Team, Careers, and Services pages alternate Soft and plain sections and end with a Contrast call to action. Value and perk boxes reuse `feature-boxes-actions` without the "Learn more" links.

- **Shop with sidebar**: `product-grid-sidebar` (a section for pages, all downloads) and `template-shop-sidebar` (a full template for the shop or category archives; its Query Loop inherits the archive). The product category and tag templates use it (`templates/taxonomy-download_*.html`); `edd_template_types()` (`inc/edd.php`) names them, and the Shop template, in the Site Editor. Columns: a 16rem sticky `digimia-shop-sidebar` (`aside`: product search without a button, Categories block on `download_category` as a `digimia-filter-list` with counts, a 12-tag cloud on `download_tag` as small pills, a help link; groups split by rules in `digimia-filter`) beside a 3-column product card grid with numbered pagination, an `x-large` gap between them. The grid is narrow, so its cards drop the inset frame: the image runs to the card edges and the text has `medium` side padding (`_storefront-sections.scss`). No price or sort filters: they need a plugin.
- **Portfolio** (`portfolio-grid`): six `digimia-project` cards (4:3 image, "Client · Field" eyebrow, H3, one line, case study link).
- **Case study** (`hero-case-study`, `case-study-story`): centered H1 and lead, a 4-column `digimia-case-facts` row between rules, a 21:9 image; then challenge and solution columns, a `digimia-case-results` panel (surface-1, three brand-colored figures), and a centered `digimia-case-quote`.
- **Coming soon** (`page-coming-soon`): a 100vh `digimia-photo-hero` Cover with the site logo (white, like on Contrast), H1, lead, two buttons, and a note. Use it with the **Blank** page template (`templates/page-blank.html`, no header or footer).

**New class names:** before adding a class, search `src/scss/` and `patterns/` for it. `digimia-form-card`, `digimia-contact-card`, and `digimia-step` already belong to store sections; reusing a name restyles them too.

## 4p. Phone menu

Added 2026-11-16. This uses core's Navigation Overlay: the Navigation block's `overlay` attribute names a template part in the `navigation-overlay` area, and that part replaces core's default phone menu.

- **When it shows (2026-11-17):** core swaps the menu for its button below 600px only, so a long menu wrapped onto a second line first. In the theme's headers (`.digimia-site-header`) the full menu shows while its top-level items fit on one line and the button when they don't, at any width from 600px: `src/js/header-menu.js` (in the main bundle) tries the full menu on load, after the fonts, and on resize, and marks the Navigation block `data-digimia-menu="fits"` / `"button"` (`_core-navigation.scss`). A short menu stays in view down to 600px; the demo's five items fit down to about 780px. Until the script runs, 600–1023px shows the button (the header is as tall either way, so nothing shifts); not in the editor, where the items stay in view to be edited, and not without scripts (`scripting: enabled`), which the button needs to open. A Navigation block outside those headers keeps core's 600px.
- **Dropdowns (2026-11-18):** a dropdown opens under its label, its links lined up with the label's text, and a nested menu opens beside its parent; both open toward the end of the line. Core opened every dropdown of a right-aligned menu toward the start, so it hung off to one side of its label. When an open panel would run off the screen, `src/js/dropdown-menu.js` (main bundle) marks its item `data-digimia-flip` and it opens toward the start; a flipped nested menu's arrow points that way. In the editor a selected item's dropdown opens (the theme's rule that hides closed dropdowns had hidden it there). These rules only reach a Navigation block that collapses to a button (`overlayMenu` `mobile` or `always`): one set to `never` has no responsive container, so its dropdowns keep core's look.

- **Wiring:** each design has its own part in the `navigation-overlay` area, holding one pattern. The free theme has `mobile-menu`, registered in `theme.json`; the other five come from Digimia Pro (its `parts/`, listed in `part_list()` in its `includes/designs.php`): `mobile-menu` ("Shop button", the links design), then `mobile-menu-search`, `-columns`, `-brand`, `-account`, and `-featured`. All three header patterns set `"overlay":"mobile-menu"`. The Navigation block's Overlay template dropdown lists overlay parts, not patterns, so one part per design is what lets a site owner switch designs from that dropdown. Part titles are short ("Product search", not "Mobile menu: product search") because the closed dropdown cuts titles off after about 18 characters. The part's pattern list still offers all six, and the dropdown's + button creates a new blank overlay part.
- **Patterns** (`menu-mobile-*`, Block Types `core/template-part/navigation-overlay`):
  - `links`: shop button and an account link (the default);
  - `search`: download search first, account links at the bottom;
  - `columns`: Store and Help link columns, plus social icons;
  - `brand`: Brand panel with the site name, a short store line, and social icons;
  - `account`: a "Your purchases" card with library, licenses, checkout, and an account button;
  - `featured`: one featured download card.
- **Account links say "Your account", never "Sign in".** Pattern markup is fixed when the pattern is registered, so it can't tell a signed-in visitor from a guest. "Your account" is true for both, and the account page shows the sign-in form to guests.
- **Shared structure:** each is a `base` panel with a 100dvh minimum height. It has a top bar (site logo and `core/navigation-overlay-close`), then a vertical Navigation block (`overlayMenu: never`, `submenuVisibility: always`, no submenu icons). The extras are pushed to the bottom with `margin-top: auto`. The Navigation block has no `ref`, so it shows the site's menu.
- **Submenus are always open.** Core opens every submenu while the overlay is open (`isSubmenuOpen` in the navigation view script), so an accordion isn't possible. A parent item reads as a group heading in the large size, and its links sit under it in `base` size, muted, and indented. CSS is in `_core-navigation.scss` under "Phone menu from a Navigation Overlay part". The old open-menu rules are scoped with `:not(.disable-default-overlay)`, so they only style core's default menu.
- **Core gaps the theme covers:**
  - Core only marks a Navigation block inside an overlay when it's written directly in the part. The theme's part holds a pattern reference, so `expand_overlay_part_patterns()` (`inc/blocks.php`) expands it first. Without that, the inner menu renders as a second `nav` with the label " 2".
  - Core's close button keeps the browser's black button text. In the overlay it inherits the panel's text color and gets a 44px target.
  - Core renders the overlay's top-level blocks without `render_block_data`, so a section style (Brand, Contrast, Accent) on the outermost group never gets its colors. The Brand pattern wraps its panel in a plain group for this reason. Do the same in any new overlay pattern that uses a section style.
- **Logo-only social icons** in the overlay follow the text color, as they do in the footer.
- **Links:** the overlay sits inside the Navigation block, which removes link underlines. Paragraph links get theirs back (WCAG 1.4.1). Link lists use `digimia-footer-links`, the footer's muted style.
- **Where the patterns appear:** `Inserter: true` with `Post Types: wp_template_part`. The editor drops `Inserter: false` patterns from a template part's pattern list as well. The post-type limit keeps the patterns out of page editing, where the editor would otherwise offer them, because it only checks a pattern's top-level blocks.
- **Editor view:** the submenu styling is repeated for `.editor-styles-wrapper ... .open-always`, so the part looks the same in the Site Editor. The theme's rule that hides closed submenus skips `.open-always`.
- **Opening the part in the Site Editor marks it as changed.** The Navigation block pins the site's fallback menu as its `ref`. This is core behavior, and saving it is harmless.

## 5b. Accessibility (WCAG 2.2 AA)

Checked on 2026-11-16 with axe-core 4.10.2 on the visual-regression pages (light and dark at 1440px, light at 390px), plus a keyboard pass. These rules keep the pages passing:

- **Headings:** one H1 per page, and levels never skip. A card title right under the page H1 is an H2 (pricing plans, changelog releases, the Books hero cards, shop product titles through `edd_shop_title_level()`); under a section H2 it is an H3. The product templates put a visually hidden "Description" H2 before the description, so a description that opens with an H3 still nests. Software Licensing's manage views get an H1 from `license_view_heading()`.
- **Text on colored surfaces:** blocks inside Brand, Accent, and accent-card surfaces take their text color from the surface, never a `textColor` preset. A preset class is `!important` and keeps its own light or dark value on a surface that does not change, so `main-accent` text on the lime help card fell to 1.1:1 in dark mode.
- **Touch targets:** links that stand on their own (a paragraph holding only a link, post titles, category chips) get 0.25rem of block padding, which reaches 24px without moving the text.
- **Scrolling content:** code blocks, preformatted text, and tables that scroll sideways can take focus, so they scroll from the keyboard (`focusable_scroll_area()`).
- **Landmarks:** all page content sits in `<main>`, related products included.
- **EDD fields:** the register form's email label points at its field, and Software Licensing's license key and site fields have labels (`edd_field_labels()`). Required fields keep the theme's field text color.
- **Left as they are:** sidebar templates nest an `<aside>` in `<main>` (valid HTML, an axe best-practice note only). The admin bar's ARIA roles are core's.

## 5c. Right to left (Arabic)

Added 2026-11-17. When the site language is Arabic, WordPress sets `dir="rtl"` and the layout flips. These rules keep the theme correct both ways:

- **Start and end, never left and right.** Use logical properties: `margin-inline-start`, `padding-inline`, `inset-inline-end`, `border-inline-start`, `text-align: start`/`end`, `float: inline-start`. One-sided shorthands become `padding-block` plus `padding-inline`. They render the same left to right. `theme.json` can only set left or right spacing, so a one-sided setting goes in Sass: the list indent is `:root :where(.wp-block-list) { padding-inline-start }` in `_core-list.scss`.
- **Movement and shapes use `:dir(rtl)`.** Transforms, gradients, and rotations have no logical form, so each gets a mirrored `:dir(rtl)` rule beside it: button icon nudges, the switch knob, the lesson progress bar, the link-card arrow turn, the category card arrow (`\2190`), and the fanned book covers.
- **Arrows point the reading way.** Icons whose slug says left or right (`arrow-right`, `arrow-up-right`, carets) get `is-directional` (`is_directional_icon()` in `inc/icons.php`; the button icon extension and Icon blocks, front end and editor) and are mirrored with `scaleX(-1)`. Text arrows (`→` after a link) sit outside the translated strings, so `flip_text_arrows()` (`inc/blocks.php`) swaps `→` and `←` in paragraphs, headings, and buttons on right-to-left sites. The editor still shows the typed arrow. Media controls (the play triangle) and check marks do not flip.
- **Pictures keep their direction.** Inlined SVG illustrations, code windows, `pre`, and code stay left to right (their drawn text would otherwise line up from the wrong edge), and so do email, URL, and license key fields. A split photo hero (`digimia-photo-hero--split`) mirrors its photo and fade, so the dark side stays under the text.
- **Arabic typography.** On Arabic or right-to-left pages (`:root:is(:lang(ar), [dir="rtl"])`; the editor canvas only says the direction): letter spacing is off (`!important`, it breaks Arabic joins, including spacing set in Styles), the tight and snug line heights rise to 1.35 and 1.45, and the display size to 1.25. All in `_rtl.scss`. Each typography preset brings its own Arabic font (see Typography).
- **Testing.** Build the demo store on a site set to Arabic, then `yarn test:visual --baseline=rtl` with `WP_API_URL` pointing at it: a second baseline, never mixed with the English one. English screenshots must not change.

## 6. Images

| Use | Aspect ratio |
|---|---|
| Product images in cards | `4/3` |
| Hero and media images | `16/9` or `4/3` |
| Avatars | `1/1` |

Images are always `object-fit: cover` with `lg` radius (or `full` for avatars). No hardcoded `id` attributes on bundled images.

- **Logos:** headers and footers use the Site Logo block (132px in headers, 116px in footers). Without a logo set, `inc/blocks.php` renders the site title in its place. A dark single-color logo turns white in dark mode and in Contrast sections (`_helpers.scss`).
- **Client logos:** `client-logo-*.svg` are original placeholder logos for fictional brands (Northfield, Priority, Kiln Studio, Halden): a geometric mark plus a wordmark outlined from a bundled OFL font, in one dark color, shown with the `digimia-client-logo` class (muted, inverted on dark surfaces). Size them by height so they look equal in weight.
- **Icons:** one set, Phosphor regular (`assets/icons/`, `inc/icons.php`), used by the core Icon block as `digimia/<slug>` and by button icons. No core `core/*` icons in patterns: they use a different, solid style. Feature icons sit in a `primary-alt-accent` tile, `base` radius, `primary` color.
- **Illustrations:** `patterns/images/digimia-*.svg` (in the theme, or in Digimia Pro's `patterns/images/` for art only Pro patterns use; Pro adds its folder through `digimia_image_folders`) color shapes with classes in an inner `<style>` (`dg-` prefix) that read palette custom properties, with the default palette as fallback. On the front end `inc/blocks.php` swaps the Image block's `<img>` for the SVG markup, so the art follows color presets, Contrast sections, and dark mode; the editor and any other `<img>` use show the default palette. Text on a `primary-alt` shape uses `--wp--custom--semantic--on-accent`. Anything drawn on the fixed artwork colors (coral `#DB7054`, sand `#F1C98E`) uses fixed ink `#19231E`, so it reads in every mode. New illustrations follow the same rules and the `digimia-` file prefix.
- **Photos:** CC0 only, sourced from the internet (never generated), credited as `* <file>: <credit>` in the `readme.txt` of whichever ships the file: the theme's, or Digimia Pro's for a photo in Pro's `patterns/images/`. A photo that moves between them takes its credit line along.
- **Photo sizes:** a bundled photo is at most twice the widest it is shown, allowing for the crop (measured across the pattern catalog and the demo pages at 1440px and 390px, 2026-11-16). Avatars are 160px square, enough for a 48px avatar on a 3× screen. Theme images have no `srcset`, so every device loads this one file.
- **Loading:** `inc/blocks.php` gives each bundled photo its `width` and `height` from the file, which WordPress needs before it adds `loading` and `fetchpriority`. Every image in a page's first top-level block (the hero) loads eagerly and its largest gets `fetchpriority="high"`; below the hero only the first counted image is eager (`wp_omit_loading_attr_threshold` is 1), so the rest wait until they near the screen. Before this, a Digimia page downloaded all its photos at once and a row of avatars in a hero pushed the hero photo into lazy loading.

## 7. Copy

- The placeholder text speaks to the niche the pattern was made for: a digital-goods store (templates, fonts, presets, courses, licenses) or, for SaaS and service sections, a product team (trials, plans, integrations). Product names stay generic ("our platform") so buyers can drop in their own.
- Prices and names are clearly placeholders.

## 7a. Pattern names

- Titles are in sentence case and say what the pattern does. They never say "Light", "Dark", or "Digimia", and never carry a number.
- Only generic types get a `Type:` prefix in the title: hero, pricing, stats, header, footer, menu.
- Slugs are `<type>-<what it is>`, and the file name equals the slug.
- Names describe the layout, not the surface. A Contrast version of a pattern is not a separate pattern: users apply the Contrast section style to it.
- Each pattern has one main category, plus a second only when it really fits.
- Renaming a slug means updating every `wp:pattern` reference, `templates/`, `parts/`, the docs, and saved database content, checked with a search before and after.

## 8. Section header layouts (only 2)

1. **Centered**: H2 and intro, centered within 720px.
2. **Split**: H2 on the left, intro or a "View all" link on the right, within the wide width.

No eyebrow or pill above the H2 (§4i-0). The library pass on 2026-11-14 removed them from every pattern and demo page.

## Rollout

1. **Done:** section styles in `styles/sections/*.json` and the Eyebrow style in `styles/blocks/paragraph/eyebrow.json`. Contrast and Brand token handling lives in `src/scss/_variables.scss`.
2. Apply the spec one category at a time (**Hero, Features, Pricing, Reviews, FAQ, CTA, Cards, Products/Store, Pages, Headers/Footers, Journal, Templates done**), with a review in the catalog after each: Hero → Features → Pricing → Reviews → FAQ → CTA → Cards → Products/Store → Pages → Headers/Footers → Journal. Templates and menus come last.
3. ~~Merge the duplicate "contrast" patterns~~ done 2026-11-02 (8 removed, 2 renamed).
4. Check each category with the 4 style variations (agency, creator, startup, studio) and at least 2 color variations.

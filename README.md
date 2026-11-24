# Digimia

![Digimia storefront preview](screenshot.png)

Digimia is a WordPress block theme for selling digital downloads with Easy Digital Downloads: templates, design kits, fonts, software, and other files people buy and download. Its default look is teal and lime, with four style variations, five more color presets, five font pairings, a dark mode, and right-to-left support with Arabic fonts.

## What is included

- 51 block patterns and 15 templates: a store home page, product pages, a product catalog, a shop with a sidebar, cart and checkout, confirmation, receipt, and customer account designs, and about, pricing, contact, and blog pages.
- A light/dark switch and a small set of editor enhancements.
- A welcome page under Appearance → Digimia that installs Easy Digital Downloads and links to help.
- Digimia Pro, a paid add-on sold separately, adds more home pages, business pages, product layouts, and patterns.

The EDD product grid requires Easy Digital Downloads. The theme does not replace EDD checkout, licensing, customer accounts, or order handling.

## Development

Use Yarn for JavaScript and Sass work:

```bash
yarn install --frozen-lockfile
yarn dev
yarn build
yarn translate:patterns
```

PHP lint and WordPress Coding Standards scripts are available through Composer after installing the development dependencies:

```bash
composer install
composer run lint
composer run wpcs:scan
```

See [`AGENTS.md`](AGENTS.md) and [`docs/ai/README.md`](docs/ai/README.md) for the repository map and contribution workflow.

## License

Digimia is distributed under GPL-3.0-or-later; see [`LICENSE`](LICENSE). Its pattern tool, `theme-utils.mjs`, adapts code from [Twenty Twenty-Five](https://github.com/WordPress/twentytwentyfive) (GPL-2.0-or-later); see [`NOTICE.md`](NOTICE.md).

Bundled fonts, photos, and other third-party assets keep their own licenses. See [`readme.txt`](readme.txt) for the current asset notices.

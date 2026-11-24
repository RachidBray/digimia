# Visual regression check

`yarn test:visual` opens the store pages in headless Chrome and tells you what broke or changed. Run it after a theme change, and every time EDD or one of its extensions updates.

## What it checks

Every page in `tests/visual/pages.mjs`, in light and dark mode, at 1440px and 390px (136 screenshots, about 3 minutes):

- **Problems (the run fails):** an HTTP error, a PHP warning, notice, or fatal error in the page, a JavaScript error from the site's own scripts, the page scrolling sideways, a loaded image that renders at 0×0 (for example an SVG logo without a width), a missing expected element (`expect`), or a signed-in page that is not signed in.
- **Changes (reported, not failed):** each full-page screenshot is compared with the baseline. A screenshot that changed by more than 0.05% of its pixels, or changed height, gets a `.diff.png` with the changed pixels in red over a faded copy of the new screenshot.

Pages covered: the SaaS home (front page), the store home, the plugin shop home, the courses home, the books home, the fitness home, contact, changelog, pricing, features, integrations, how it works, about, team, careers, services, shop with sidebar, portfolio, case study, coming soon, shop, the four product templates (Showcase, Banner, Guide, Classic), a licensed product with license descriptions, checkout (with an item in the cart), login, register, journal, and, signed in: account, a subscription's details, a license's site management, and the review form.

## Usage

```bash
yarn test:visual                        # check against the baseline
yarn test:visual --update-baseline      # accept this run as the new baseline
yarn test:visual --only=checkout,account
```

Results go to `tests/visual/output/latest/` (screenshots, diffs, `report.json`); the baseline is `tests/visual/baseline/`. Both are gitignored: screenshots depend on each machine's content and fonts.

A typical update check:

1. Before updating EDD or an extension: `yarn test:visual --update-baseline`.
2. Update.
3. `yarn test:visual`, then open the `.diff.png` files it lists. Fix what broke; when the changes are intended, update the baseline.

## Settings

From the environment or `.env` (gitignored, never printed by the script):

| Variable | Use |
| --- | --- |
| `WP_API_URL` | Site URL. Default `https://edd.local`. |
| `VISUAL_TEST_USERNAME`, `VISUAL_TEST_PASSWORD` | A test **customer** account (not an admin) for the signed-in pages. Without them, those pages are skipped. |
| `VISUAL_TEST_COOKIE` | Instead of a password: a WordPress auth cookie `name=value`, for scripted runs (for example from `wp eval` with `wp_generate_auth_cookie()`). |
| `CHROME_PATH` | Chrome or Chromium, when it is not in a default location. |

`--baseline=rtl` (or any name) compares with, and `--update-baseline` saves to, `tests/visual/baseline-rtl/` instead of the main baseline. Use it for an Arabic copy of the demo, so right-to-left screenshots never replace the English ones.

TLS certificate checks are turned off only for `*.local` hosts (LocalWP's self-signed certificates).

## Demo content it expects

The paths in `pages.mjs` match the demo store: the products `icon-library-essentials` (Showcase, with reviews, also put in the cart), `saas-dashboard-ui-kit` (Banner), `startup-pitch-deck-template` (Guide), `agency-proposal-kit` (Classic), and `formwise-pro` (licensed, yearly, with license descriptions); and a test customer who owns a Formwise Pro license with sites and a subscription. No database IDs are written down: `{download:slug}` in a path is looked up through the REST API, and the license and subscription pages are reached by following links from the account page (`follow`). So the suite runs on any site built from the demo data, for example a fresh copy checked against edd.local's baseline.

## How it stays stable

Screenshots must not change between two runs of the same site, or real changes drown in noise. The script:

- turns off animations and transitions;
- loads every image before the screenshot: lazy images become eager, with WordPress's `sizes="auto"` replaced by the image's laid-out width (the file the browser would pick), and waits for each image's pixels and for the network to go quiet;
- takes each full-page screenshot twice and keeps the second (the first lays the page out at full height, which can start more image loads);
- removes content that changes on every load before the screenshot (`mask` in `pages.mjs`: PayPal's and Google Pay's frames on the checkout) and clears password fields (EDD's register form generates a random password).

Two runs in a row report 0 changes; a 0.75rem spacing change in the license cards shows on all four account screenshots.

## Adding a page

Add an entry to `pages.mjs`: `name`, `path`, and the selectors it must contain in `expect`. Use `auth: true` for a signed-in page, `before` for pages to load first (for example an add-to-cart URL), and `mask` for third-party or random content. Then run `yarn test:visual --only=<name> --update-baseline`.

## Requirements

Node 22 or later and Chrome or Chromium. No npm dependencies: the script drives Chrome over the DevTools protocol and compares images in a page canvas. `tests/` is left out of the theme zip (`.gitattributes`).

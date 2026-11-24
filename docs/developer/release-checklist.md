# Release checklist

What to do before releasing the free theme on WordPress.org.

## Open before the first release

- **Check every external link** once the pages exist:
  - Welcome page (`welcome_links()` in `inc/admin-welcome.php`): the Pro product page (`https://addictedtoweb.com/downloads/digimia-pro/`), the help center and its Digimia section (`https://support.addictedtoweb.com/hc/en-us`), custom work (`https://addictedtoweb.com/contact-me/`), and the WordPress.org review form (it works once the theme is listed).
  - Theme header in `style.css` and `readme.txt`: Theme URI (the product page `https://addictedtoweb.com/downloads/digimia-wordpress/`, which WordPress.org reviewers open) and Author URI.
  - Add a "Preview demo" link to the welcome page once the demo is public.

## Every release

- **Theme Check** on a clean WordPress with the `git archive` zip of the theme: no required or warning items.
- **PHP 7.4:** `vendor/bin/phpcs --standard=PHPCompatibilityWP --runtime-set testVersion 7.4- functions.php index.php inc blocks`. GitHub runs it on every push, so the last run on `main` should be green.
- **Coding standards:** `composer run wpcs:scan`.
- **No PHP notices** on any page, signed in and out, with EDD on and off, and with Digimia Pro on and off. Two messages are expected with EDD off on a site with the demo content, and neither comes from Digimia: `map_meta_cap` notices from the dashboard's Recent Comments box (comments left on products, whose post type is gone), and an Action Scheduler "invalid_schedule" cron line EDD leaves behind.
- **Patterns:** every pattern parses without invalid blocks in the editor, with Pro active.
- **Translations:** `wp i18n make-pot` runs without warnings for the theme (`digimia`).
- **Visual check:** `yarn test:visual` with Pro active matches the baseline, and the free pages match it with Pro switched off (see `visual-regression.md`).
- **Image credits:** every photo in `patterns/images/` is credited in `readme.txt`, with no credit left for a file that moved or was removed.
- **Theme zip** (`git archive`): leaves out `tests/` and `docs/` (`.gitattributes`).
- **Version and changelog:** raise `Version` in `style.css`, and add a `= <version> =` entry to the changelog in `readme.txt`.
- **GitHub release:** after merging into `main`, tag the commit (`git tag v<version>`, then `git push origin v<version>`). The tag starts `.github/workflows/create-release.yml`, which publishes the theme zip; a push to `main` alone publishes nothing.

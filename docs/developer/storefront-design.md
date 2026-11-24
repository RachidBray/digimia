# Digimia storefront design

Digimia's default palette uses white surfaces, deep teal, and a lime accent. Each palette's dark values live in `settings.custom.color.dark` and are mapped in `src/scss/_variables.scss` (see `docs/ai/design-system.md` §3a); patterns should consume the existing semantic and preset tokens rather than add local color values.

## Homepages

The theme has no `front-page.html`: Settings › Reading picks a static page, which uses the "Page (no title)" template, and the page holds sections from a homepage starter pattern. Each homepage targets one kind of seller and shares the rest of the site (shop, product pages, checkout, account, blog):

| Pattern | Homepage | Built from |
| --- | --- | --- |
| `page-home-saas` | SaaS & Software (the demo's front page) | `hero-saas-glow`, `feature-ui-rows`, `feature-bento-automation`, `feature-steps-panel`, `pricing-plans-brand`, `faq-split`, `cta-brand-panel`, plus reviews. The earlier SaaS home's sections stay in the theme as patterns: `hero-saas-dashboard`, `stats-split-cards`, `feature-comparison`, `feature-boxes-actions`, `feature-how-it-works`, `feature-product-tabs`, `feature-integrations`, `review-grid`, `pricing-billing-switch`, `faq-accordion`, `cta-text-actions` |
| `page-home-plugins` | Plugin & Theme Shop | `hero-plugin-shop`, `product-catalog-tabs`, `feature-developer-code`, `product-release-notes`, plus principles beside a performance card, All Access pricing (Yearly / Lifetime tabs, featured plan on Brand), reviews, an FAQ with help channels, and a closing Brand card with an All Access library visual (`digimia-ui-access.svg`, drawn like the hero's plugin cards, kept light with `digimia-visual-light`). The catalog tabs read the `plugins`, `themes`, and `bundles` download categories |
| `page-home-courses` | Courses & Coaching | `hero-course-instructor`, `feature-curriculum`, `feature-instructor`, `pricing-coaching-sessions`, plus `product-catalog-tabs` relabelled Courses / Coaching / Resources (download categories `courses`, `coaching`, `resources`), steps, reviews, a free mini-course offer, FAQ, and a call to action with course wording |
| `page-home-books` | Books & Writers | `hero-book-launch`, `product-book-series`, `feature-book-excerpt`, `review-press-quotes`, plus `product-catalog-tabs` relabelled Ebooks / Audiobooks / Box sets (download categories `ebooks`, `audiobooks`, `box-sets`), `feature-instructor` as the author bio, `hero-cover-actions` as a newsletter band, FAQ, and a call to action with book wording |
| `page-home-fitness` | Health & Fitness | `hero-fitness-photo`, `feature-fitness-pace`, `feature-program-tiles`, `feature-fitness-tracker`, `team-coaches-mono`, `review-accent-quote`, `pricing-membership-accent`, `faq-accent-photo`, and a closing Brand card with a photo (`cta-split-band` stays in the library). The earlier fitness home's sections stay as patterns: `hero-cover-glass`, `feature-goal-cards`, `product-catalog-tabs`, `feature-weekly-plan`, `feature-instructor`, `review-results`, `pricing-billing-switch`, `faq-accordion`, `cta-text-actions` |
| `page-home` | Digital Products Store | `hero-editorial-collection`, `feature-bento-cards`, `product-editorial-shelf`, `feature-maker-story`, an FAQ in the books layout with store questions (Soft), `cta-closing-note` (plain, so the backgrounds alternate) |

A homepage pattern references the sections made for its niche and copies shared sections with its own wording (same layout), so the shared section patterns keep their store copy. Design rules: `docs/ai/design-system.md` §4i-0 (rules for every home), §4i (SaaS) and §4j (plugin shop), §4k (courses), §4l (books), and §4m (fitness).

On the demo site every homepage is a page (`/` for SaaS, `/home-digital-products/` for the store, `/home-plugins/` for the plugin shop, `/home-courses/` for courses, `/home-books/` for books, `/home-fitness/` for fitness), listed under a **Home** dropdown in the header menu. That menu is demo content in the database, not part of the theme. The header menu groups the inner pages: Home ▾, Product ▾ (Features, Integrations, How it works, Pricing, Changelog), Shop ▾ (All products, Shop with sidebar, a category page, and the four product layouts), Pages ▾ (About, Team, Careers, Services, Portfolio, Case study, Journal, Support, Licenses, Coming soon, 404 page), and Contact. The demo's footer part is saved in the database as the `footer-store-columns` pattern with Product, Company, and Resources link columns. Every placeholder link (`#`) on the demo pages points at a real page or product; the theme patterns keep `#` because buyers' sites do not have these pages. All of this demo content is built from the page patterns plus the demo's links, so the design stays in the theme.

## Inner pages

| Pattern | Page | Notes |
| --- | --- | --- |
| `page-contact` | Contact | `hero-contact` plus FAQ. The form card holds a dashed placeholder: replace it with the block from any form plugin (the demo uses Contact Form 7). The theme styles plain form fields and a submit input inside `.digimia-message-card`; it does not ship a form. |
| `page-changelog` | Changelog | Intro with subscribe links, then release rows (`digimia-release`). |
| `page-features-saas` | Features (software) | Page header, product tour, alternating rows, feature boxes, reviews, call to action. `page-features` is the store version. |
| `page-integrations` | Integrations | Page header, integration directory, an API section with a code example, call to action. |
| `page-how-it-works` | How it works | Page header, steps timeline, before and after comparison, FAQ, call to action. |
| `page-team` | Team | Page header, team grid, values, hiring call to action. |
| `page-careers` | Careers | Page header, benefits, open positions, open application call to action. Job listings are static content; a job board needs a plugin. |
| `page-services` | Services | Page header, service cards, working process (steps timeline), call to action. |
| `page-shop-sidebar` | Shop with sidebar | Page header and `product-grid-sidebar`. The theme's **Product category** and **Product tag** templates (`templates/taxonomy-download_category.html`, `taxonomy-download_tag.html`) use `template-shop-sidebar`; to give the main shop the sidebar too, put it in the **Shop** template (Site Editor › Templates). The demo's copies only add the help link. |
| `page-portfolio` | Portfolio | Page header, project grid, call to action. Projects are static content; a portfolio post type would belong in a plugin. |
| `page-case-study` | Case study | Case study hero, challenge, solution, results, quote, call to action. |
| `page-coming-soon` | Coming soon | Full-screen photo page. Choose the **Page (Blank, No Header or Footer)** template. |
| `page-pricing-saas` | Pricing (software) | Monthly / yearly plans, comparison table, FAQ, call to action. `page-pricing` is the store version. |

Demo pages (database): `/contact/`, `/changelog/`, `/features/`, `/integrations/`, `/how-it-works/`, `/team/`, `/careers/`, `/services/`, `/shop-sidebar/`, `/portfolio/`, `/case-study/`, `/coming-soon/`, and `/pricing/` (the software version, to match the SaaS front page).

The `edd/downloads` and `edd/buy-button` styles are compiled from `src/scss/blocks/_edd-*.scss`. `functions.php` maps both `core-*` and `edd-*` source names to their block names when enqueuing the compiled stylesheet.

Easy Digital Downloads must be active for EDD blocks to render products and purchase links. The theme adds presentation only; it does not alter orders, licensing, or checkout behavior. The FSE download archive and single-download block templates compose EDD blocks; there are no legacy `edd_templates/` PHP overrides.

The theme is distributed under GPL-3.0-or-later. `NOTICE.md` credits the third-party code it adapts, and `readme.txt` lists every bundled font, icon set, and photo with its license. Check a new asset's source and license before adding it, and credit it in the `readme.txt` of the package that ships it.

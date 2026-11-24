# Welcome page

Appearance → Digimia (`themes.php?page=digimia`), built by `inc/admin-welcome.php` with styles from `src/scss/admin/welcome.scss` (`assets/styles/admin-welcome.css`, loaded on this page only). It holds no settings: design choices live in the Site Editor.

It keeps the admin's type, spacing, and white cards, in Digimia's default colors rather than the user's admin color scheme: pill buttons and links in pine, icon tiles in soft lime, and the Pro box as a Brand card (white on pine, lime icons and button). The theme's tokens don't load in the admin, so the stylesheet repeats the default palette's values.

## What it shows

1. **Welcome:** version, a short description, a Quick start guide button (the help center), and `screenshot.png`.
2. **Set up your store:** only while Easy Digital Downloads is not active. Offers "Activate" when EDD (free or Pro) is installed, otherwise "Install" (WordPress's own one-click installer, with its nonce). Users without the capability see the text only.
3. **Digimia Pro:** what Pro adds, or Pro's own details while it is active (see the filter below).
4. **Quick links:** Site Editor, Store settings (while EDD is active), Documentation, Get support.
5. **Need something custom?** links to the custom work contact page.
6. **Enjoying Digimia?** links to the WordPress.org review form.

The addresses are in `welcome_links()`. Documentation and support both go to the help center.

After the theme is activated, the next admin page shows one notice linking here (a one-time message, then never again). Other plugins' notices appear above the cards (`wp-header-end`).

## The Pro box: `digimia_welcome_pro`

The theme renders the box from this filter, so Digimia Pro supplies data, not markup:

```php
add_filter( 'digimia_welcome_pro', function (): array {
	return array(
		'active'      => true,
		'title'       => 'Digimia Pro',
		'description' => '…',
		'features'    => array(
			array( 'icon' => 'storefront', 'title' => '…', 'text' => '…' ),
		),
		'button'      => array( 'label' => '…', 'url' => admin_url( '…' ), 'external' => false ),
		'secondary'   => array( 'label' => 'Manage license', 'url' => admin_url( 'plugins.php' ) ),
		'note'        => '',
	);
} );
```

Icons are slugs from the theme's set (`assets/icons/`). Missing keys fall back to the theme's default box. `secondary` is an optional outline button after the first.

## WordPress.org rules it follows

- A sub-page under Appearance, not a top-level menu, in the admin's own look (core buttons, admin colors).
- Styles only on this page; no activation redirect or popup; the notice is one-time.
- No demo import and no requests to other sites; links only.
- It recommends only Easy Digital Downloads, which is hosted on WordPress.org. Paid EDD extensions may be recommended only from Pro's side of the box.

Later: a "Preview demo" link once the demo is public.

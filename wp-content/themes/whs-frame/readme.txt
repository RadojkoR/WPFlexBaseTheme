=== WHS Frame ===

Contributors: webhubstudio
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.4.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tags: full-width-template, custom-menu, custom-logo, editor-style, featured-images, threaded-comments, translation-ready

A lightweight, flexible WordPress theme built for performance and compatibility with Elementor and Bricks Builder.

== Description ==

WHS Frame is a modern, flexible WordPress theme designed for flexibility and ease of use. Built with vanilla CSS and JavaScript (no framework dependency), it offers a customizable top bar, sticky/transparent header, a full settings panel built with React, a designed single-post blog layout with comments, an optional sidebar, and compatibility with the Elementor and Bricks page builders.

= Features =

* Top bar with email, phone, custom text and social icon columns
* Sticky header (always, on scroll-up, or off) and transparent header mode
* A dedicated "WHS Frame Settings" panel (Appearance menu) covering colors, typography, header, footer, top bar and social settings
* Per-post editor panel: sidebar, content width, disable title/featured image/header/footer, transparent header override
* Blog post template with author/date/reading-time meta, tags, author bio, prev/next navigation and a styled comments section
* Optional Blog Sidebar widget area (left or right, site-wide or per post)
* Elementor and Bricks Builder theme-locations integration for custom headers/footers
* Self-hosted Font Awesome 6 icon set and 6 self-hosted Google Fonts families — no external requests
* Polylang and WPML language-switcher support in the header

== Installation ==

1. In your WordPress admin, go to Appearance → Themes → Add New → Upload Theme.
2. Choose the theme zip file and click Install Now.
3. Activate the theme.
4. Open the new "WHS Frame Settings" item in the admin menu to configure colors, header, footer and social links.

== Frequently Asked Questions ==

= Does this theme require Elementor or Bricks? =

No. The theme works fully on its own with the default WordPress block editor. Elementor and Bricks support is optional — if either plugin is active, the theme integrates with their Theme Builder / theme-locations features for custom headers and footers.

= Where do I add widgets to the sidebar? =

Appearance → Widgets → "Blog Sidebar". The sidebar only appears on the front end once it has at least one widget, and only on posts/pages where a sidebar position (Left or Right) is selected — either site-wide in the Customizer or per post/page in the editor's "WHS Frame Settings" panel.

= Can I use my own fonts instead of the bundled ones? =

The bundled font list (Inter, Poppins, Montserrat, Playfair Display, Merriweather, Lora, plus the system default) covers common sans-serif/serif choices and ships fully self-hosted, with no calls to any external font service. Selecting "Theme Default (System)" uses the visitor's own device fonts.

== Changelog ==

= 1.4.6 =
* Theme Check pass: compressed screenshot (1.4.6 ships screenshot.jpg at ~68KB instead of a 1MB PNG), added blog archive list with pagination to index.php, styled the WordPress core classes (.screen-reader-text, .sticky, .bypostauthor, .wp-caption, .gallery-caption), added wp-block-styles support, bumped Tested up to 7.0.

= 1.4.5 =
* Added readme.txt and languages/whs-frame.pot (WordPress.org submission requirements).

= 1.4.4 =
* Self-hosted all Google Fonts (previously loaded from fonts.googleapis.com) — six curated families (Inter, Poppins, Montserrat, Playfair Display, Merriweather, Lora), each shipped with the weights the family actually offers.
* Added missing direct-access guards to header.php, footer.php and index.php.

= 1.4.0 – 1.4.3 =
* Added the "WHS Frame Settings" per-post editor panel: sidebar position, content layout (boxed / full width / custom width %), disable title/featured image/header/footer, transparent header override.
* Added the Blog Sidebar widget area with a two-column layout, reversible left/right.
* Various comment-form and content-layout centering fixes.

= 1.3.0 – 1.3.7 =
* Added the single blog post template: category badges, author/date/reading-time meta, featured image, tags, author bio box, previous/next navigation, and a fully styled comments section (list, threaded replies, reply form).
* Fixed a sitewide bug where the sticky/transparent header had no reserved space in the page layout and could overlap page content.
* Enabled the WordPress core comment-reply script so "Reply" links work.

= 1.2.1 =
* Removed the incomplete Builder/Pro upsell system ahead of public release — the theme is fully free with no locked features.

= 1.2.0 and earlier =
* Initial theme build: header, footer, top bar, sticky/transparent header, React settings panel, Customizer integration, Elementor/Bricks compatibility, Font Awesome icon set, Google Fonts loader, Polylang/WPML language switcher.

== Copyright ==

WHS Frame WordPress Theme, Copyright 2026 Web Hub Studio.
WHS Frame is distributed under the terms of the GNU General Public License v2 or later.

This theme bundles the following third-party resources:

* Font Awesome Free 6.6.0
  License: Icons — CC BY 4.0 License; Fonts — SIL OFL 1.1 License; Code — MIT License
  Source: https://fontawesome.com/

* Google Fonts: Inter, Poppins, Montserrat, Playfair Display, Merriweather, Lora
  License: SIL Open Font License, 1.1
  Source: https://fonts.google.com/

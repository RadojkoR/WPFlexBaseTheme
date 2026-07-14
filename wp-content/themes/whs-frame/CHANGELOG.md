# Changelog

All notable changes to the WHS Frame WordPress Theme will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.4.1] - 2026-07-14

### Added
- **Content Layout** control in the WHS Frame Settings editor panel (matches
  the Astra field of the same name): Customizer Setting / Boxed / Content
  Boxed / Full Width Contained / Full Width Stretched, per post/page.
  - New `_whs_frame_content_layout` post meta, sanitized to the 4 known
    values (`whs_frame_sanitize_content_layout()` in `inc/post-settings.php`)
  - A `body_class` filter adds `whs-frame-layout--{mode}` when set, and
    `single.css` implements the 4 modes by adjusting `.whs-frame-post`'s
    max-width/padding (Boxed also gets a card background + shadow)
  - Scoped to the post/page content area (not header/footer) — a full
    site-wide "Boxed" mode wrapping header+content+footer together, like
    Astra's most dramatic variant, was out of scope for this pass

### Changed
- Styled the "WHS Frame Settings" editor panel — new
  `assets/admin/post-settings.css` gives it proper spacing between
  checkboxes, a small-caps "Disable Sections" group heading (matching
  Astra's layout), and consistent WP-admin-style field labels. Previously
  unstyled, the controls rendered cramped together with no visual grouping.
- All three section labels ("Content Layout", "Disable Sections",
  "Transparent Header") set to font-weight 700; color left unchanged.

### Note
- Astra's "Sidebar" field (Left/Right/No Sidebar) was intentionally not
  added — it requires a real widget-area system (`register_sidebar()`,
  two-column templates) that doesn't exist in this theme yet. Deferred to a
  future session so it isn't half-built.

## [1.4.0] - 2026-07-14

### Added
- **Per-post "WHS Frame Settings" panel** in the block editor sidebar
  (`inc/post-settings.php` + `assets/admin/post-settings.js`), similar to
  Astra's per-post settings panel:
  - Disable Title, Disable Featured Image, Disable Header, Disable Footer
    (checkboxes)
  - Transparent Header (Customizer Setting / Enable / Disable) — overrides
    the site-wide Customizer default for that specific post/page
  - Implemented with `register_post_meta()` (5 fields, `show_in_rest`) and a
    `PluginDocumentSettingPanel` registered via `wp.plugins.registerPlugin`
  - `single.php` re-gained a featured image block (width-contained to the
    76ch content column, 420px max-height), now shown by default and
    controllable per post via the new panel
  - `whs_frame_header_render()`, `whs_frame_header_spacer_render()` and
    `whs_frame_default_footer_render()` (`inc/header-builder.php`) all
    respect the new `_whs_frame_disable_header` / `_whs_frame_disable_footer`
    / `_whs_frame_transparent_header` post meta via two new helpers,
    `whs_frame_post_disabled()` and `whs_frame_get_transparent_header()`

## [1.3.7] - 2026-07-14

### Removed
- Featured image hero block removed from `single.php` for good (was briefly
  re-added and made width-contained in this session, then removed again
  after comparing against Astra: that theme doesn't render a dedicated
  featured-image block on this post either — it just renders `the_content()`
  as written, so the "first image" is whatever the author put first in the
  post body). Matches that behavior now: no special image treatment, the
  post content renders exactly as authored.

## [1.3.6] - 2026-07-14

### Removed
- Featured image block removed from `single.php` (and its CSS in
  `single.css`) — not wanted on the single post view for now.

## [1.3.5] - 2026-07-14

### Changed
- Comment form title: WP core default "Leave a Reply" → "Leave a Comment"
  (matches common theme convention, e.g. Astra) via a `title_reply` arg to
  `comment_form()` in `comments.php`. The contextual "Leave a Reply to
  %s" title (shown when actually replying to a specific comment) is
  unchanged — that one is informative, not the generic default.
- "Cancel reply" link: previously unstyled, sitting directly against the
  form title with no visual separation. Now a pill-style outlined button
  with its own spacing (`#cancel-comment-reply-link`), and
  `.comment-reply-title` uses flex + gap so the title and the cancel
  control don't crowd each other.

## [1.3.4] - 2026-07-14

### Changed
- Comment form: Name / Email / Website now sit in one row (3 columns) on
  desktop (≥641px), instead of stacking full-width. Implemented with an
  unnamed CSS grid on `#commentform` — those three fields are consecutive
  siblings in WP core's `comment_form()` output, so they fall into the grid's
  columns automatically while every other field (comment textarea, cookies
  consent, submit button) explicitly spans the full width.

## [1.3.3] - 2026-07-14

### Fixed
- Clicking "Reply" on a comment now actually moves the comment form under
  that comment, as expected. The theme never enqueued WordPress core's
  `comment-reply` script — without it, the reply links had no JS behind
  them. Enqueued conditionally in `inc/enqueue.php`
  (`is_singular() && comments_open() && get_option( 'thread_comments' )`),
  matching core theme conventions.

## [1.3.2] - 2026-07-14

### Note
- Guest commenting works as intended without an account (e.g. Astra-style):
  controlled entirely by the WordPress core `comment_registration` site
  option (Settings → Discussion), not a theme setting — the theme just calls
  the standard `comment_form()`, which already respects it.

## [1.3.1] - 2026-07-14

### Changed
- `single.css`: increased `.whs-frame-post` top padding (2.5rem/1.5rem →
  10rem/8rem desktop/mobile) so post title/category clear the topbar +
  transparent/sticky header, which intentionally has no reserved spacer
  (floats over content by design).

## [1.3.0] - 2026-07-14

### Added
- **Single post template** (`single.php`) — the theme finally has a designed
  blog post layout: category badges, title, author avatar/date/reading-time/
  comment-count meta bar, featured image, prose-styled content (headings,
  blockquotes, code, tables), tag list, author bio box and prev/next post
  navigation. Styled in `assets/css/single.css` using the theme's CSS
  variable system, so it follows the active preset/brand colors.
- Comments are now actually displayed: `single.php` calls
  `comments_template()` (the `comments.php` template existed since 1.0.9 but
  no blog template ever invoked it), with full styling for the comment list,
  threaded replies and the reply form.
- `single.css` loads on all singular content (`is_singular()`), so comments
  rendered by the Full Width / Gutenberg page templates are styled too.

### Fixed
- **Sticky header no longer overlaps page content.** The
  `#whs-frame-header-spacer` CSS rule existed since 1.0.0 but no PHP or JS
  ever rendered that element, so a fixed (sticky) header covered the top of
  every page. A renderer-agnostic spacer is now output on
  `whs_frame_after_header` (covers default, Elementor and Bricks headers)
  and sized live by `sticky.js` via ResizeObserver + load/resize listeners.
  Transparent headers intentionally keep the spacer at 0 height — they are
  designed to float over hero content.

## [1.2.1] - 2026-07-14

### Changed
- **Theme renamed from FlexBase to WHS Frame** (`whs-frame` slug): all function
  prefixes (`whs_frame_*`), constants (`WHS_FRAME_*`), CSS classes (`.whs-frame-*`),
  the text domain, the REST namespace (`whs-frame/v1`), the settings option
  (`whs_frame_settings`) and the admin menu ("WHS Frame Settings") were updated.

### Removed
- **Builder Integration (Pro)** and the whole premium gate, ahead of the
  WordPress.org theme review (no incomplete/non-functional Pro upsell allowed
  without a real companion product): the "Builder" settings tab, the
  `whs-frame/v1/builder-template` REST endpoint (`inc/builder.php`), the
  `whs_frame_is_premium()` / `WHS_FRAME_PREMIUM` gate, the Elementor-template
  render branches for Top Bar/Header/Footer, their `*_elementor_template`
  theme_mods and Customizer control, and all related admin JS/CSS.
- Everything the theme does is free again; no premium track remains.

## [1.2.0] - 2026-07-03

### Added
- **Builder Integration (Pro)** — replace the default Top Bar, Header or Footer
  with an Elementor template (works with free Elementor):
  - `whs_frame_is_premium()` gate — unlocked via the `whs_frame_premium` filter
    (future WHS Frame Pro companion plugin) or the `WHS_FRAME_PREMIUM` dev constant.
  - New "Builder" tab in the settings panel: template selects for all three slots,
    "Create New" (one click creates an Elementor section template via
    `POST whs-frame/v1/builder-template` and opens the Elementor editor) and
    "Edit in Elementor" buttons. Locked state shows a Pro upsell card and the
    tab carries a PRO badge.
  - Top bar template render keeps the `#whs-frame-topbar` wrapper so sticky offset
    logic continues to work; header template render keeps sticky/transparent.
- Everything else in the theme remains free.

### Changed
- "Elementor Header Template" select moved from the Header tab to the Builder tab
  and is now a Pro feature (render falls back to the default header without Pro).

## [1.1.4] - 2026-07-03

### Added
- Checkmark badge (✓) on the active preset card in the Themes tab.

## [1.1.3] - 2026-07-03

### Added
- Themes tab auto-detects the active preset by comparing current settings against
  each preset (survives reloads; clears when any color is customized).
- Presets now set the login/signup transparency flags explicitly (outline login,
  filled signup) so applying a preset always yields a consistent look.

### Changed
- Fresh-install defaults now exactly match the Ocean preset (4 login/signup button
  colors aligned; signup hover background no longer transparent by default).

## [1.1.2] - 2026-07-03

### Changed
- Buttons tab layout: "Button Style" moved to a General section; Login/Signup
  styling sections render only while the matching Enable toggle is checked and
  live inside their button's section.

## [1.1.1] - 2026-07-03

### Changed
- "Header & Nav Colors", "Nav Typography" and "Transparent Header Colors" moved
  from the Navigation tab into the Header tab; transparent colors show only when
  Transparent Header is enabled.
- Navigation tab renamed to "Buttons" (Login/Signup + Language Switcher only).

## [1.1.0] - 2026-07-03

### Added
- Customizer structural settings exposed in the WHS Frame Settings panel via
  `whs_frame_mirror_fields()` — REST reads/writes the same theme_mods, keeping the
  Customizer and the panel in sync (topbar enable/hide/dismiss/column types,
  sticky mode, transparent header, mobile menu logo, Elementor header template,
  header logo, footer logo).
- New "Header" tab in the settings panel.
- `MediaField` React component (WordPress media library picker with preview).
- Top Bar tab "Structure" section; Footer tab logo picker.

## [1.0.9] - 2026-07-03

### Security
- Font Awesome 6.6.0 fully self-hosted (CSS + webfonts) — external CDN dependency
  and SRI filter removed on both frontend and admin.

### Added
- `comments.php` template (page templates call `comments_template()`).
- Top bar dismiss state persisted in `localStorage`.
- `whs_frame_css_color()` helper — returns a valid hex, `transparent`, or the
  default; prevents empty CSS custom-property values.

### Fixed
- Language switcher now respects its Enable toggle.
- Login/Logout/Signup buttons fall back to `wp_login_url()` / `wp_logout_url()` /
  `wp_registration_url()` when their URL fields are empty.
- Duplicate `nav_signup_button_hover_text_color` keys removed from all presets
  (caused invisible hover text).
- Topbar custom text, footer address and copyright sanitized with `wp_kses_post`
  (keeps safe HTML and the line breaks `nl2br()` relies on).
- Elementor template dropdown limited to header-relevant template types.
- Core `custom_logo` Customizer setting no longer re-registered (restores
  postMessage transport and selective refresh).
- Dead code removed from the WPML language switcher branch.

### Removed
- Temporary `whs_frame_reset_settings_once()` function that wiped saved settings.
- `elementor-icons` (eicons) dequeue that broke Elementor frontend icons.

## [1.0.0] - 2026-05-01

### Added

#### Core Features
- **Top Bar Component** — Fully responsive top bar with 3-column layout (left, center, right)
  - Dismissible option with smooth animation
  - Support for email, phone, custom text, and social icons in each column
  - Mobile collapse (hide on small screens)
  - Font Awesome 6 icon integration
  - Customizable colors via admin settings

- **Sticky Header System** — Intelligent sticky header modes
  - Three modes: `none` (static), `always` (fixed), `scroll_up` (appear on scroll up)
  - Transparent-to-solid header transition on scroll
  - Automatic topbar offset calculation
  - ResizeObserver for dynamic height adjustments
  - Smooth CSS animations

- **Transparent Header** — Optional transparent header before scroll
  - Separate color settings for transparent state
  - Smooth color transition to solid on scroll
  - Full customization via Customizer

- **Responsive Header & Navigation**
  - Desktop navigation with hover states
  - Full-screen mobile menu with hamburger toggle
  - Mobile menu logo option
  - Header action buttons: Login, Signup, Language Switcher
  - BEM-compliant CSS classes for styling flexibility

- **Login & Signup Buttons**
  - Configurable button labels and URLs
  - Link or button display style
  - Comprehensive button styling controls:
    - Background, text, and border colors (solid or transparent)
    - Border width and radius
    - Width, height, padding customization
    - Independent hover state colors
  - Admin Settings panel for easy configuration

- **Language Switcher**
  - Optional in-header language selector
  - Flag icons support
  - Display language name and/or code
  - Compatible with Polylang and WPML

- **Default Footer** — Responsive 3-column footer
  - Logo (with fallback to header logo or site name)
  - Address, email, and phone contact information
  - Footer navigation menu
  - Social media icons
  - Copyright text with auto-generated year
  - Customizable colors and links

#### Admin Settings Panel
- **React-based Admin Interface** — Modern settings dashboard
  - Tab-based organization (General, Top Bar, Navigation, Footer, Social)
  - Real-time settings save via REST API
  - Save status indicators (success/error)
  - Loading states with spinner animation
  - No page refresh required

- **General Tab Settings**
  - Brand color palette (primary, secondary, background, text)
  - Header background color
  - Typography: Base font and heading font selection
  - Container max-width (600–2560 px)

- **Top Bar Tab Settings**
  - Enable/disable top bar
  - Background, text, and link colors
  - Hide on mobile option
  - Dismissible toggle
  - Column configuration (left, center, right) with type selectors
  - Email, phone, and custom text fields per column
  - Social network URLs

- **Navigation Tab Settings**
  - Header text and hover colors
  - Navigation active/hover states
  - Text transform and font weight options
  - Transparent header color overrides
  - Login/Signup button configuration
  - Language switcher settings

- **Footer Tab Settings**
  - Background, text, and link colors
  - Address, email, phone fields
  - Copyright text (with default fallback)
  - Footer logo with fallback chain
  - Color settings for headings and addresses

- **Social Tab Settings**
  - Independent topbar and footer social URLs
  - 6 networks: Facebook, Instagram, Twitter/X, LinkedIn, YouTube, TikTok
  - Shared Font Awesome icon classes across theme

#### Builder Compatibility
- **Elementor Pro Theme Locations**
  - Custom header location (`whs_frame_header`)
  - Custom footer location (`whs_frame_footer`)
  - Automatic conflict detection and resolution
  - Body class indicators for conditional logic
  - Inline CSS normalization for seamless integration

- **Bricks Builder Theme Locations**
  - Custom header location support
  - Custom footer location support
  - Full responsive header included in Bricks template
  - Hamburger and mobile menu functionality

- **Gutenberg Compatibility** — Full support for WordPress block editor

#### Design System
- **CSS Custom Properties (Variables)**
  - Dynamic color palette: `--primary`, `--secondary`, `--background`, `--text`
  - Container width: `--container-width`
  - Footer-specific colors: `--footer-link-color`
  - Server-rendered from PHP settings
  - Allows external CSS to override all dynamic styles

- **Google Fonts Integration**
  - CSS2 API loader with preconnect optimization
  - 15+ fonts available: Inter, Roboto, Open Sans, Poppins, Playfair Display, Merriweather, and more
  - Configurable base and heading fonts
  - Fallback font stacks (sans-serif/serif)

- **Font Awesome 6** — Icon library integration
  - Free 6 CDN loaded automatically
  - Used for social icons throughout theme
  - Customizable icon classes via settings

#### Code Quality & Standards
- **WordPress Best Practices**
  - Security hardening: `defined('ABSPATH') || exit` on all PHP files
  - Nonce verification in all forms and AJAX handlers
  - Proper use of `sanitize_*` and `esc_*` WordPress functions
  - `wp_enqueue_scripts` for all CSS/JS dependencies
  - Action hooks for extensibility

- **Clean Architecture**
  - Modular file structure with organized includes
  - BEM CSS naming convention
  - No inline styles (all dynamic values as CSS variables)
  - DRY codebase with helper functions
  - Comprehensive documentation in CLAUDE.md

### Technical Details

#### File Structure
```
wp-content/themes/whs-frame/
├── style.css
├── functions.php
├── index.php
├── header.php
├── footer.php
├── inc/
│   ├── enqueue.php
│   ├── customizer.php
│   ├── topbar.php
│   ├── header-builder.php
│   ├── elementor-compatibility.php
│   ├── bricks-compatibility.php
│   ├── fonts.php
│   └── css-vars.php
├── template-parts/
│   ├── default-header.php
│   └── default-footer.php
├── assets/
│   ├── admin/
│   │   ├── admin-settings.js (React)
│   │   └── admin-settings.css
│   ├── css/
│   │   ├── main.css
│   │   ├── header.css
│   │   ├── topbar.css
│   │   ├── sticky.css
│   │   └── footer.css
│   └── js/
│       ├── main.js
│       ├── topbar.js
│       └── sticky.js
└── CLAUDE.md
```

#### Action Hooks
- `whs_frame_topbar` — Render top bar
- `whs_frame_before_header` — Before header render
- `whs_frame_header` — Header render (priority: 5 Elementor, 8 Bricks, 10 default)
- `whs_frame_after_header` — After header render
- `whs_frame_footer` — Footer render

#### Theme Modification/Customizer Settings
- 20+ theme modification keys for colors, fonts, layout, and component settings
- 4 registered navigation menu locations
- Custom logo support
- Customizer panels for Top Bar, Header, Footer, Typography, Colors, and Layout

#### Constants
- `WHS_FRAME_VERSION` — `'1.0.0'`
- `WHS_FRAME_DIR` — Theme directory path
- `WHS_FRAME_URI` — Theme directory URI
- `WHS_FRAME_INC` — Include directory path
- `WHS_FRAME_ASSETS` — Assets directory URI

### Compatibility

#### WordPress
- Minimum: **WordPress 6.0+**
- Full compatibility with Gutenberg block editor
- REST API for settings management

#### PHP
- Minimum: **PHP 7.4+**

#### Builders
- **Elementor Pro** — Full theme locations API support
- **Bricks Builder** — Theme locations and responsive header support

#### Plugins
- **Polylang** — Language switcher integration
- **WPML** — Language switcher support

#### Browsers
- Modern browsers (Chrome, Firefox, Safari, Edge)
- Mobile-first responsive design
- CSS Grid and Flexbox support required
- ES6+ JavaScript

### Notes

- Initial release with all core features built and tested
- Theme uses semantic versioning for future updates
- Documentation maintained in CLAUDE.md for development guidelines
- React admin settings panel requires WordPress 5.0+ for `wp.element` and `wp-api-fetch`
- Styling follows CLAUDE.md rule: no inline styles, all dynamic values as CSS variables for full CSS override capability

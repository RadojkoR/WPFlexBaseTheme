# FlexBase — WordPress Projects

## Jezik
- Sav kod, komentari u kodu, i tekstovi moraju biti na **Engleskom**
- Komunikacija sa mnom je na **Srpskom**

## Opšta pravila (važe za sve projekte)
- Uvek koristi WordPress funkcije (`sanitize_*`, `esc_*`, `wp_enqueue`, itd.)
- Zaštita od direktnog pristupa na svakom PHP fajlu: `defined('ABSPATH') || exit;`
- Nonce verifikacija u svim admin formama i AJAX pozivima
- No spaghetti code — clean, well-structured functions
- Follow WordPress coding standards
- Keep code DRY
- After each task review the code for bugs and better solutions


---

# PROJEKAT 1 — FlexBase WordPress Tema

## Lokacija
`wp-content/themes/flexbase/`

## Stack
- WordPress tema (PHP 7.4+)
- Vanilla CSS i JS (bez frameworka)
- Kompatibilnost sa Elementor Pro i Bricks Builder

## Kompletna struktura fajlova

```
wp-content/themes/flexbase/
├── style.css                           # Theme header (meta)
├── functions.php                       # Konstante, theme setup, nav menus, includes
├── index.php                           # Glavni template (blog loop)
├── header.php                          # Topbar + header action hooks
├── footer.php                          # Direktno uključuje default-footer.php
├── screenshot.png
├── inc/
│   ├── enqueue.php                     # wp_enqueue_scripts za sve CSS i JS
│   ├── customizer.php                  # Customizer panel sa 6 sekcija
│   ├── topbar.php                      # Top Bar render logika + Font Awesome ikone + responsive
│   ├── header-builder.php              # Default header render + Elementor template helper
│   ├── elementor-compatibility.php     # Puna Elementor Pro theme locations integracija
│   ├── bricks-compatibility.php        # Bricks Builder theme locations integracija
│   ├── fonts.php                       # Google Fonts CSS2 API loader, font stacks
│   └── css-vars.php                    # :root CSS custom properties (colors, sizes)
├── template-parts/
│   ├── default-header.php              # Responsive header: logo + nav + hamburger + mobile menu
│   └── default-footer.php              # Footer sa nav menijem i copyright-om
└── assets/
    ├── css/
    │   ├── main.css                    # Global reset, body, links, .flexbase-main
    │   ├── header.css                  # Header, hamburger, mobile menu, z-index layering
    │   ├── topbar.css                  # 3-col layout, social icons, responsive collapse
    │   ├── sticky.css                  # Sticky header modes, transparent transition
    │   └── footer.css                  # 3-col footer, responsive stack
    └── js/
        ├── main.js                     # Hamburger toggle, mobile menu
        ├── topbar.js                   # Dismiss animation
        └── sticky.js                   # Sticky modes, scroll behavior
```

---

## Konstante (functions.php)

| Konstanta | Vrednost |
|-----------|----------|
| `FLEXBASE_VERSION` | `'1.0.0'` |
| `FLEXBASE_DIR` | `get_template_directory()` |
| `FLEXBASE_URI` | `get_template_directory_uri()` |
| `FLEXBASE_INC` | `FLEXBASE_DIR . '/inc/'` |
| `FLEXBASE_ASSETS` | `FLEXBASE_URI . '/assets/'` |

---

## Action Hooks arhitektura

### header.php redosled pozivanja:
```
do_action('flexbase_topbar')
do_action('flexbase_before_header')
do_action('flexbase_header')
do_action('flexbase_after_header')
```

### Priority sistem za `flexbase_header`:
| Prioritet | Ko se izvršava | Fajl |
|-----------|---------------|------|
| 5 | Elementor render | elementor-compatibility.php |
| 8 | Bricks render | bricks-compatibility.php |
| 10 | Default PHP render | header-builder.php |

Ako Elementor ili Bricks renderuju, oni pozivaju `remove_action('flexbase_header', 'flexbase_header_render', 10)` da spreče dupli output.

### `flexbase_footer`:
Koristi se u compatibility fajlovima i `footer.php` za renderovanje footer-a sa podrškom za custom builder templates.

---

## Header Wrap

Svaki render (default, Elementor, Bricks) omotava output u:
```html
<div id="flexbase-header-wrap"
     class="flexbase-header-wrap [--sticky] [--transparent] [--elementor-location|--bricks-location]"
     data-sticky="none|always|scroll_up"
     [data-transparent="true"]>
  ...
</div>
```
Ovo omogućava da `sticky.js` i transparent header logika funkcionišu bez obzira ko renderuje header.

---

## Customizer Settings (theme mods)

### Panel: `flexbase_main_panel` — "FlexBase Theme"

#### Sekcija: Top Bar
| Setting | Tip | Default |
|---------|-----|---------|
| `flexbase_topbar_enable` | bool | `true` |
| `flexbase_topbar_bg_color` | hex | `#1e1e2e` |
| `flexbase_topbar_text_color` | hex | `#ffffff` |
| `flexbase_topbar_link_color` | hex | `#a5b4fc` |
| `flexbase_topbar_hide_mobile` | bool | `false` |
| `flexbase_topbar_dismissible` | bool | `false` |
| `flexbase_topbar_{left\|center\|right}_type` | select | `email\|none\|social_icons` (opcije: none, email, phone, email_phone, social_icons, custom_text) |
| `flexbase_topbar_{col}_{email\|phone\|text}` | text | `''` |
| `flexbase_topbar_social_{network}` | url | `''` (facebook, instagram, twitter, linkedin, youtube, tiktok) |
| `flexbase_social_{network}_icon` | text | FA class, npr. `fa-brands fa-facebook-f` — **deljeno** između topbar i footer |

#### Sekcija: Header
| Setting | Tip | Default |
|---------|-----|---------|
| `flexbase_header_bg_color` | hex | `#ffffff` |
| `flexbase_header_text_color` | hex | `#1e1e2e` |
| `flexbase_header_sticky` | select | `none` (opcije: none, always, scroll_up) |
| `flexbase_header_transparent` | bool | `false` |
| `custom_logo` | image | — (WordPress built-in) |
| `flexbase_header_elementor_template` | select | `''` (ID Elementor template) |
| `flexbase_mobile_menu_logo` | bool | `true` |

#### Sekcija: Footer
| Setting | Tip | Default |
|---------|-----|---------|
| `flexbase_footer_bg_color` | hex | `#ffffff` |
| `flexbase_footer_text_color` | hex | `#4b5563` |
| `flexbase_footer_logo` | attachment ID | `0` (fallback → header logo → site name) |
| `flexbase_footer_address` | textarea | `''` |
| `flexbase_footer_email` | email | `''` |
| `flexbase_footer_phone` | text | `''` |
| `flexbase_footer_copyright` | textarea | `''` (default: © Year Site Name) |
| `flexbase_footer_link_color` | hex | `#6b7280` (boja contact linka i social ikona) |
| `flexbase_footer_social_{network}` | url | `''` (facebook, instagram, twitter, linkedin, youtube, tiktok) |

Napomena: footer social URL polja su nezavisna od topbar social — svako ima svoja. Ikona klase (`flexbase_social_{network}_icon`) su zajednička za oba mesta.

#### Sekcija: Typography
| Setting | Tip | Default |
|---------|-----|---------|
| `flexbase_typography_base_font` | select | `inherit` |
| `flexbase_typography_heading_font` | select | `inherit` |

Dostupni fontovi: Inter, Roboto, Open Sans, Lato, Montserrat, Poppins, Raleway, Nunito, DM Sans, Figtree, Mulish, Josefin Sans, Source Sans 3, Ubuntu, Oxygen, PT Sans, Noto Sans, Playfair Display, Merriweather, Lora, PT Serif, Cormorant Garamond, Crimson Text, DM Serif Display.

#### Sekcija: Colors
| Setting | Default |
|---------|---------|
| `flexbase_color_primary` | `#6366f1` |
| `flexbase_color_secondary` | `#8b5cf6` |
| `flexbase_color_background` | `#ffffff` |
| `flexbase_color_text` | `#1e1e2e` |

#### Sekcija: Layout
| Setting | Tip | Default | Opseg |
|---------|-----|---------|-------|
| `flexbase_layout_container_width` | number | `1200` | 600–2560 px |

---

## Registrovani nav meniji

| Location slug | Label |
|---------------|-------|
| `primary` | Primary Menu |
| `secondary` | Secondary Menu |
| `topbar` | Top Bar Menu |
| `footer` | Footer Menu |

---

## BEM klase (header)

| Element | BEM klasa |
|---------|-----------|
| Header root | `.flexbase-header` |
| Inner container | `.flexbase-header__inner` |
| Logo area | `.flexbase-header__logo` |
| Site name (fallback) | `.flexbase-header__site-name` |
| Desktop nav | `.flexbase-header__nav` |
| Desktop nav list | `.flexbase-nav__menu` |
| Hamburger button | `.flexbase-header__hamburger` |
| Hamburger bar span | `.flexbase-header__hamburger-bar` |
| Mobile menu wrapper | `.flexbase-header__mobile-menu` |
| Mobile nav list | `.flexbase-nav__menu--mobile` |

Hamburger/mobile toggle state: `.is-active` (na buttonu), `.is-open` (na mobile menu div-u).
Mobile breakpoint: `@media (max-width: 768px)`.

---

## Body klase koje tema dodaje

| Klasa | Uslov |
|-------|-------|
| `flexbase-elementor-active` | Elementor plugin je aktivan |
| `flexbase-elementor-locations` | Elementor Pro Theme Locations API dostupan |
| `flexbase-bricks-active` | Bricks Builder je aktivan |

---

## Zadaci — status

- [x] Task 1: Osnova teme — style.css, functions.php, index.php, header.php, footer.php
- [x] Task 2: inc/enqueue.php — enqueue svih CSS i JS fajlova
- [x] Task 3: inc/customizer.php — Customizer panel sa 6 sekcija i svim settings
- [x] Task 4: inc/topbar.php — Top Bar render, SVG ikone, 3-kolonski layout, social, dismissible
- [x] Task 5: template-parts/default-footer.php — Footer sa nav + copyright
- [x] Task 6: inc/header-builder.php — Default header render, sticky/transparent wrapper, Elementor template helper
- [x] Task 7: inc/elementor-compatibility.php — Elementor Pro theme locations, body klase, inline CSS normalizacija, disable conflicting renders
- [x] Task 8: inc/bricks-compatibility.php + template-parts/default-header.php — Bricks theme locations, responsive header sa hamburgerom, header.css, main.js
- [x] Task 9: assets/css/topbar.css + assets/js/topbar.js — 3-col flex layout, social icons, link/text stilovi, dismiss animacija, DOM cleanup na transitionend
- [x] Task 10: assets/css/sticky.css + assets/js/sticky.js — sticky header (always/scroll_up/none), transparent→solid tranzicija, topbar offset, spacer div, ResizeObserver
- [x] Task 11: template-parts/default-footer.php + assets/css/footer.css — 3-col footer (logo+address, contact, social), copyright bar, responsive stack, light theme; customizer: footer_address/email/phone, uklonjen show_menu; footer.php → do_action('flexbase_footer'); flexbase_default_footer_render() dodata
- [x] Task 12: inc/fonts.php — Google Fonts CSS2 API loader, flexbase_google_fonts_url(), flexbase_font_stack() sa serif/sans-serif fallback, preconnect hints za fonts.googleapis.com i fonts.gstatic.com
- [x] Task 13: inc/css-vars.php — :root CSS custom properties (primary/secondary/background/text/container-width); sve var() zamene u main/header/footer/topbar/sticky.css
- [x] Task 14: Mobile menu full-screen + z-index fix — uklonjen `.flexbase-header__mobile-menu-bar`; mobile menu pokrivo ceo ekran (`top:0; height:100dvh; z-index:10001`); hamburger se premešta na `<body>` via JS sa `position:fixed + z-index:10003` dok je meni otvoren, vraća se na originalno mesto na zatvaranje; backdrop `z-index:10000` iza menija; topbar kolone dobijaju `--<type>` modifier klasu, social kolone vidljive na ≤600px; ispravljen `get_theme_mod` fallback za right column (`'social_icons'` umesto `'none'`)
- [x] Task 15: Logo u mobile menu + Header/Footer bg+text color — `flexbase_mobile_menu_logo` checkbox u Header sekciji; `flexbase_header_bg_color` + `flexbase_header_text_color` kao inline CSS vars na `<header>`; `flexbase_footer_bg_color` + `flexbase_footer_text_color` kao inline CSS vars na `<footer>`; `email_phone` tip kolone u topbar za prikaz emaila i telefona zajedno
- [x] Task 16: Footer logo + nezavisne footer social ikone — `flexbase_footer_logo` (WP_Customize_Media_Control) za poseban logo u footeru sa fallback lancem; 6 × `flexbase_footer_social_{network}` URL polja nezavisna od topbar polja; footer social ikone u `default-footer.php` koriste footer-specifična polja
- [x] Task 17: Font Awesome social ikone + link color
- [x] Task 18: React admin settings panel — top-level WP menu "FlexBase Settings", 4 tabs (General/Top Bar/Footer/Social), REST API flexbase/v1/settings, wp.element + wp-api-fetch, save spinner; premesteni iz Customizera: colors/fonts/container-width/header colors/topbar colors+content/footer colors+content/social URLs+icons; u Customizeru ostaju: topbar enable/hide/dismiss/col-types, header sticky/transparent/logo/elementor-template, footer logo; one-time migracija iz theme_mods; flexbase_opt() helper — Font Awesome Free 6 CDN u `enqueue.php`; `flexbase_topbar_social_svg()` zamenjena FA `<i>` tagovima; 6 × `flexbase_social_{network}_icon` text polja u Customizer (Top Bar sekcija, deljeno između topbar i footer); `flexbase_footer_link_color` color picker u Footer sekciji; `--footer-link-color` CSS var u footer inline stilu; `footer.css` i `topbar.css` ažurirani sa font-size za FA ikone i var() za boje

---

# PROJEKAT 2 — Stripe Payment Buttons Plugin

## Lokacija
`wp-content/plugins/stripe-payment-buttons/`

## Stack
- WordPress plugin (PHP 7.4+)
- Vanilla CSS i JS (bez frameworka)
- Stripe Payment Links za one-time uplate
- Stripe Checkout Sessions API (via wp_remote_post) za subscription uplate

## Pravila
- Nemoj menjati ništa van foldera `stripe-payment-buttons/`

## Kompletna struktura fajlova

```
wp-content/plugins/stripe-payment-buttons/
├── stripe-payment-buttons.php       # Main plugin file
├── admin/
│   └── settings.php                 # Settings API, sanitization, render functions
├── includes/
│   ├── shortcode.php                # [stripe_payment_buttons] shortcode renderer
│   └── ajax.php                     # AJAX handler za Stripe Checkout Session
├── assets/
│   ├── css/style.css                # Frontend stilovi
│   └── js/script.js                 # Frontend logika (radio, AJAX, validacija)
└── README.md                        # Dokumentacija za krajnjeg korisnika
```

---

## Zadaci — status

- [x] Zadatak 1: Osnova plugina — plugin header, konstante, include struktura, hook registracija
- [x] Zadatak 2: Admin Settings — Settings API, sekcije, polja, sanitizacija, settings page
- [x] Zadatak 3: Shortcode i Frontend — `[stripe_payment_buttons]` shortcode, CSS, JS
- [x] Zadatak 4: Opcije i polish — show_portal parametar, portal button, više review/fix rundi
- [x] Zadatak 5: Sigurnost i README — security audit, README.md dokumentacija
- [x] Zadatak 6: show_portal debug — bug bio konfiguracija (Customer Portal Link mora biti popunjen)
- [x] Zadatak 7: Custom Amount + Stripe API — amount input za subscription, AJAX endpoint, Stripe Checkout Session, currency selector, custom fields, new tab
- [x] Zadatak 8: Bugfix — `window.stripePB` undefined — `wp_localize_script` premešten iz shortcode render funkcije u `wp_enqueue_scripts` hook u glavnom fajlu

---

## Implementirane funkcionalnosti

### One-Time plaćanje
- Korisnik bira "One-Time" radio → klik otvara Stripe Payment Link u novom tabu

### Subscription (Monthly / Yearly)
- Korisnik bira interval → unosi iznos → AJAX kreira Stripe Checkout Session
- PHP validira iznos (min $1), session: mode=subscription, inline price_data
- Custom fields: Full Name (obavezno), Business Name (opciono)
- Checkout se otvara u novom tabu

### Shortcode parametri

| Parametar | Vrednosti | Default |
|-----------|-----------|---------|
| `layout` | `vertical\|horizontal` | `vertical` |
| `show_one_time` | `true\|false` | `true` |
| `show_monthly` | `true\|false` | `true` |
| `show_yearly` | `true\|false` | `true` |
| `button_text` | bilo koji tekst | *(iz settings)* |
| `show_portal` | `true\|false` | `false` |

---

## Admin Settings polja

### API Settings
| Polje | Tip | Default |
|-------|-----|---------|
| Mode | select | test |
| Currency | select | cad (USD, CAD, EUR, GBP) |
| Publishable Key | text | — |
| Secret Key | password | — |

### Payment Links
| Polje | Opis |
|-------|------|
| One-Time Payment Link | Stripe Payment Link za one-time |
| Monthly Subscription Link | Rezervisano (nekorišćeno) |
| Yearly Subscription Link | Rezervisano (nekorišćeno) |
| Customer Portal Link | Za show_portal |
| Success Page URL | Redirect posle uspešne uplate |

### Button Labels: One-Time / Monthly / Yearly button text
### Prices (display only): One-Time / Monthly / Yearly cena
### Button Style: Button Color (`#6366f1`)

---

## AJAX endpoint

- Action: `stripe_pb_create_session`
- Nonce: `stripe_pb_nonce`
- POST: `amount`, `interval` (month/year), `page_url`
- Response: `{ success: true, data: { url: "https://checkout.stripe.com/..." } }`
- Success URL: `success_page` iz settings ili `page_url + ?stripe_pb=success`
- Cancel URL: `page_url + ?stripe_pb=cancelled`

---

## Važne tehničke napomene

### wp_localize_script pravilo
`wp_localize_script` za `stripe-pb` handle mora biti u `wp_enqueue_scripts` hooku (u glavnom fajlu), **ne** unutar shortcode render funkcije. Razlog: WordPress lifecycle ne garantuje da će podaci biti ispisani na stranicu ako se poziva iz shortcode-a.

### Stripe Yearly billing prikaz
Stripe prikazuje godišnji iznos kao mesečni ekvivalent (`X/month billed annually`). Stvarna naplata je jednom godišnje za puni iznos. Primer: $3,200/year → Stripe prikazuje "CA$266.67/month billed annually".

---

## Styling Rules

- NEVER use inline CSS styles on HTML elements
- All dynamic values from PHP (colors, sizes, etc.) must be output as CSS custom properties (variables) on a wrapper element or :root
- Apply all visual styles exclusively through CSS files using var() to reference those custom properties
- This ensures :hover, :focus, media queries and external CSS can always override styles correctly

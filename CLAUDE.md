# Stripe Payment Buttons - WordPress Plugin

## Lokacija plugina
Sve fajlove plugina pravi ISKLJUČIVO u:
`wp-content/plugins/stripe-payment-buttons/`

## Stack
- WordPress plugin (PHP 7.4+)
- Vanilla CSS i JS (bez frameworka)
- Stripe Payment Links za one-time uplate
- Stripe Checkout Sessions API (via wp_remote_post) za subscription uplate

## Pravila
- Uvek koristi WordPress funkcije (sanitize_url, esc_url, wp_enqueue itd.)
- Zaštita od direktnog pristupa na svakom PHP fajlu: `defined('ABSPATH') || exit;`
- Nonce verifikacija u svim admin formama i AJAX pozivima
- Nemoj menjati ništa van foldera stripe-payment-buttons/

## Jezik
- Sav kod, komentari u kodu, i tekstovi u pluginu moraju biti na Engleskom
- Komunikacija sa mnom je na Srpskom

## Code Quality
- No spaghetti code - organize into clean, well structured functions
- Follow WordPress coding standards
- Keep code DRY (no repetition)
- Add inline comments where needed
- After each task review the code for bugs and better solutions

---

## Struktura plugina (kompletna)

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

## Zadaci - status

- [x] Zadatak 1: Osnova plugina — plugin header, konstante, include struktura, hook registracija
- [x] Zadatak 2: Admin Settings — Settings API, sekcije, polja, sanitizacija, settings page
- [x] Zadatak 3: Shortcode i Frontend — [stripe_payment_buttons] shortcode, CSS, JS
- [x] Zadatak 4: Opcije i polish — show_portal parametar, portal button, više review/fix rundi
- [x] Zadatak 5: Sigurnost i README — security audit, README.md dokumentacija
- [x] Zadatak 6: show_portal debug — bug bio konfiguracija (Customer Portal Link mora biti popunjen)
- [x] Zadatak 7: Custom Amount + Stripe API — amount input za subscription, AJAX endpoint, Stripe Checkout Session, currency selector, custom fields, new tab
- [x] Zadatak 8: Bugfix — `window.stripePB` undefined (Configuration error) — `wp_localize_script` premešten iz shortcode render funkcije u `wp_enqueue_scripts` hook u glavnom fajlu

---

## Sve implementirane funkcionalnosti

### One-Time plaćanje
- Korisnik bira "One-Time" radio
- Klikom na dugme otvara se Stripe Payment Link u novom tabu
- Link se konfiguriše u admin Settings

### Subscription plaćanje (Monthly / Yearly)
- Korisnik bira "Monthly" ili "Yearly" radio
- Pojavljuje se polje za unos iznosa (npr. $17)
- Klikom na dugme, JavaScript šalje AJAX zahtev na WordPress endpoint
- PHP validira iznos (min $1), kreira Stripe Checkout Session via REST API
- Stripe forma traži: Full Name (obavezno), Business Name (opciono)
- Checkout se otvara u novom tabu
- Checkout Session koristi inline price_data (bez unapred kreiranog Price objekta)
- Currency se čita iz admin podešavanja

### Shortcode
```
[stripe_payment_buttons]
```
Može se staviti na bilo koju stranicu/post. Više instanci na istoj stranici funkcioniše.

---

## Shortcode parametri

| Parametar | Vrednosti | Default | Opis |
|-----------|-----------|---------|------|
| `layout` | `vertical` \| `horizontal` | `vertical` | Radio opcije vertikalno ili horizontalno |
| `show_one_time` | `true` \| `false` | `true` | Prikaži/sakrij One-Time opciju |
| `show_monthly` | `true` \| `false` | `true` | Prikaži/sakrij Monthly opciju |
| `show_yearly` | `true` \| `false` | `true` | Prikaži/sakrij Yearly opciju |
| `button_text` | bilo koji tekst | *(iz settings)* | Override tekst dugmeta za sve vidljive opcije |
| `show_portal` | `true` \| `false` | `false` | Prikaži "Manage Subscription" link (samo ako je Customer Portal Link konfigurisan) |

---

## Admin Settings polja (Settings > Stripe Payments)

### API Settings
| Polje | Tip | Default | Opis |
|-------|-----|---------|------|
| Mode | select | test | Test ili Live mod |
| Currency | select | cad | USD, CAD, EUR, GBP — koristi se za Checkout Sessions |
| Publishable Key | text | — | Stripe publishable key |
| Secret Key | password | — | Stripe secret key (za kreiranje Checkout Sessions) |

### Payment Links
| Polje | Tip | Opis |
|-------|-----|------|
| One-Time Payment Link | url | Stripe Payment Link za jednokratne uplate |
| Monthly Subscription Link | url | (rezervisano, trenutno nekorišćeno — subscription ide kroz Checkout Session) |
| Yearly Subscription Link | url | (rezervisano, trenutno nekorišćeno) |
| Customer Portal Link | url | Stripe Customer Portal URL (za show_portal) |
| Success Page URL | url | URL Thank You stranice na koju Stripe redirect-uje posle uspešne uplate (opciono; ako nije popunjeno, vraća na istu stranicu) |

### Button Labels
| Polje | Default |
|-------|---------|
| One-Time Button Text | Donate |
| Monthly Button Text | Subscribe Monthly |
| Yearly Button Text | Subscribe Yearly |

### Prices (display only)
| Polje | Default |
|-------|---------|
| One-Time Price | $10 |
| Monthly Price | $5/mo |
| Yearly Price | $50/yr |

### Button Style
| Polje | Default |
|-------|---------|
| Button Color | #6366f1 (indigo) |

---

## AJAX endpoint

- Action: `stripe_pb_create_session`
- Hook: `wp_ajax_nopriv_stripe_pb_create_session` + `wp_ajax_stripe_pb_create_session`
- Nonce: `stripe_pb_nonce`
- POST parametri: `amount`, `interval` (month/year), `page_url`
- Vraća: `{ success: true, data: { url: "https://checkout.stripe.com/..." } }`
- Stripe Checkout Session: mode=subscription, inline price_data, custom_fields (Full Name + Business Name)
- Success URL: `success_page` iz settings ako je popunjen, inače `page_url + ?stripe_pb=success`
- Cancel URL: `page_url + ?stripe_pb=cancelled`

---

## Važne tehničke napomene

### wp_localize_script pravilo
`wp_localize_script` za `stripe-pb` handle mora biti u `wp_enqueue_scripts` hooку (u glavnom fajlu), **ne** unutar shortcode render funkcije. Razlog: ako se poziva iz shortcode-a, WordPress lifecycle ne garantuje da će podaci biti ispisani na stranicu — handle možda još nije registrovan ili su skripte već ispisane.

### Stripe Yearly billing prikaz
Stripe prikazuje godišnji iznos kao mesečni ekvivalent (`X/month billed annually`). Stvarna naplata je jednom godišnje za puni iznos koji korisnik unese. Primer: $3,200/year → Stripe prikazuje "CA$266.67/month billed annually", naplaćuje $3,200 jednom godišnje.

---

## Gde smo stali

Završen Zadatak 8. Plugin je funkcionalan sa svim sledećim:
- One-time plaćanje via Stripe Payment Links
- Subscription plaćanje via Stripe Checkout Sessions sa custom amount
- Currency selector u adminu (USD, CAD, EUR, GBP; default CAD)
- Full Name i Business Name polja u Stripe Checkout formi
- Checkout se otvara u novom tabu
- Sve AJAX sigurnosne mere (nonce, sanitizacija, validacija)
- Kompletna admin Settings stranica
- README.md dokumentacija
- Bugfix: wp_localize_script premešten u wp_enqueue_scripts hook

Sledeći eventualni zadaci:
- Prikazivanje success/cancelled poruke na stranici na osnovu `?stripe_pb=` query parametra
- Prefill email u Stripe Checkout
- Prikazivanje cene pored radio opcija

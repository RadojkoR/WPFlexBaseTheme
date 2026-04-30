# Stripe Payment Buttons

A WordPress plugin that adds Stripe payment buttons to any page or post via a shortcode. Supports one-time payments and recurring subscriptions (monthly and yearly) using Stripe Payment Links.

---

## Installation

1. Download or copy the `stripe-payment-buttons` folder into `wp-content/plugins/`.
2. Log in to your WordPress admin panel.
3. Go to **Plugins > Installed Plugins**.
4. Find **Stripe Payment Buttons** and click **Activate**.

---

## Step 1 — Create Payment Links in Stripe

Payment Links are URLs that open a Stripe-hosted checkout page. You need to create one for each payment type you want to offer.

### One-Time Payment Link

1. Log in to your [Stripe Dashboard](https://dashboard.stripe.com).
2. In the left sidebar, click **Payment Links**.
3. Click **+ New** (top right).
4. Under **Products**, click **+ Add a product**.
5. Enter a product name (e.g. "Donation") and a price.
6. Set **Billing period** to **One time**.
7. Click **Create product**, then click **Create link**.
8. Copy the generated URL (e.g. `https://buy.stripe.com/...`).

### Monthly Subscription Link

1. Go to **Payment Links > + New**.
2. Click **+ Add a product**.
3. Enter a name (e.g. "Monthly Subscription") and a price.
4. Set **Billing period** to **Monthly**.
5. Click **Create product**, then click **Create link**.
6. Copy the generated URL.

### Yearly Subscription Link

1. Go to **Payment Links > + New**.
2. Click **+ Add a product**.
3. Enter a name (e.g. "Yearly Subscription") and a price.
4. Set **Billing period** to **Yearly**.
5. Click **Create product**, then click **Create link**.
6. Copy the generated URL.

> **Test vs Live mode:** Stripe has separate dashboards for Test and Live mode. Use Test mode while setting up. Switch to Live mode only when you are ready to accept real payments. The toggle is in the top-left of the Stripe Dashboard.

---

## Step 2 — Configure the Plugin

1. In your WordPress admin, go to **Settings > Stripe Payments**.
2. Fill in the fields:

### API Settings

| Field | Description |
|-------|-------------|
| Mode | `Test` while developing, `Live` for real payments |
| Publishable Key | Found in Stripe Dashboard > Developers > API Keys |
| Secret Key | Found in Stripe Dashboard > Developers > API Keys |

### Payment Links

| Field | Description |
|-------|-------------|
| One-Time Payment Link | The URL you copied for one-time payments |
| Monthly Subscription Link | The URL you copied for monthly subscriptions |
| Yearly Subscription Link | The URL you copied for yearly subscriptions |
| Customer Portal Link | URL of your Stripe Customer Portal (optional) |

To find your Customer Portal URL: Stripe Dashboard > Customers > Customer portal > copy the portal link.

### Button Labels

| Field | Default |
|-------|---------|
| One-Time Button Text | Donate |
| Monthly Button Text | Subscribe Monthly |
| Yearly Button Text | Subscribe Yearly |

### Prices

These are display-only labels shown to visitors. They do not affect the actual charge amount.

| Field | Example |
|-------|---------|
| One-Time Price | $10 |
| Monthly Price | $5/mo |
| Yearly Price | $50/yr |

### Button Style

| Field | Description |
|-------|-------------|
| Button Color | Pick any color for the button and selected option highlight |

3. Click **Save Settings**.

---

## Step 3 — Add the Shortcode

Place the shortcode in any page, post, or widget:

```
[stripe_payment_buttons]
```

That's it. The plugin will display the configured payment options with the button.

---

## Shortcode Parameters

All parameters are optional. When omitted, the plugin uses the values set in **Settings > Stripe Payments**.

| Parameter | Values | Default | Description |
|-----------|--------|---------|-------------|
| `layout` | `vertical` \| `horizontal` | `vertical` | Stacks options vertically or side by side |
| `show_one_time` | `true` \| `false` | `true` | Show or hide the One-Time option |
| `show_monthly` | `true` \| `false` | `true` | Show or hide the Monthly option |
| `show_yearly` | `true` \| `false` | `true` | Show or hide the Yearly option |
| `button_text` | Any text | *(from settings)* | Override the button label for all visible options |
| `show_portal` | `true` \| `false` | `false` | Show a "Manage Subscription" button linking to the Stripe Customer Portal. Hidden automatically if no Customer Portal Link is configured in settings. |

### Examples

**Basic usage — show all three options:**
```
[stripe_payment_buttons]
```

**Horizontal layout:**
```
[stripe_payment_buttons layout="horizontal"]
```

**Show only the one-time option:**
```
[stripe_payment_buttons show_monthly="false" show_yearly="false"]
```

**Show only subscriptions with a custom button label:**
```
[stripe_payment_buttons show_one_time="false" button_text="Subscribe Now"]
```

**Horizontal layout, yearly hidden, custom button text:**
```
[stripe_payment_buttons layout="horizontal" show_yearly="false" button_text="Get Started"]
```

**Show subscription options with a Manage Subscription button:**
```
[stripe_payment_buttons show_one_time="false" show_portal="true"]
```

> You can place the shortcode multiple times on the same page — each instance is independent.

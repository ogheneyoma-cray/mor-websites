# Client Store Build — Reusable Prompt Template

Copy this whole prompt, fill in the bracketed fields, and hand it to Claude to scaffold a new client branch's WooCommerce theme.

---

I need you to build a full WordPress + WooCommerce store as a custom theme.
Output every file in full — no truncation or placeholders. No lorem ipsum
— all copy must be real, written-out content specific to this store. PHP
throughout following WordPress coding standards, properly escaped/sanitized
(esc_html, esc_attr, sanitize_text_field, nonces on all forms).

CONTEXT: This theme is part of a multi-branch repo setup — one theme
codebase, multiple git branches, where each branch is a complete independent
layout for one client site. This build is for ONE branch/client. Build it
as a normal standalone theme in the current working directory — don't add
any branch/updater logic yourself, that already exists separately and gets
merged in independently. Just build clean, self-contained theme files.

Before you start, also save this entire prompt (with the bracketed fields
below still as placeholders, unfilled) as /docs/site-build-prompt-template.md
in the repo, so it can be reused as-is for future client sites — just
reference it, don't ask me anything about this step.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
STORE DETAILS
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Store Name:    [STORE_NAME]
Product Type:  [PRODUCT_TYPE — e.g. "fashion items (clothes, shoes etc)",
               "handmade jewelry", "electronics accessories"]
Address:       [STORE_ADDRESS]
Email:         [STORE_EMAIL]
Phone:         [STORE_PHONE]
Currency:      NGN (primary WooCommerce currency), with a front-end
               currency SWITCHER that displays prices converted to USD
               on toggle — client-side conversion display only, all
               actual transactions still process in NGN. Use a static/
               cached exchange rate (configurable constant), not a live
               API call on every page load.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
SHORTCODES — BUILD THESE FIRST
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Register as WordPress shortcodes, backed by Customizer theme_mods (not
hardcoded), so store details can be changed from wp-admin without touching
code:
- [company_name]
- [company_phone]
- [company_email]
- [company_address]
Use these everywhere these values appear — header, footer, contact page,
legal pages. Also expose as PHP functions (e.g. get_theme_mod('company_name'))
for use inside template files. Add a Customizer panel ("Store Details") with
fields for all four, pre-filled with the [STORE_NAME] / [STORE_EMAIL] /
[STORE_PHONE] / [STORE_ADDRESS] values above as defaults.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
PAGES
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Use WooCommerce's native pages/templates as the foundation (Shop, Cart,
Checkout, Product) and override them via theme template files (woocommerce/
folder in the theme) rather than building cart/checkout logic from scratch.

1. HOME — front page (static page set as front page in Customizer)
   Hero with store name, tagline, "Shop Now" CTA linking to /shop.
   6 featured products grid.
   Brand intro section, 200+ words of real written copy about the store
   and what it offers ([PRODUCT_TYPE]).

2. SHOP — WooCommerce shop page, styled to match design system.
   Grid layout, each card: image, name, price, "Add to Cart".

3. PRODUCT PAGES — WooCommerce single-product.php override.
   Image, name, price, description (150+ words per product), quantity
   selector, Add to Cart.

4. CART — WooCommerce cart page template override.
   Item list, quantity controls, remove button, order total, "Proceed to
   Checkout" button. Empty-cart state with "Shop Now" link.

5. CHECKOUT — MUST use WooCommerce's classic shortcode-based checkout
   ([woocommerce_checkout]), NOT the block-based checkout editor. Explicitly
   ensure WooCommerce > Settings > Advanced has the checkout page set to the
   classic shortcode version, since classic checkout has far broader
   compatibility with third-party payment gateway plugins than the block
   checkout. Style the classic checkout template override
   (woocommerce/checkout/form-checkout.php if needed) to match the design
   system. Do not build any custom payment/card form — payment gateway setup
   is handled separately later, outside this build. Order summary panel.
   On successful order, style WooCommerce's native thank-you page to match
   the design system.

6. CONTACT — custom page template.
   HARDCODE the contact form directly in the theme as plain PHP (name,
   email, message fields), with nonce verification and sanitized input,
   submitting via wp_mail() — do not use or recommend a plugin (no Contact
   Form 7, no WPForms). This should work as a self-contained template file
   with its own form handler.
   Store details panel using [company_address], [company_email],
   [company_phone] shortcodes, plus business hours (write reasonable real
   hours appropriate for this type of store).
   5-question FAQ section with full, real answers relevant to [PRODUCT_TYPE]
   e-commerce (shipping times, returns, product specifics, payment methods,
   order tracking).

7. LEGAL PAGES — standard WordPress pages. EACH page must be 500+ words
   of real, complete, specific written content (not placeholder/generic
   text) — genuinely detailed policy language appropriate for a Nigerian
   e-commerce store shipping physical goods:
   - Shipping Policy (delivery zones/timeframes within Nigeria, shipping
     costs, order processing time, delayed/lost package handling)
   - Privacy Policy (what data is collected at checkout/contact form, how
     it's used/stored, third-party sharing, cookies, user rights)
   - Terms and Conditions (site use, order acceptance, pricing errors,
     intellectual property, liability)
   - Refunds Policy (return window, condition requirements, refund method/
     timeframe, non-returnable items, exchange process)

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
COMPONENTS
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
- header.php: logo, nav (Home, Shop, Contact), WooCommerce cart icon with
  live item count (using WooCommerce's cart fragment/AJAX refresh so it
  updates without full page reload). Mobile hamburger menu, off-canvas or
  dropdown.
- footer.php: quick links, contact info (via shortcodes), copyright with
  dynamic year. NO social media icons or links anywhere on the site —
  header, footer, or any other page. Do not add placeholder social icons
  even if the reference design includes them; omit that section entirely.
- Currency switcher: small NGN/USD toggle in header. Client-side JS that
  re-renders displayed prices using a stored conversion rate — display only,
  with a note near the toggle that checkout completes in NGN.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
PRODUCT IMPORT — ADMIN BUTTON, NOT AUTO-RUN
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Do NOT auto-seed products on theme activation. Instead, build an admin page
under Appearance (or Tools) called "Import Store Products" with a single
"Import Products" button. When clicked (via admin-post.php + nonce), it
runs a PHP import routine that creates 20 real WooCommerce products via
wc_get_product()/CRUD methods (not raw DB inserts), so they behave as
normal products with cart/checkout/inventory support. Show a success
message with count of products created when done, and make it safe to
click twice (skip products that already exist, matched by SKU or title,
don't duplicate).

Write 20 real products fitting [PRODUCT_TYPE], with genuine names, 150+
word descriptions each, priced between $9–$50 equivalent in NGN (pick
reasonable NGN price points using the configured conversion rate).

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
IMAGES
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Search for and download real, appropriate stock/free-license images
(e.g. from Unsplash/Pexels or similar free-to-use sources) for:
- Site imagery: hero banner, brand-intro section, any lifestyle imagery
  relevant to [PRODUCT_TYPE]
- Each of the 20 products (matching each product's description)
Download these into the theme/import routine so they get properly
sideloaded into the WordPress media library (media_sideload_image() or
equivalent) as real attachments tied to their posts/products, not external
hotlinks. Confirm the license of any source used permits this kind of use
(commercial site, redistributed via a client's install).

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
DESIGN
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Reference site for layout, design system, and color palette: [REFERENCE_URL].
Visit this site, study its layout structure, typography, spacing, and color
scheme, and replicate that system — but all copy/content must remain
specific to [STORE_NAME] as written above, not copied from the reference
site. If the reference site includes social media icons/links, omit them —
this build must not include any social media icons anywhere.
Mobile-first: every page must work cleanly at a 375px viewport. Minimum
44px tap targets on all interactive elements. Use Tailwind CSS (compiled/
built, not CDN) or plain enqueued CSS with CSS custom properties for
colors/spacing — pick one and be consistent throughout.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
TECHNICAL RULES
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
- Custom WordPress theme requiring WooCommerce — check for it in
  functions.php and deactivate gracefully with an admin notice if it's
  not active, don't fatal-error.
- Standard WP theme structure: style.css header, functions.php,
  template-parts/, woocommerce/ override folder, inc/ for logic separation.
- All forms: nonces + sanitization + escaped output, no raw $_POST usage.
- No hardcoded store details anywhere — always via the shortcodes/
  theme_mods described above.
- No Dockerfile or containerization needed — this is installed directly
  as a theme on an existing WordPress site.
- After all files, give the exact steps to: install this theme, activate
  WooCommerce, and use the product import button.

WHAT TO ASK ME BEFORE YOU START, IF UNCLEAR
- Exact NGN price points for the 20 products, or pick within the $9–$50
  equivalent range yourself
- Confirm you have web access to fetch the design reference link and
  search/download stock images — flag it if you don't and need me to
  supply images another way

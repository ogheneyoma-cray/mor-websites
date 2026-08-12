<?php
/**
 * Legal page copy consumed by inc/content-importer.php.
 * Written for a Ghana-based fashion e-commerce store shipping physical
 * clothing and accessories, pricing and settling in Ghanaian Cedis (GHS).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mor_get_legal_pages() {
	return array(
		array(
			'slug'    => 'shipping-policy',
			'title'   => 'Shipping Policy',
			'content' => mor_legal_shipping_policy(),
		),
		array(
			'slug'    => 'privacy-policy',
			'title'   => 'Privacy Policy',
			'content' => mor_legal_privacy_policy(),
		),
		array(
			'slug'    => 'terms-and-conditions',
			'title'   => 'Terms and Conditions',
			'content' => mor_legal_terms_and_conditions(),
		),
		array(
			'slug'    => 'refunds-policy',
			'title'   => 'Refunds Policy',
			'content' => mor_legal_refunds_policy(),
		),
	);
}

function mor_legal_shipping_policy() {
	return '
<p>This Shipping Policy explains how [company_name] processes, packages, and delivers orders placed through this website. All prices are listed and charged in Ghanaian Cedis (GHS); the USD figure shown when the currency switcher is set to USD is a reference conversion only and is not the amount charged at checkout. Please read this policy alongside our Terms and Conditions and our Refunds Policy.</p>

<h2>Delivery Zones and Timeframes</h2>
<p>We currently ship to addresses across Ghana. Delivery timeframes are estimated from the point an order is dispatched, not from the point it is placed, and vary by destination:</p>
<ul>
<li><strong>Accra and Greater Accra:</strong> typically 1–2 business days.</li>
<li><strong>Kumasi, Takoradi, and other major regional capitals:</strong> typically 2–4 business days.</li>
<li><strong>Other towns and rural addresses:</strong> typically 4–7 business days, depending on courier coverage in that area.</li>
</ul>
<p>These are typical timeframes based on normal courier performance, not contractual guarantees — public holidays, adverse weather, and courier network disruptions can extend delivery beyond the estimate given above.</p>

<h2>Order Processing Time</h2>
<p>Orders are processed and packed within 1–2 business days of payment being confirmed, Monday to Saturday, excluding public holidays. Orders placed after 3:00 PM are processed the following business day. Once an order has been packed and handed to our courier partner, you will receive a dispatch notification by email with tracking details where available.</p>

<h2>Shipping Costs</h2>
<p>Shipping costs are calculated at checkout based on delivery zone and order weight, and are shown clearly before payment is taken — there are no hidden fees added after checkout. We periodically offer free shipping thresholds or promotions; where active, these are displayed on the Shop page and applied automatically at checkout.</p>

<h2>Order Tracking</h2>
<p>Once your order has been dispatched, you can track its status by logging in to your account and viewing "My Account &gt; Orders", or using the tracking link included in your dispatch notification email where our courier partner provides one. If you have not received a dispatch notification within 3 business days of placing your order, please contact us.</p>

<h2>Delayed or Lost Packages</h2>
<p>If your order has not arrived within the estimated delivery window for your zone, contact us with your order number and we will investigate with our courier partner. If a package is confirmed lost in transit, we will, at your choice, dispatch a replacement at no additional cost or issue a full refund for the affected order. We ask that delay reports be raised within 14 days of dispatch so the investigation window with our courier partner remains open.</p>

<h2>Incorrect Delivery Addresses</h2>
<p>Please double-check your delivery address at checkout — we are not able to redirect a package once it has been dispatched. If a package is returned to us because an address was entered incorrectly, we will contact you to arrange re-delivery, and a second delivery charge may apply to cover the additional courier cost.</p>

<h2>Packaging</h2>
<p>All items are inspected and packaged securely before dispatch to minimise the risk of damage in transit. If an item arrives visibly damaged, please keep all original packaging and contact us within 48 hours of delivery with photos of the damage so we can process a replacement or refund promptly.</p>

<h2>Contact</h2>
<p>Questions about a specific order or delivery can be sent through our Contact page or directly to the phone number and email listed there.</p>
';
}

function mor_legal_privacy_policy() {
	return '
<p>This Privacy Policy explains what personal information [company_name] ("we", "us", "our") collects through this website, how we use and store it, who we share it with, and the rights you have over it. We process personal data in line with Ghana\'s Data Protection Act, 2012 (Act 843), and this policy is written to reflect the obligations that Act places on us as a data controller.</p>

<h2>Information We Collect</h2>
<p>We collect personal information in a small number of specific ways:</p>
<ul>
<li><strong>Contact form submissions:</strong> the name, email address, and message content you submit through our Contact page.</li>
<li><strong>Checkout and order information:</strong> when you place an order through WooCommerce checkout, we collect your name, email address, phone number, delivery and billing address, and details of the item(s) ordered, as required to process, package, and deliver your order.</li>
<li><strong>Account information:</strong> if you create an account, we store your account details and order history so you can log in and view past orders.</li>
<li><strong>Technical information:</strong> standard server logs (such as IP address, browser type, and pages visited) collected automatically as part of normal website operation, used for security and troubleshooting rather than individual tracking.</li>
</ul>
<p>We do not knowingly collect information from anyone we are aware is under the age of 18. If you believe a minor has provided us with personal information, please contact us so we can remove it.</p>

<h2>How We Use Your Information</h2>
<p>We use the information collected for the following purposes only:</p>
<ul>
<li>To process, package, and deliver the items you order, including sharing your delivery details with our courier partner.</li>
<li>To respond to messages sent through our contact form.</li>
<li>To send order-related communications, such as order confirmations and dispatch notifications.</li>
<li>To maintain accurate records for accounting, tax, and legal compliance purposes.</li>
<li>To improve our website and product range based on aggregated, non-identifying usage patterns.</li>
</ul>
<p>We do not use your personal information for automated decision-making that produces legal or similarly significant effects, and we do not sell your personal information to third parties.</p>

<h2>How We Store and Protect Your Information</h2>
<p>Your information is stored on the servers of our website hosting provider and, for payment processing, the servers of our WooCommerce payment gateway provider(s). We do not store full payment card details on our own servers — card and mobile money payment data is handled directly by our configured payment gateway, in line with that provider\'s own security standards. We restrict access to personal information within our business to staff who need it to fulfil your order or respond to your enquiry, and we take reasonable technical measures (such as access controls and secure hosting) to protect stored data against unauthorised access, loss, or misuse.</p>

<h2>Sharing With Third Parties</h2>
<p>We share personal information with third parties only where necessary to operate this website and fulfil your order:</p>
<ul>
<li><strong>Courier and delivery partners</strong>, to deliver your order to the address provided at checkout.</li>
<li><strong>Payment gateway providers</strong>, to process payment for your order.</li>
<li><strong>Website hosting and email delivery providers</strong>, who process data on our behalf to keep the site and our communications with you running.</li>
<li><strong>Legal or regulatory authorities</strong>, where we are required to disclose information by law.</li>
</ul>
<p>We do not share your personal information with third parties for their own independent marketing purposes.</p>

<h2>Cookies</h2>
<p>This website, through WordPress and WooCommerce, uses cookies for core functionality — keeping items in your cart between pages, keeping you logged in to your account, and remembering your session during checkout. We also store a small piece of browser storage (not a server-side cookie) to remember your GHS/USD price display preference for the currency switcher, which does not identify you personally. You can disable cookies through your browser settings, though doing so may prevent parts of the site, such as the shopping cart, from working correctly.</p>

<h2>Your Rights</h2>
<p>Under the Data Protection Act, 2012 (Act 843), you have the right to know what personal information we hold about you, to request a copy of it, to request correction of inaccurate information, to request deletion of your information where we are not required to retain it for legal or accounting purposes, and to object to certain uses of your information. To exercise any of these rights, contact us using the details on our Contact page, and we will respond within a reasonable time.</p>

<h2>Data Retention</h2>
<p>We retain order and account information for as long as necessary to fulfil the purposes described in this policy, and as required by Ghanaian tax and accounting law, which generally requires business records to be kept for a minimum number of years. Contact form messages not connected to an order are retained only as long as needed to resolve your enquiry.</p>

<h2>Changes to This Policy</h2>
<p>We may update this Privacy Policy from time to time to reflect changes in our practices or legal requirements. The "Last updated" date at the top of this page reflects the most recent revision. Continued use of this website after changes are posted constitutes acceptance of the updated policy.</p>

<h2>Contact</h2>
<p>Questions about this Privacy Policy or how your data is handled can be sent through our Contact page or directly to our listed email address.</p>
';
}

function mor_legal_terms_and_conditions() {
	return '
<p>These Terms and Conditions govern your use of this website and any purchase made through it from [company_name] ("we", "us", "our"), a fashion retailer operating from Anyaa, Accra, Ghana. By using this website or placing an order, you agree to these terms.</p>

<h2>Use of This Site</h2>
<p>You may use this website to browse our products, place orders, and contact us. You agree not to use the site for any unlawful purpose, to attempt to gain unauthorised access to any part of the site or its underlying systems, to submit false or misleading information when ordering, or to use automated tools to scrape or interfere with normal operation of the site. We reserve the right to suspend or refuse service to anyone who misuses the site.</p>

<h2>Accounts</h2>
<p>If you create an account, you are responsible for keeping your login details confidential and for all activity that occurs under your account. Notify us immediately if you believe your account has been accessed without authorisation.</p>

<h2>Order Acceptance</h2>
<p>Placing an order through checkout is an offer to purchase, which we accept once payment is confirmed and the order is dispatched. We reserve the right to decline or cancel an order — for example, where an item is out of stock, where we cannot reasonably fulfil the delivery address given, or where payment cannot be verified — in which case any payment already made will be refunded in full.</p>

<h2>Pricing and Payment</h2>
<p>All prices on this website are listed in Ghanaian Cedis (GHS) and are inclusive of any taxes unless stated otherwise at checkout. The USD amount shown when the currency switcher is set to USD is a reference conversion only, calculated using a periodically updated exchange rate, and is not the amount actually charged — all payments are processed in GHS. Payment is required at the time of ordering through the payment methods available at checkout.</p>

<h2>Pricing Errors</h2>
<p>While we make reasonable efforts to ensure prices displayed on this website are accurate, errors can occur — for example, due to a technical fault or manual data entry mistake. If we discover a pricing error on an order you have already placed, we will contact you before proceeding, and you will have the option to proceed at the correct price or cancel the order for a full refund. We are not obligated to fulfil an order at an incorrectly displayed price where that error is reasonably obvious (for example, an item listed at an amount clearly inconsistent with its normal pricing).</p>

<h2>Product Descriptions and Availability</h2>
<p>We describe each product as accurately as we can, including material, sizing, and care information. Colours may appear slightly different on screen depending on your device display. Stock levels are updated regularly, but availability is not guaranteed until an order is confirmed — if an item you ordered is unexpectedly out of stock, we will notify you and offer a substitute, backorder, or full refund for that item.</p>

<h2>Intellectual Property</h2>
<p>All content on this website — including text, images, logos, and design — is owned by [company_name] or used under licence, and is protected by applicable copyright and intellectual property law. You may not copy, reproduce, or reuse content from this site for commercial purposes without our prior written permission.</p>

<h2>Limitation of Liability</h2>
<p>We take reasonable care in describing, packaging, and delivering every order, but to the fullest extent permitted by Ghanaian law, our liability for any claim arising from an order placed through this site is limited to the amount paid for that order. We are not liable for indirect or consequential losses, such as lost business income, except where such liability cannot be excluded by law.</p>

<h2>Changes to These Terms</h2>
<p>We may update these Terms and Conditions from time to time. The version in effect at the time you place an order is the version that applies to that order.</p>

<h2>Governing Law</h2>
<p>These Terms and Conditions are governed by the laws of Ghana, and any disputes arising from them are subject to the jurisdiction of the courts of Ghana.</p>

<h2>Contact</h2>
<p>Questions about these Terms and Conditions can be sent through our Contact page.</p>
';
}

function mor_legal_refunds_policy() {
	return '
<p>This Refunds Policy explains how returns, exchanges, and refunds work for orders placed through [company_name]. Please read it alongside our Shipping Policy and Terms and Conditions.</p>

<h2>Return Window</h2>
<p>You may return most items within 14 days of delivery for a refund or exchange. The 14-day window is measured from the date your order is marked as delivered, not the date it was ordered. Requests made after this window will be considered on a case-by-case basis but are not guaranteed.</p>

<h2>Condition Requirements</h2>
<p>To be eligible for a return, items must be unworn, unwashed, and in their original condition, with all original tags still attached. Items showing signs of wear, alteration, odour (such as perfume or smoke), or damage will not be accepted for return. Footwear must be returned in its original box, which should be protected with an outer shipping box rather than used as the shipping package itself.</p>

<h2>Non-Returnable Items</h2>
<p>For hygiene reasons, the following items cannot be returned or exchanged unless faulty:</p>
<ul>
<li>Underwear, swimwear, and other intimate apparel.</li>
<li>Earrings and other pierced jewellery.</li>
<li>Items marked as "Final Sale" at the time of purchase.</li>
</ul>

<h2>How to Start a Return</h2>
<p>Send your order number and the item(s) you wish to return through our Contact page, or log in to "My Account &gt; Orders" and select the relevant order. We will confirm eligibility and provide return instructions, including the return address. Please do not send items back without first receiving return instructions from us, as unannounced returns may be delayed in processing.</p>

<h2>Return Shipping</h2>
<p>Unless the item is faulty, incorrect, or damaged on arrival, return shipping costs are the customer\'s responsibility. We recommend using a trackable courier service, as we are not responsible for return packages lost in transit before they reach us. Where an item is faulty, incorrect, or arrived damaged, we will cover the return shipping cost or arrange collection.</p>

<h2>Exchanges</h2>
<p>If you need a different size or colour, request an exchange through the same process as a return — mention your preferred replacement item when you contact us. Exchanges are subject to stock availability; where the requested replacement is unavailable, we will offer a refund instead.</p>

<h2>Refund Method and Timeframe</h2>
<p>Once your returned item is received and inspected, we will notify you by email of the outcome. Approved refunds are processed to your original payment method within 7 business days of approval. Depending on your bank or mobile money provider, it may take a few additional days for the refund to reflect in your account after we process it on our end — this part of the timing is outside our control. Original shipping charges are non-refundable except where the return is due to our error (wrong or faulty item sent).</p>

<h2>Faulty or Incorrect Items</h2>
<p>If you receive an item that is faulty, damaged, or different from what you ordered, contact us within 48 hours of delivery with photos of the item and its packaging. We will arrange a replacement, exchange, or full refund, including return shipping, at no cost to you.</p>

<h2>Contact</h2>
<p>Questions about a return, exchange, or refund can be sent through our Contact page, or directly to the phone number and email listed there.</p>
';
}

<?php
/**
 * Legal page copy consumed by inc/content-importer.php.
 * Adapted for a Ghana-based technology SERVICES business (not a
 * shippable-goods retailer) — "Shipping Policy" is reframed as a
 * Service Delivery Policy, and refunds are framed around service
 * cancellation rather than physical returns.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mor_get_legal_pages() {
	return array(
		array(
			'slug'    => 'shipping-policy',
			'title'   => 'Service Delivery Policy',
			'content' => mor_legal_service_delivery_policy(),
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
			'title'   => 'Refunds & Cancellation Policy',
			'content' => mor_legal_refunds_policy(),
		),
	);
}

function mor_legal_service_delivery_policy() {
	return '
<p>This Service Delivery Policy explains how DigitalDrum Networks schedules, delivers, and confirms completion of the technology support services booked through this website. Because we sell bookable services rather than shippable physical goods, this policy covers appointment scheduling and service turnaround rather than package delivery — please read it alongside our Terms and Conditions and our Refunds &amp; Cancellation Policy.</p>

<h2>Service Areas</h2>
<p>On-site services (hardware repair, network cabling, CCTV and access control installation, and similar in-person work) are currently offered within Accra and its immediate surrounding areas, based from our office on Nii Amo Street, Osu, Accra. If your location falls outside our normal service radius, contact us before booking — we may still be able to accommodate the visit for an additional travel charge, agreed with you in advance, or we may recommend booking a remote service instead where the work allows it. Remote services (software troubleshooting, malware removal, cloud backup setup, and similar work that doesn\'t require physical access to hardware) are available to clients anywhere with a stable internet connection, though our support is provided in English and our working hours follow Ghana time (GMT).</p>

<h2>Scheduling and Confirmation</h2>
<p>When you book a service through checkout, this confirms your order but not yet a specific appointment time. Within one business day of your order, we contact you by phone or email using the details provided at checkout to agree on a specific date and time for remote sessions or on-site visits. For time-sensitive requests, please say so in the order notes at checkout, or call us directly — we prioritise urgent requests where we reasonably can, though this cannot always be guaranteed outside business hours.</p>

<h2>Response and Turnaround Times</h2>
<p>Typical response and turnaround times, measured from the point a specific appointment is confirmed, are as follows. These are typical timeframes based on normal workload, not contractual guarantees, since actual diagnostic and repair time can vary once a technician has assessed the specific problem in front of them:</p>
<ul>
<li>Remote support sessions: usually scheduled within 24 hours of confirming a time, often same-day during business hours.</li>
<li>On-site visits within Accra: usually scheduled within 24–48 hours of confirming a booking.</li>
<li>Hardware diagnostics and repairs: diagnostic results typically provided within a few hours of drop-off or on-site assessment; repair turnaround depends on the fault found and whether replacement parts need to be sourced.</li>
<li>Larger installation jobs (structured cabling, multi-camera CCTV, access control systems): scheduled following a scoping conversation, since the work itself may span more than one visit depending on the size of the job.</li>
</ul>

<h2>Delays</h2>
<p>Where a scheduled appointment needs to be delayed on our side — due to technician availability, a prior job running longer than expected, or a parts delay for a repair — we will contact you as early as possible using the phone number or email on your order, and offer the next available time. We do not consider a delay of a few hours within the same scheduled day to require a full policy claim, but any delay of more than one full business day beyond the originally confirmed appointment entitles you to reschedule at no cost or cancel that specific service for a full refund under our Refunds &amp; Cancellation Policy.</p>

<h2>Parts and Equipment</h2>
<p>Where a service requires physical parts or equipment (for example, a replacement SSD, network cabling, or a CCTV camera), unless the service listing explicitly states parts are included, you are responsible for sourcing or purchasing the part separately, and we will advise on compatible options before you buy. Where we do supply parts or equipment as part of a listed service, expected lead time for sourcing that equipment will be communicated to you before the job is scheduled, and any delay in sourcing equipment beyond our stated estimate will be communicated promptly, with the option to reschedule or cancel that portion of the order.</p>

<h2>Failed Access for On-Site Visits</h2>
<p>For on-site appointments, please ensure someone authorised is available at the agreed location at the scheduled time. If our technician arrives and cannot gain access to the property, and we are not notified of a delay or access issue in advance, this may be treated as a missed appointment under our Refunds &amp; Cancellation Policy, which may include a call-out fee to cover technician time and travel.</p>

<h2>Contact</h2>
<p>Questions about scheduling or an active booking can be sent through our contact form or directly to the phone number and email listed on our Contact page.</p>
';
}

function mor_legal_privacy_policy() {
	return '
<p>This Privacy Policy explains what personal information DigitalDrum Networks ("we", "us", "our") collects through this website, how we use and store it, who we share it with, and the rights you have over it. We process personal data in line with Ghana\'s Data Protection Act, 2012 (Act 843), and this policy is written to reflect the obligations that Act places on us as a data controller.</p>

<h2>Information We Collect</h2>
<p>We collect personal information in a small number of specific ways:</p>
<ul>
<li><strong>Contact form submissions:</strong> the name, email address, and message content you submit through our Contact page.</li>
<li><strong>Checkout and order information:</strong> when you book a service through WooCommerce checkout, we collect your name, email address, phone number, billing address, and details of the service(s) ordered, as required to process and fulfil your booking.</li>
<li><strong>Account information:</strong> if you create an account, we store your account details and order history so you can log in and view past bookings.</li>
<li><strong>Technical information:</strong> standard server logs (such as IP address, browser type, and pages visited) collected automatically as part of normal website operation, used for security and troubleshooting rather than individual tracking.</li>
</ul>
<p>We do not knowingly collect information from anyone we are aware is under the age of 18. If you believe a minor has provided us with personal information, please contact us so we can remove it.</p>

<h2>How We Use Your Information</h2>
<p>We use the information collected for the following purposes only:</p>
<ul>
<li>To process, confirm, and deliver the services you book, including contacting you to schedule appointments.</li>
<li>To respond to messages sent through our contact form.</li>
<li>To send order-related communications, such as booking confirmations and service updates.</li>
<li>To maintain accurate records for accounting, tax, and legal compliance purposes.</li>
<li>To improve our website and services based on aggregated, non-identifying usage patterns.</li>
</ul>
<p>We do not use your personal information for automated decision-making that produces legal or similarly significant effects, and we do not sell your personal information to third parties.</p>

<h2>How We Store and Protect Your Information</h2>
<p>Your information is stored on the servers of our website hosting provider and, for payment processing, the servers of our WooCommerce payment gateway provider(s). We do not store full payment card details on our own servers — card and mobile money payment data is handled directly by our configured payment gateway, in line with that provider\'s own security standards. We restrict access to personal information within our business to staff who need it to fulfil your order or respond to your enquiry, and we take reasonable technical measures (such as access controls and secure hosting) to protect stored data against unauthorised access, loss, or misuse.</p>

<h2>Sharing With Third Parties</h2>
<p>We share personal information with third parties only where necessary to operate this website and fulfil your order:</p>
<ul>
<li><strong>Payment gateway providers</strong>, to process payment for your booking.</li>
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
<p>These Terms and Conditions govern your use of this website and any service booked through it from DigitalDrum Networks ("we", "us", "our"), a technology support services business operating from Nii Amo Street, Osu, Accra, Ghana. By using this website or booking a service, you agree to these terms.</p>

<h2>Use of This Site</h2>
<p>You may use this website to browse our services, make bookings, and contact us. You agree not to use the site for any unlawful purpose, to attempt to gain unauthorised access to any part of the site or its underlying systems, to submit false or misleading information when booking a service, or to use automated tools to scrape or interfere with normal operation of the site. We reserve the right to suspend or refuse service to anyone who misuses the site.</p>

<h2>Accounts</h2>
<p>If you create an account, you are responsible for keeping your login details confidential and for all activity that occurs under your account. Notify us immediately if you believe your account has been accessed without authorisation.</p>

<h2>Order Acceptance</h2>
<p>Placing an order through checkout is an offer to purchase a service, which we accept when we confirm your booking by contacting you to schedule an appointment, as described in our Service Delivery Policy. We reserve the right to decline or cancel an order — for example, where a service falls outside our current service area, where we cannot reasonably fulfil the specific request described, or where payment cannot be verified — in which case any payment already made will be refunded in full.</p>

<h2>Pricing and Payment</h2>
<p>All prices on this website are listed in Ghanaian Cedis (GHS) and are inclusive of any taxes unless stated otherwise at checkout. The USD amount shown when the currency switcher is set to USD is a reference conversion only, calculated using a periodically updated exchange rate, and is not the amount actually charged — all payments are processed in GHS. Payment is required at the time of booking through the payment methods available at checkout.</p>

<h2>Pricing Errors</h2>
<p>While we make reasonable efforts to ensure prices displayed on this website are accurate, errors can occur — for example, due to a technical fault or manual data entry mistake. If we discover a pricing error on an order you have already placed, we will contact you before proceeding, and you will have the option to proceed at the correct price or cancel the order for a full refund. We are not obligated to fulfil an order at an incorrectly displayed price where that error is reasonably obvious (for example, a service listed at an amount clearly inconsistent with its normal pricing).</p>

<h2>Service Descriptions</h2>
<p>We describe each service on this website as accurately as we can, including what is and is not included (for example, whether parts are included in a hardware service). Because technical support work often depends on the specific condition of your device or network, the description for a listed service reflects the standard scope of that service — if your situation requires additional work beyond that standard scope, we will discuss and agree any additional cost with you before carrying out extra work.</p>

<h2>Intellectual Property</h2>
<p>All content on this website — including text, images, logos, and design — is owned by DigitalDrum Networks or used under licence, and is protected by applicable copyright and intellectual property law. You may not copy, reproduce, or reuse content from this site for commercial purposes without our prior written permission.</p>

<h2>Third-Party Software and Licensing</h2>
<p>Where our services involve installing or configuring third-party software, you are responsible for holding a valid licence for that software unless a service listing explicitly states licensing is included. We are not responsible for the ongoing performance, updates, or support of third-party software beyond the scope of the specific service booked.</p>

<h2>Limitation of Liability</h2>
<p>We take reasonable care in performing all services, but technology work carries inherent risk — for example, data loss during a repair, or a pre-existing hardware fault becoming apparent during a service. To the fullest extent permitted by Ghanaian law, our liability for any claim arising from a service booked through this site is limited to the amount paid for that specific service. We are not liable for indirect or consequential losses, such as lost business income, except where such liability cannot be excluded by law. We strongly recommend maintaining your own independent backup of important data before any hardware or software service, and our Service Delivery Policy and individual service descriptions note where backup is included as part of a specific service.</p>

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
<p>This Refunds &amp; Cancellation Policy explains how cancellations, rescheduling, and refunds work for services booked through DigitalDrum Networks. Because we provide services rather than shippable physical goods, this policy is built around service cancellation and satisfaction rather than a physical product return window — please read it alongside our Service Delivery Policy and Terms and Conditions.</p>

<h2>Cancelling Before an Appointment Is Scheduled</h2>
<p>If you cancel your order before we have contacted you to confirm a specific appointment time, you are entitled to a full refund with no deduction, processed within 7 business days to your original payment method.</p>

<h2>Cancelling or Rescheduling After an Appointment Is Confirmed</h2>
<p>Once a specific appointment time has been confirmed, the following applies:</p>
<ul>
<li><strong>More than 24 hours\' notice:</strong> you may cancel for a full refund, or reschedule to a new time at no additional cost, with no restriction on the number of times you reschedule for legitimate reasons.</li>
<li><strong>Less than 24 hours\' notice:</strong> a cancellation fee of 20% of the service price may be deducted from your refund to cover technician scheduling that could not be reallocated in time. You may instead choose to reschedule at no cost rather than cancel, which avoids this fee entirely.</li>
<li><strong>Missed appointment (on-site visits):</strong> if our technician arrives at the agreed location and cannot gain access, and we were not notified in advance, this is treated as a missed appointment. A call-out fee of up to 30% of the service price may be deducted from any refund to cover technician time and travel already incurred.</li>
</ul>

<h2>Cancellations Caused By Us</h2>
<p>If we need to cancel or significantly delay your appointment (beyond one full business day past the confirmed time) due to circumstances on our side, you are entitled to a full refund with no deduction, or to reschedule at no cost — the choice is yours.</p>

<h2>Refunds for Completed Services</h2>
<p>If a completed service does not resolve the problem it was booked to address, contact us within 7 days of the service being completed. We will first offer a follow-up visit or session at no additional charge to correct the issue, since in most cases a follow-up correction is the fastest resolution. If, after a reasonable follow-up attempt, the service genuinely could not be delivered to a reasonable standard, we will refund the affected portion of the service price. Refunds for completed services are assessed case by case, based on what was actually deliverable given the condition of your device, network, or site — for example, a diagnostic service that correctly identifies a hardware fault has been delivered as described even if the news itself is unwelcome, and is not eligible for a "problem not fixed" refund in the same way an incomplete repair would be.</p>

<h2>Non-Refundable Items</h2>
<p>The following are not eligible for refund once work has begun or been completed:</p>
<ul>
<li>Diagnostic fees for a diagnostic that was completed and accurately reported, regardless of whether the news was welcome.</li>
<li>The portion of any service already completed at the time of a cancellation request (for example, if two of three cabling runs in a multi-run job are already finished).</li>
<li>Third-party parts or equipment already purchased on your behalf at your request and confirmation, once purchased.</li>
<li>Software licence fees paid to a third-party vendor as part of a licensing support service, once the licence has been activated.</li>
</ul>

<h2>How Refunds Are Processed</h2>
<p>Approved refunds are processed to your original payment method within 7 business days of approval. Depending on your bank or mobile money provider, it may take a few additional days for the refund to reflect in your account after we process it on our end — this part of the timing is outside our control.</p>

<h2>Exchanges</h2>
<p>Since our services are not physical goods, there is no like-for-like "exchange" in the retail sense. Where a booked service turns out to be the wrong fit for your actual problem — for example, you booked a software troubleshooting session but the issue turns out to be hardware failure — we will apply any amount already paid toward the correct service instead, so you are not paying twice for a straightforward mismatch identified early in the visit.</p>

<h2>How to Request a Cancellation or Refund</h2>
<p>Send your order number along with your request through our Contact page, or contact us directly by phone or email. We aim to respond to all cancellation and refund requests within 1 business day.</p>
';
}

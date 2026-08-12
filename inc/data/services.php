<?php
/**
 * Service catalog data consumed by inc/content-importer.php.
 * Prices in GHS, chosen to land roughly within a $9–$50 equivalent
 * range at the MOR_GHS_TO_USD_RATE conversion constant.
 *
 * 'image' keys reference files in assets/images/services/ — several
 * services intentionally share the same photo where they're visually
 * the same kind of job (e.g. two laptop-hardware services), rather
 * than forcing 20 artificially distinct stock photos.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mor_get_service_catalog() {
	return array(
		array(
			'sku'         => 'DDN-001',
			'name'        => 'Remote PC Troubleshooting Session',
			'price'       => 150,
			'image'       => 'service-remote-support.jpg',
			'description' => 'A one-hour remote support session for a slow, misbehaving, or error-throwing Windows or macOS computer. We connect securely over a remote-desktop tool with your permission, diagnose what\'s actually causing the slowdown or error — startup bloat, failing background processes, driver conflicts, disk issues, or a misconfigured update — and fix what we can within the session. If the problem turns out to need a hardware repair or full reinstall, we\'ll tell you plainly rather than charging for a fix that can\'t work remotely, and quote the right follow-up service instead. This is the service most of our clients book first: no waiting for an on-site visit, no need to unplug and carry your machine anywhere, and no guesswork about what\'s wrong before we even start. You\'ll get a short plain-English summary of what was found and what was done at the end of the session, so you know what changed and whether to expect it to happen again.',
		),
		array(
			'sku'         => 'DDN-002',
			'name'        => 'Virus & Malware Removal',
			'price'       => 250,
			'image'       => 'service-remote-support.jpg',
			'description' => 'Full malware, adware, and virus removal for an infected Windows or macOS device, done remotely or on-site depending on severity. We start with a full system scan using multiple detection engines (a single antivirus often misses what another catches), isolate and remove the infection, check for persistence mechanisms that let malware survive a normal scan-and-delete, and reset browser settings that are commonly hijacked — homepage, search engine, and extensions. For infections tied to compromised accounts, we\'ll also walk you through securing your email and any accounts that may have been accessed while the device was infected. Afterward we install and configure a reputable free or paid antivirus suited to how you use the device, and explain the specific habit — a download source, an email attachment, a cracked software install — that most likely caused the infection, so it doesn\'t happen again. If your files were encrypted by ransomware, we\'ll assess recovery options honestly before any work begins, since not every ransomware case is recoverable without payment, and we won\'t charge for an assessment that turns out negative.',
		),
		array(
			'sku'         => 'DDN-003',
			'name'        => 'OS Reinstallation & Data Backup',
			'price'       => 350,
			'image'       => 'service-laptop-repair.jpg',
			'description' => 'A clean Windows or macOS reinstallation with full data backup beforehand, for a device that\'s become too slow, corrupted, or cluttered to fix through troubleshooting alone. We back up your documents, photos, browser bookmarks and saved passwords, and key application settings to an external drive or cloud storage of your choice before touching anything, verify the backup is complete and readable, then perform a clean install of the operating system, reinstall your essential applications, and restore your files and settings. We also apply all pending security updates during setup rather than leaving that for later, and configure basic protections — firewall, automatic updates, an antivirus if you don\'t already have one — as part of the job. This service is usually the right call when a machine has been slow for months despite repeated cleanup attempts, has driver or system file corruption that\'s hard to pin down, or is being handed to a new user and needs a genuinely fresh start. Turnaround is typically same-day for a standard setup; a machine with a very large amount of data to back up may take longer, and we\'ll tell you upfront if that applies to yours.',
		),
		array(
			'sku'         => 'DDN-004',
			'name'        => 'Laptop Hardware Diagnostic',
			'price'       => 200,
			'image'       => 'service-laptop-repair.jpg',
			'description' => 'An on-site or drop-off diagnostic for a laptop with a physical problem — a cracked or flickering screen, a battery that no longer holds charge, a keyboard with dead keys, unusual noise from the fan, or a machine that won\'t power on at all. We run it through a structured hardware check covering the display, battery health and charging circuit, keyboard and trackpad, storage drive health (including a check for early failure warning signs), thermal performance, and ports, and give you a written breakdown of exactly what\'s failing and what it would cost to repair versus what the laptop is realistically worth keeping. This is a diagnostic-only service — we don\'t start repair work or order parts without your sign-off on the quote it produces — so there\'s never a surprise bill after the fact. Most diagnostics are completed within a few hours of drop-off; a no-power fault can sometimes take longer to isolate since it usually means testing the charging circuit, battery, and motherboard separately to find the actual point of failure rather than the visible symptom.',
		),
		array(
			'sku'         => 'DDN-005',
			'name'        => 'Home Wi-Fi Setup & Optimization',
			'price'       => 300,
			'image'       => 'service-networking.jpg',
			'description' => 'On-site setup and optimization of your home Wi-Fi network, covering router placement, channel and frequency-band configuration, a proper WPA3/WPA2 security setup with a strong password, and a guest network so visitors don\'t need your main password. If your home has dead zones — rooms where the signal barely reaches — we test coverage room by room and recommend the right fix, whether that\'s repositioning the router, adding a mesh extender, or running an Ethernet backhaul where that\'s more reliable than another Wi-Fi hop. We also rename your network and password to something secure but memorable, disable outdated and insecure protocols the router may still have switched on by default, and check that firmware is up to date, since outdated router firmware is one of the more common security gaps in home networks we see in Accra. By the end of the visit you\'ll have full coverage across your home, a network you understand how to manage yourself, and a written note of your network name, password, and admin login stored somewhere safe — not just in our heads.',
		),
		array(
			'sku'         => 'DDN-006',
			'name'        => 'Small Office Network Cabling (per room)',
			'price'       => 600,
			'image'       => 'service-networking.jpg',
			'description' => 'Structured Ethernet cabling for a single office room — running and terminating Cat6 cable from your network switch or patch panel to wall points or desk drops, so devices that need a stable wired connection (desktops, printers, POS terminals, VoIP phones) aren\'t relying on Wi-Fi. This price covers one room with up to four cable runs; larger rooms or additional runs are quoted after a short site visit, since the amount of cable, conduit, and labor depends heavily on your office layout and whether cabling needs to run through walls, ceilings, or trunking. We test every cable run after termination to confirm it meets gigabit performance before we consider the job done, label both ends clearly at the wall point and the patch panel, and tidy cable runs so they\'re safe and don\'t become a trip hazard or an eyesore. Wired connections are consistently faster and more stable than Wi-Fi for anything doing continuous heavy traffic — file transfers, video calls, point-of-sale systems — so this is a common first upgrade for small offices that started out entirely on Wi-Fi and have started noticing slowdowns as more devices were added.',
		),
		array(
			'sku'         => 'DDN-007',
			'name'        => 'Router & Firewall Configuration',
			'price'       => 280,
			'image'       => 'service-networking.jpg',
			'description' => 'Configuration of your router\'s firewall and network-level security settings, for home or small-office use. We review and tighten the default settings most routers ship with — closing unnecessary open ports, disabling remote administration unless you specifically need it, setting up network address translation and firewall rules appropriate to how your network is used, and configuring VLANs to separate guest, staff, and device traffic where that\'s useful for a small office. If you run any services that need to be reachable from outside your network — a security camera system, a remote-access tool, a small server — we configure port forwarding and firewall rules narrowly around just those services rather than opening the network broadly. We also check for common configuration mistakes we see often: default admin passwords never changed, UPnP left enabled unnecessarily, and outdated firmware. You\'ll get a plain summary at the end of what was changed and why, plus recommendations for anything that needs attention but falls outside this service\'s scope — for example, if we find your router hardware itself is too old to support modern security standards properly.',
		),
		array(
			'sku'         => 'DDN-008',
			'name'        => 'CCTV Camera Installation (per camera)',
			'price'       => 500,
			'image'       => 'service-cctv.jpg',
			'description' => 'Installation of a single CCTV camera, priced per camera for straightforward multi-camera jobs. This covers mounting the camera in the agreed position, running cabling back to your recorder or network switch, connecting it to your existing recording system (or helping you choose a suitable one if you don\'t have one yet), and configuring the camera\'s image settings — angle, focus, and night-vision if supported — for a genuinely usable picture rather than just "on and recording." For networked (IP) cameras we also set up remote viewing on your phone if you\'d like it, with a properly secured connection rather than the manufacturer\'s default credentials left unchanged, which is one of the most common ways home and office CCTV systems get compromised. Cable routing is planned to be as unobtrusive and weatherproof as the location allows for outdoor cameras. If you\'re installing several cameras at once, we\'ll do a short walk-through first to plan camera positions for the best coverage of entrances, parking, and blind spots before any drilling or cabling starts, since repositioning after installation is far more work than getting placement right the first time.',
		),
		array(
			'sku'         => 'DDN-009',
			'name'        => 'Access Control System Setup (single door)',
			'price'       => 700,
			'image'       => 'service-cctv.jpg',
			'description' => 'Installation and configuration of a keycard, fob, or PIN-based access control system for a single door — a common upgrade for small offices, shops, and rented commercial units that want to stop relying on shared physical keys. This covers mounting the reader and electronic lock or strike, wiring it to a controller, and setting up the management software so you can add and remove users, see an access log of who entered and when, and revoke a lost card or a departing employee\'s access immediately rather than having to change locks. We configure a sensible default schedule (for example, locked outside business hours) and show you how to adjust it yourself. For offices that already have CCTV installed with us, we can tie access events into the same monitoring setup so a door-open event and camera footage line up, though that\'s a separate configuration step beyond the base installation. This service covers one door; additional doors on the same system are quoted together since shared controller and software setup makes each additional door proportionally cheaper than a standalone job.',
		),
		array(
			'sku'         => 'DDN-010',
			'name'        => 'Printer & Scanner Network Setup',
			'price'       => 180,
			'image'       => 'service-office-setup.jpg',
			'description' => 'Setup of a printer or scanner so every authorized device on your network can use it, instead of one computer being the only machine that can print. We connect the device to your network (wired or Wi-Fi, whichever the hardware and your setup supports better), install and configure drivers on each computer or device that needs access, and set up scan-to-email or scan-to-folder if your scanner supports it, so scanned documents land exactly where you need them without manual transfers. For offices sharing a printer among several staff, we also configure basic print-queue management so one large job doesn\'t block everyone else, and set default settings — paper size, duplex printing — so staff aren\'t reconfiguring the same options every time. If your printer is an older model without native network support, we\'ll advise honestly on whether a network print-server adapter is worth adding or whether the printer has reached the point where replacing it is the more sensible option, rather than pushing a workaround on hardware that\'s already struggling.',
		),
		array(
			'sku'         => 'DDN-011',
			'name'        => 'Business Email & Domain Setup',
			'price'       => 320,
			'image'       => 'service-office-setup.jpg',
			'description' => 'Setup of professional business email on your own domain (for example, you@yourbusiness.com instead of a free personal email address), using a hosted email provider suited to your business size. This covers domain verification, mailbox creation for your team, mail routing (MX, SPF, DKIM, and DMARC records) configured correctly so your emails are less likely to land in spam, and setup on each team member\'s phone and computer. We also set up shared or role-based addresses where useful — an info@ or sales@ address that routes to the right people — and a basic email signature template so your team\'s outgoing mail looks consistent. Getting the underlying domain records right matters more than people expect: a poorly configured SPF or DKIM record is one of the most common reasons a small business\'s legitimate emails get marked as spam by client inboxes, so we verify deliverability after setup rather than assuming the defaults are fine. If you don\'t yet own a domain, we can help you register one as part of this service, priced separately based on the domain provider\'s registration fee.',
		),
		array(
			'sku'         => 'DDN-012',
			'name'        => 'Point-of-Sale (POS) System Installation',
			'price'       => 450,
			'image'       => 'service-office-setup.jpg',
			'description' => 'Installation and configuration of a point-of-sale system for a shop, restaurant, or small retail business — hardware setup (terminal, receipt printer, barcode scanner, and cash drawer where applicable), software installation, and initial configuration of your product catalog, tax settings, and staff user accounts with appropriate permission levels. We connect the system to your existing network and, where the software supports it, set up basic sales reporting so you can see daily takings and top-selling items without manual tallying. Staff training is included for up to three team members so your till operators are comfortable with the day-to-day workflow — ringing up sales, processing returns, opening the cash drawer correctly — before we leave. If you\'re moving from a paper-based or manual system, we\'ll also help plan the cutover so it happens at a quiet time for your business rather than mid-rush. This service covers standard single-terminal setups; multi-terminal installations or integration with existing accounting software are quoted separately once we understand which systems need to talk to each other.',
		),
		array(
			'sku'         => 'DDN-013',
			'name'        => 'Data Recovery Service (Standard)',
			'price'       => 400,
			'image'       => 'service-data-recovery.jpg',
			'description' => 'Standard data recovery for a hard drive, SSD, USB drive, or memory card that\'s become inaccessible due to accidental deletion, formatting, a corrupted file system, or early-stage drive failure that still allows the device to be read. We run diagnostic tools first to assess how recoverable the data actually is and give you an honest estimate before committing to full recovery work — we don\'t charge the full recovery fee for a job we can already tell won\'t succeed. Recovered files are copied to a drive of your choice (yours or one we provide for an additional cost) rather than left on our equipment, and we verify a sample of recovered files actually opens correctly before handing the job back. This standard tier covers logically damaged drives — deletion, formatting, corruption — where the drive itself still spins up and is readable by diagnostic tools. Physically damaged drives (clicking noises, water damage, drives that won\'t power on) need specialist lab recovery that we don\'t perform in-house; if your diagnostic falls into that category, we\'ll tell you plainly and can refer you appropriately rather than attempting a recovery method likely to make things worse.',
		),
		array(
			'sku'         => 'DDN-014',
			'name'        => 'Cybersecurity Audit for Small Business',
			'price'       => 650,
			'image'       => 'service-cybersecurity.jpg',
			'description' => 'A structured security review of your small business\'s network, devices, and common weak points, aimed at businesses that have never had a formal audit and want to know where they actually stand. We review your Wi-Fi and router security, check for outdated software and unpatched systems across your devices, look at password practices and whether shared logins are being used where individual accounts would be safer, review email security settings (a common entry point for business email compromise scams), and check whether backups exist and actually work if you needed them. You\'ll receive a written report ranking findings by real-world risk — not a wall of jargon — along with clear next steps for each item, separated into what you can fix yourself immediately at no cost, and what would need a follow-up paid service like our network configuration or backup setup offerings. This audit doesn\'t include penetration testing or active exploitation of vulnerabilities, which is a specialist service beyond this scope; it\'s a practical baseline review suited to a business that has never had one, not an evaluation for a business already running mature security operations.',
		),
		array(
			'sku'         => 'DDN-015',
			'name'        => 'Cloud Backup Setup & Configuration',
			'price'       => 260,
			'image'       => 'service-cybersecurity.jpg',
			'description' => 'Setup of automatic cloud backup for your important files, so you\'re not depending on a single laptop, external drive, or a memory that you meant to back something up "eventually." We help you choose a cloud backup provider suited to how much data you have and your budget, install and configure the backup client on your devices, set which folders and file types are included, and configure a sensible backup schedule that runs automatically in the background without you having to remember to trigger it. Once set up, we run a test restore of a sample file to confirm the backup actually works end-to-end — a backup that\'s never been tested to restore is not a backup you can trust in an emergency, which is a mistake we see often. For small businesses, we can also configure shared or team backup coverage so critical business files aren\'t sitting only on one person\'s laptop. This service covers setup and configuration of one backup solution across up to three devices; larger fleets of devices or business-wide backup strategy planning are scoped separately.',
		),
		array(
			'sku'         => 'DDN-016',
			'name'        => 'Laptop RAM/SSD Upgrade (parts not included)',
			'price'       => 220,
			'image'       => 'service-laptop-repair.jpg',
			'description' => 'Installation labor for a RAM or SSD upgrade on a laptop that supports user-upgradeable components — this service covers the installation, data migration from your old drive if you\'re upgrading storage, and a working-order test afterward; the RAM or SSD part itself is not included and should be purchased separately (we\'re happy to recommend compatible options for your specific laptop model before you buy). We check your laptop\'s upgrade compatibility first — not every laptop has accessible RAM slots or supports a straightforward drive swap, particularly newer ultra-thin models with soldered memory — so you\'re not paying for parts that turn out to be incompatible. For an SSD upgrade replacing a mechanical hard drive, we clone your existing drive to the new one so you keep your operating system, applications, and files exactly as they were, rather than needing a fresh install, unless you\'d prefer a clean setup instead. Most RAM or single-drive SSD upgrades are completed within an hour once the correct part is on hand; we\'ll flag upfront if your specific model needs a longer teardown to reach the components.',
		),
		array(
			'sku'         => 'DDN-017',
			'name'        => 'VoIP Phone System Setup',
			'price'       => 480,
			'image'       => 'service-office-setup.jpg',
			'description' => 'Setup of a VoIP (voice-over-internet) phone system for your office, replacing or supplementing traditional phone lines with calls that run over your internet connection. This covers choosing a VoIP provider and plan suited to your call volume, configuring handsets or softphone apps for your team, setting up call routing (which numbers ring which extensions, and how calls are handled outside business hours), and configuring voicemail and, where needed, a basic auto-attendant menu for incoming calls. We test call quality on your actual office network before finishing the job, since VoIP call quality depends heavily on your internet connection\'s stability and available bandwidth — if we find your current connection isn\'t reliable enough for good call quality, we\'ll tell you before you commit to a VoIP plan rather than after you\'ve started experiencing dropped calls. For offices with an existing analog phone system, we can advise on whether a full VoIP switch or a hybrid approach makes more sense given your equipment and contracts already in place.',
		),
		array(
			'sku'         => 'DDN-018',
			'name'        => 'Server Health Check & Maintenance',
			'price'       => 550,
			'image'       => 'service-cybersecurity.jpg',
			'description' => 'A hands-on health check and maintenance pass for a small business server — whether it\'s a dedicated file server, a machine running shared business software, or a repurposed desktop doing server duty. We check disk health and available storage, review installed updates and patch anything outstanding, verify scheduled backups are actually running and succeeding (not just configured and forgotten), check system logs for recurring errors that indicate a developing problem, and review user accounts and permissions for anything that looks like it\'s been left over-permissioned from a past setup. We also check physical conditions where relevant — temperature, dust buildup in cooling, and whether the server is on a reliable power supply or UPS — since hardware failure from heat or dust is a common and preventable cause of unplanned downtime. You\'ll get a written summary of what was checked, what was fixed on the spot, and what needs a scheduled follow-up (for example, a drive showing early failure warnings that should be replaced proactively rather than waited out). This is a maintenance and diagnostic service, not a full server migration or rebuild.',
		),
		array(
			'sku'         => 'DDN-019',
			'name'        => 'Software Installation & Licensing Support',
			'price'       => 140,
			'image'       => 'service-remote-support.jpg',
			'description' => 'Installation and licensing setup for business or personal software — accounting packages, design tools, industry-specific business software, or productivity suites — done remotely or on-site depending on what\'s easiest for you. We install the software correctly for your operating system, activate and register your license properly (including help locating a lost license key where that\'s recoverable through the vendor), configure initial settings sensibly for how you\'ll actually use it, and check for common post-install issues like missing dependencies or permission errors before considering the job done. For software licensed per-user or per-device, we also help you keep track of which license is assigned where, which matters more than people expect once a business has more than a couple of paid software subscriptions running. This service covers installation and setup, not ongoing software training — for software you want your team to actually learn to use well, that\'s a separate conversation we\'re happy to have, since a good installation with no follow-up training often gets used at a fraction of its potential.',
		),
		array(
			'sku'         => 'DDN-020',
			'name'        => 'Annual IT Support Retainer Consultation',
			'price'       => 700,
			'image'       => 'service-office-setup.jpg',
			'description' => 'A structured consultation to scope an ongoing IT support retainer for your business — this booking covers the initial assessment and proposal, not a full year of support itself (retainer pricing depends on your device count, network complexity, and how much support your business typically needs, so it can\'t be sold as a fixed product). We walk through your current setup — devices, network, software, backups, and past pain points — and put together a proposed retainer scope covering things like priority response times, a set number of included remote and on-site visits per month, and proactive maintenance instead of only reactive fixes when something breaks. For businesses that have been calling us in piecemeal for individual services, this consultation is usually where we can show concretely whether a retainer would actually save money compared to paying per-incident, rather than assuming it automatically will. There\'s no obligation to sign up for an ongoing retainer after this consultation — if it turns out per-incident support genuinely suits your business better, we\'ll say so rather than push a retainer that doesn\'t make sense for you.',
		),
	);
}

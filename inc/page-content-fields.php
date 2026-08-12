<?php
/**
 * "Page Content" meta boxes for the Home and Contact pages.
 *
 * template-home.php and page-contact.php render a fixed structure rather
 * than the page's post_content, so editing those pages in the normal
 * block editor previously had no visible effect. This registers plain
 * WordPress custom-field meta boxes (core add_meta_box(), no plugin) on
 * those two pages so the text and images they display are editable from
 * the standard Edit Page screen. Every field falls back to the original
 * hardcoded copy when left blank, so an un-edited site looks identical
 * to before this existed.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MOR_PAGE_FIELDS_NONCE', 'mor_page_fields_nonce' );
define( 'MOR_PAGE_FIELDS_NONCE_ACTION', 'mor_save_page_fields' );

/**
 * Read a page content field, falling back to $default when it has never
 * been set (or was cleared) by an editor.
 */
function mor_get_page_field( $post_id, $key, $default = '' ) {
	$value = get_post_meta( $post_id, $key, true );
	return ( '' !== $value && null !== $value ) ? $value : $default;
}

/**
 * Field schema for each template. type: text | textarea | image.
 */
function mor_home_field_groups() {
	return array(
		'mor_home_hero'     => array(
			'title'  => __( 'Page Content — Hero', 'mor-websites' ),
			'fields' => array(
				'mor_home_hero_tagline' => array(
					'label'   => __( 'Tagline', 'mor-websites' ),
					'type'    => 'textarea',
					'default' => __( 'Dependable IT support, network setup, and device repair for homes and businesses across Accra — booked online, delivered on time.', 'mor-websites' ),
				),
				'mor_home_hero_image'   => array(
					'label' => __( 'Background Image', 'mor-websites' ),
					'type'  => 'image',
				),
			),
		),
		'mor_home_services' => array(
			'title'  => __( 'Page Content — Services', 'mor-websites' ),
			'fields' => array(
				'mor_home_services_heading'        => array(
					'label'   => __( 'Heading', 'mor-websites' ),
					'type'    => 'text',
					'default' => __( 'IT Support Built For', 'mor-websites' ),
				),
				'mor_home_services_heading_accent' => array(
					'label'   => __( 'Heading (accent second line)', 'mor-websites' ),
					'type'    => 'text',
					'default' => __( 'How Accra Works', 'mor-websites' ),
				),
				'mor_home_services_subheading'     => array(
					'label'   => __( 'Subheading', 'mor-websites' ),
					'type'    => 'textarea',
					'default' => __( 'From a single laptop to a full office network, every service below is scoped, priced, and bookable online.', 'mor-websites' ),
				),
				'mor_home_service1_title'          => array(
					'label'   => __( 'Service 1 — Title', 'mor-websites' ),
					'type'    => 'text',
					'default' => __( 'Network Setup & Cabling', 'mor-websites' ),
				),
				'mor_home_service1_desc'           => array(
					'label'   => __( 'Service 1 — Description', 'mor-websites' ),
					'type'    => 'textarea',
					'default' => __( 'Structured cabling, router and Wi-Fi configuration, and network upgrades for offices that have outgrown their original setup.', 'mor-websites' ),
				),
				'mor_home_service2_title'          => array(
					'label'   => __( 'Service 2 — Title', 'mor-websites' ),
					'type'    => 'text',
					'default' => __( 'Device & Hardware Repair', 'mor-websites' ),
				),
				'mor_home_service2_desc'           => array(
					'label'   => __( 'Service 2 — Description', 'mor-websites' ),
					'type'    => 'textarea',
					'default' => __( 'Laptop and desktop repair, security checks, and system tuning — handled remotely when possible, on-site when it isn\'t.', 'mor-websites' ),
				),
				'mor_home_service3_title'          => array(
					'label'   => __( 'Service 3 — Title', 'mor-websites' ),
					'type'    => 'text',
					'default' => __( 'CCTV & Business Systems', 'mor-websites' ),
				),
				'mor_home_service3_desc'           => array(
					'label'   => __( 'Service 3 — Description', 'mor-websites' ),
					'type'    => 'textarea',
					'default' => __( 'CCTV, access-control installation, and point-of-sale or booking systems that hold up for small-to-medium businesses.', 'mor-websites' ),
				),
			),
		),
		'mor_home_stats'    => array(
			'title'  => __( 'Page Content — Stats Strip', 'mor-websites' ),
			'fields' => array(
				'mor_home_stat1_value' => array( 'label' => __( 'Stat 1 — Value', 'mor-websites' ), 'type' => 'text', 'default' => __( 'Same-Week', 'mor-websites' ) ),
				'mor_home_stat1_label' => array( 'label' => __( 'Stat 1 — Label', 'mor-websites' ), 'type' => 'text', 'default' => __( 'Average Turnaround', 'mor-websites' ) ),
				'mor_home_stat2_value' => array( 'label' => __( 'Stat 2 — Value', 'mor-websites' ), 'type' => 'text', 'default' => __( 'Transparent', 'mor-websites' ) ),
				'mor_home_stat2_label' => array( 'label' => __( 'Stat 2 — Label', 'mor-websites' ), 'type' => 'text', 'default' => __( 'Pricing, No Surprise Call-Outs', 'mor-websites' ) ),
				'mor_home_stat3_value' => array( 'label' => __( 'Stat 3 — Value', 'mor-websites' ), 'type' => 'text', 'default' => __( 'Homes & SMEs', 'mor-websites' ) ),
				'mor_home_stat3_label' => array( 'label' => __( 'Stat 3 — Label', 'mor-websites' ), 'type' => 'text', 'default' => __( 'Across Accra', 'mor-websites' ) ),
			),
		),
		'mor_home_about'    => array(
			'title'  => __( 'Page Content — About', 'mor-websites' ),
			'fields' => array(
				'mor_home_about_heading' => array(
					'label'       => __( 'Heading', 'mor-websites' ),
					'type'        => 'text',
					'default'     => '',
					'description' => __( 'Leave blank to use "About [Company Name]" from Store Details.', 'mor-websites' ),
				),
				'mor_home_about_body'    => array(
					'label'       => __( 'Body', 'mor-websites' ),
					'type'        => 'textarea',
					'rows'        => 10,
					'default'     => '',
					'description' => __( 'Leave blank to use the default write-up. Separate paragraphs with a blank line.', 'mor-websites' ),
				),
				'mor_home_about_image'   => array(
					'label' => __( 'Image', 'mor-websites' ),
					'type'  => 'image',
				),
			),
		),
	);
}

function mor_contact_field_groups() {
	$faq_fields = array();
	for ( $i = 1; $i <= 5; $i++ ) {
		$faq_fields[ "mor_contact_faq{$i}_q" ] = array(
			/* translators: %d: FAQ item number */
			'label' => sprintf( __( 'FAQ %d — Question', 'mor-websites' ), $i ),
			'type'  => 'text',
		);
		$faq_fields[ "mor_contact_faq{$i}_a" ] = array(
			/* translators: %d: FAQ item number */
			'label' => sprintf( __( 'FAQ %d — Answer', 'mor-websites' ), $i ),
			'type'  => 'textarea',
		);
	}

	return array(
		'mor_contact_hero'  => array(
			'title'  => __( 'Page Content — Hero', 'mor-websites' ),
			'fields' => array(
				'mor_contact_hero_heading' => array(
					'label'   => __( 'Heading', 'mor-websites' ),
					'type'    => 'text',
					'default' => __( 'Get in Touch', 'mor-websites' ),
				),
				'mor_contact_hero_tagline' => array(
					'label'   => __( 'Tagline', 'mor-websites' ),
					'type'    => 'textarea',
					'default' => __( 'Questions about a service, an existing job, or a quote — reach us directly or send a message below.', 'mor-websites' ),
				),
			),
		),
		'mor_contact_hours' => array(
			'title'  => __( 'Page Content — Business Hours', 'mor-websites' ),
			'fields' => array(
				'mor_contact_hours' => array(
					'label'       => __( 'Business Hours', 'mor-websites' ),
					'type'        => 'textarea',
					'rows'        => 4,
					'default'     => __( "Monday – Friday: 8:00 AM – 6:00 PM\nSaturday: 9:00 AM – 3:00 PM\nSunday: Closed (emergency support requests only)", 'mor-websites' ),
					'description' => __( 'One line per row.', 'mor-websites' ),
				),
			),
		),
		'mor_contact_faq'   => array(
			'title'  => __( 'Page Content — FAQ', 'mor-websites' ),
			'fields' => $faq_fields,
		),
	);
}

/**
 * Default FAQ copy, used only when a FAQ field has never been edited.
 * Kept separate from the schema above since it's keyed by index rather
 * than expressed inline (5 fairly long answers).
 */
function mor_contact_faq_defaults() {
	return array(
		1 => array(
			'q' => __( 'How quickly can you respond to a service request?', 'mor-websites' ),
			'a' => __( 'Remote support requests submitted during business hours are typically picked up within 2 hours. On-site visits within Accra are usually scheduled within 24–48 hours of confirming your booking, depending on the service and technician availability. If you flag a request as urgent, we prioritise a same-day response wherever possible, though this cannot always be guaranteed outside business hours.', 'mor-websites' ),
		),
		2 => array(
			'q' => __( 'Can I cancel or reschedule a booked service?', 'mor-websites' ),
			'a' => __( 'Yes. You can cancel or reschedule any booked service package free of charge up to 24 hours before the scheduled appointment. Cancellations made with less than 24 hours\' notice, or missed appointments where our technician arrives on site and cannot gain access, may be subject to a call-out fee. Full details are in our Refunds & Cancellation Policy.', 'mor-websites' ),
		),
		3 => array(
			'q' => __( 'Do you provide remote support or only on-site visits?', 'mor-websites' ),
			'a' => __( 'Both. Many of our services — software troubleshooting, network configuration, security audits, and system optimisation — can be delivered remotely over a secure remote-desktop session. Hardware repairs, in-office network cabling, and CCTV/access-control installation require an on-site visit, which we currently offer within Accra and surrounding areas.', 'mor-websites' ),
		),
		4 => array(
			'q' => __( 'What payment methods do you accept?', 'mor-websites' ),
			'a' => __( 'Checkout accepts payment in Ghanaian Cedis (GHS). The specific payment gateways enabled (mobile money, card, or bank transfer) are configured directly in WooCommerce and may vary as we add providers — the checkout page will always show the options currently available at the time you book.', 'mor-websites' ),
		),
		5 => array(
			'q' => __( 'How do I track the status of my service request?', 'mor-websites' ),
			'a' => __( 'After checkout you\'ll receive an order confirmation by email with your booking reference. You can also log in to your account and view "My Account > Orders" at any time to see the current status of a booking. If a visit needs to be rescheduled on our side, we\'ll contact you directly using the phone number or email provided at checkout.', 'mor-websites' ),
		),
	);
}

function mor_page_is_home_template( $post ) {
	return $post && 'template-home.php' === get_post_meta( $post->ID, '_wp_page_template', true );
}

function mor_page_is_contact( $post ) {
	return $post && 'contact' === $post->post_name;
}

function mor_register_page_field_meta_boxes( $post_type, $post ) {
	if ( 'page' !== $post_type ) {
		return;
	}

	if ( mor_page_is_home_template( $post ) ) {
		foreach ( mor_home_field_groups() as $box_id => $box ) {
			add_meta_box( $box_id, $box['title'], 'mor_render_page_field_meta_box', 'page', 'normal', 'default', $box['fields'] );
		}
	} elseif ( mor_page_is_contact( $post ) ) {
		foreach ( mor_contact_field_groups() as $box_id => $box ) {
			add_meta_box( $box_id, $box['title'], 'mor_render_page_field_meta_box', 'page', 'normal', 'default', $box['fields'] );
		}
	}
}
add_action( 'add_meta_boxes', 'mor_register_page_field_meta_boxes', 10, 2 );

function mor_render_page_field_meta_box( $post, $meta_box ) {
	$fields = $meta_box['args'];

	wp_nonce_field( MOR_PAGE_FIELDS_NONCE_ACTION, MOR_PAGE_FIELDS_NONCE );

	foreach ( $fields as $key => $field ) {
		$value = get_post_meta( $post->ID, $key, true );
		?>
		<p>
			<label for="<?php echo esc_attr( $key ); ?>"><strong><?php echo esc_html( $field['label'] ); ?></strong></label>
			<?php if ( ! empty( $field['description'] ) ) : ?>
				<br><span class="description"><?php echo esc_html( $field['description'] ); ?></span>
			<?php endif; ?>
		</p>
		<?php if ( 'textarea' === $field['type'] ) : ?>
			<p>
				<textarea id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>" rows="<?php echo esc_attr( $field['rows'] ?? 3 ); ?>" style="width:100%;"><?php echo esc_textarea( $value ); ?></textarea>
			</p>
		<?php elseif ( 'image' === $field['type'] ) : ?>
			<div class="mor-image-field" data-title="<?php echo esc_attr( $field['label'] ); ?>">
				<input type="hidden" id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>">
				<div class="mor-image-field__preview">
					<?php if ( $value ) : ?>
						<?php echo wp_get_attachment_image( (int) $value, 'medium' ); ?>
					<?php endif; ?>
				</div>
				<p>
					<button type="button" class="button mor-image-field__select"><?php esc_html_e( 'Select Image', 'mor-websites' ); ?></button>
					<button type="button" class="button mor-image-field__remove" <?php echo $value ? '' : 'style="display:none;"'; ?>><?php esc_html_e( 'Remove', 'mor-websites' ); ?></button>
				</p>
			</div>
		<?php else : ?>
			<p>
				<input type="text" id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>" style="width:100%;">
			</p>
		<?php endif; ?>
		<hr>
		<?php
	}
}

function mor_save_page_fields( $post_id ) {
	if ( ! isset( $_POST[ MOR_PAGE_FIELDS_NONCE ] ) || ! wp_verify_nonce( wp_unslash( $_POST[ MOR_PAGE_FIELDS_NONCE ] ), MOR_PAGE_FIELDS_NONCE_ACTION ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$post = get_post( $post_id );
	if ( ! $post || 'page' !== $post->post_type ) {
		return;
	}

	$groups = array();
	if ( mor_page_is_home_template( $post ) ) {
		$groups = mor_home_field_groups();
	} elseif ( mor_page_is_contact( $post ) ) {
		$groups = mor_contact_field_groups();
	} else {
		return;
	}

	foreach ( $groups as $box ) {
		foreach ( $box['fields'] as $key => $field ) {
			if ( ! isset( $_POST[ $key ] ) ) {
				continue;
			}
			$raw = wp_unslash( $_POST[ $key ] );
			if ( 'image' === $field['type'] ) {
				update_post_meta( $post_id, $key, absint( $raw ) );
			} elseif ( 'textarea' === $field['type'] ) {
				update_post_meta( $post_id, $key, sanitize_textarea_field( $raw ) );
			} else {
				update_post_meta( $post_id, $key, sanitize_text_field( $raw ) );
			}
		}
	}
}
add_action( 'save_post', 'mor_save_page_fields' );

function mor_page_fields_admin_assets( $hook ) {
	if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
		return;
	}
	global $post;
	if ( ! $post || 'page' !== $post->post_type ) {
		return;
	}
	if ( ! mor_page_is_home_template( $post ) && ! mor_page_is_contact( $post ) ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_script( 'mor-admin-page-fields', MOR_THEME_URI . '/assets/js/admin-page-fields.js', array( 'jquery' ), MOR_THEME_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'mor_page_fields_admin_assets' );

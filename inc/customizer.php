<?php
/**
 * Store Details Customizer panel + matching shortcodes/PHP helpers.
 *
 * PLACEHOLDER VALUES: mor_theme_mod_defaults() below fills company_email
 * and company_phone with clearly-fake placeholders (see the "REPLACE"
 * comments) because real values weren't available at build time. Update
 * them at Appearance > Customize > Store Details — nothing else in the
 * theme needs to change; every place these values appear (header,
 * footer, contact page, legal pages) reads from these same theme_mods.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mor_theme_mod_defaults() {
	return array(
		'company_name'    => 'Fusion Cart',
		// REPLACE with the real store email in Customizer > Store Details.
		'company_email'   => 'info@fusioncart.example',
		// REPLACE with the real store phone in Customizer > Store Details.
		'company_phone'   => '+234 000 000 0000',
		'company_address' => 'H/No. 7, Near Washing Bay, Anyaa, Lampshade Lane, Accra, Ghana',
	);
}

function mor_get_store_detail( $key ) {
	$defaults = mor_theme_mod_defaults();
	return get_theme_mod( $key, $defaults[ $key ] ?? '' );
}

/**
 * Register the "Store Details" Customizer panel.
 */
function mor_customize_register( $wp_customize ) {
	$defaults = mor_theme_mod_defaults();

	$wp_customize->add_section(
		'mor_store_details',
		array(
			'title'    => __( 'Store Details', 'mor-websites' ),
			'priority' => 30,
		)
	);

	$fields = array(
		'company_name'    => array( 'label' => __( 'Company Name', 'mor-websites' ), 'sanitize' => 'sanitize_text_field' ),
		'company_email'   => array( 'label' => __( 'Company Email', 'mor-websites' ), 'sanitize' => 'sanitize_email' ),
		'company_phone'   => array( 'label' => __( 'Company Phone', 'mor-websites' ), 'sanitize' => 'sanitize_text_field' ),
		'company_address' => array( 'label' => __( 'Company Address', 'mor-websites' ), 'sanitize' => 'sanitize_text_field' ),
	);

	foreach ( $fields as $setting => $field ) {
		$wp_customize->add_setting(
			$setting,
			array(
				'default'           => $defaults[ $setting ],
				'sanitize_callback' => $field['sanitize'],
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			$setting,
			array(
				'label'   => $field['label'],
				'section' => 'mor_store_details',
				'type'    => 'company_email' === $setting ? 'email' : 'text',
			)
		);
	}
}
add_action( 'customize_register', 'mor_customize_register' );

/**
 * Shortcodes — [company_name] [company_phone] [company_email] [company_address]
 */
function mor_shortcode_company_name() {
	return esc_html( mor_get_store_detail( 'company_name' ) );
}
add_shortcode( 'company_name', 'mor_shortcode_company_name' );

function mor_shortcode_company_phone() {
	return esc_html( mor_get_store_detail( 'company_phone' ) );
}
add_shortcode( 'company_phone', 'mor_shortcode_company_phone' );

function mor_shortcode_company_email() {
	return esc_html( mor_get_store_detail( 'company_email' ) );
}
add_shortcode( 'company_email', 'mor_shortcode_company_email' );

function mor_shortcode_company_address() {
	return esc_html( mor_get_store_detail( 'company_address' ) );
}
add_shortcode( 'company_address', 'mor_shortcode_company_address' );

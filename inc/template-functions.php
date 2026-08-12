<?php
/**
 * Template-related helper functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mor_site_branch_label() {
	return esc_html( mor_updater_get_branch() );
}

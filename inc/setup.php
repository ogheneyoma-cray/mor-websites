<?php
/**
 * Theme setup: supports, menus, assets.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mor_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'mor-websites' ),
		)
	);

	load_theme_textdomain( 'mor-websites', MOR_THEME_DIR . '/languages' );
}
add_action( 'after_setup_theme', 'mor_theme_setup' );

function mor_theme_scripts() {
	wp_enqueue_style( 'mor-theme-style', get_stylesheet_uri(), array(), MOR_THEME_VERSION );
	wp_enqueue_script( 'mor-theme-nav', MOR_THEME_URI . '/assets/js/navigation.js', array(), MOR_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'mor_theme_scripts' );

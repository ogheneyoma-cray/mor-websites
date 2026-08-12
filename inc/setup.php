<?php
/**
 * Theme setup: supports, menus, sidebars.
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
			'footer'  => __( 'Footer Menu', 'mor-websites' ),
		)
	);

	load_theme_textdomain( 'mor-websites', MOR_THEME_DIR . '/languages' );
}
add_action( 'after_setup_theme', 'mor_theme_setup' );

function mor_theme_scripts() {
	wp_enqueue_style( 'mor-theme-style', get_stylesheet_uri(), array(), MOR_THEME_VERSION );
}
add_action( 'wp_enqueue_scripts', 'mor_theme_scripts' );

function mor_register_sidebars() {
	register_sidebar(
		array(
			'name'          => __( 'Primary Sidebar', 'mor-websites' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'mor_register_sidebars' );

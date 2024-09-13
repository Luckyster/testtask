<?php

/**
 * Theme functions.
 *
 * @package WordPress
 * @subpackage theme_name
 */

// ! IMPORTANT - change 'theme_name' to correct name everywhere.

/**
 * Theme dependencies.
 */
add_action( 'after_setup_theme', 'load_theme_dependencies' );
function load_theme_dependencies(){
	// Register theme menus.
	register_nav_menus(
		[
			'header_menu'	=> esc_html__( 'Header Menu', 'theme_name' ),
			'footer_menu'	=> esc_html__( 'Footer Menu', 'theme_name' )
		]
	);

    include get_template_directory() . '/includes/post-types.php';

    include get_template_directory() . '/includes/shortcodes.php';
}

/**
 * Theme initalization.
 */
add_action( 'init', 'init_theme' );
function init_theme(){
	// Remove extra styles and default SVG tags.
	remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
	remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );

	load_theme_textdomain( 'theme_name', get_stylesheet_directory() . '/languages' );

	// Manage the document title - WordPress automatically add title
	add_theme_support( 'title-tag' );

	// Enable post thumbnails.
	add_theme_support( 'post-thumbnails' );

	// Custom image sizes.
	 add_image_size( 'full-hd', 1920, 0, 1 );
}

/**
 * Enqueue styles and scripts.
 */
function inclusion_enqueue(){
	// Remove Gutenberg styles on front-end.
	if( ! is_admin() ){
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'wc-blocks-style' );
	}

	// Random value to prevent caching.
	// Change to some value on production, for example: '1.0.0'.
	$ver_num = mt_rand();

	// Styles.
	wp_enqueue_style( 'main', get_template_directory_uri() . '/static/css/main.min.css', [], $ver_num, 'all' );
}
add_action( 'wp_enqueue_scripts', 'inclusion_enqueue' );

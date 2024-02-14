<?php
/**
 * Enqueue styles
 */
add_action('wp_enqueue_scripts', 'azoth_styles');
function azoth_styles() {
	wp_register_style('leaflet-style', get_template_directory_uri() . '/assets/css/leaflet/leaflet.css', array(), false);
	wp_enqueue_style('leaflet-style');
	wp_enqueue_style('main-style', get_template_directory_uri() . '/style.css', array(), filemtime(get_stylesheet_directory() . '/style.css'));
}

/**
 * Enqueue login style
 */
add_action( 'login_enqueue_scripts', 'azoth_login_styles', 10 );
 function azoth_login_styles() {
	wp_register_style('login-style', get_template_directory_uri() . '/assets/css/login-style.css', array(), false);
	wp_enqueue_style('login-style');
}

/**
 * Enqueue scripts
 */
add_action('wp_enqueue_scripts', 'azoth_scripts');
function azoth_scripts() {
	wp_register_script('leaflet', get_theme_file_uri('/assets/js/leaflet/leaflet.js'), array(), false, true);
	wp_enqueue_script('leaflet');

	if ( is_singular( 'lieu' ) ) :
	wp_register_script('single-map-script', get_theme_file_uri('/assets/js/front/single-lieu.js'), ['leaflet', 'jquery' ], false, true);
    wp_enqueue_script('single-map-script');
	endif;
	if( is_post_type_archive('lieu') ) :
	wp_register_script('archive-map-script', get_theme_file_uri('/assets/js/front/archive-lieu.js'), ['leaflet', 'jquery' ], false, true);
    wp_enqueue_script('archive-map-script');
	endif;
}

<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 */

/**
* Enqueues styles.
*/
function azoth_styles() {
	wp_enqueue_style('main-style', get_template_directory_uri() . '/style.css', array(), filemtime(get_stylesheet_directory() . '/style.css'));
}
add_action('wp_enqueue_scripts', 'azoth_styles');

/**
* Register menus.
*/
register_nav_menus(
	array(
		'primary' => esc_html__( 'Menu principal' ),
		'footer'  => esc_html__( 'Menu secondaire' )
	)
);
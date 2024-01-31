<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 */

 /**
 * Enqueues styles.
 *
 */
function azoth_styles() {
	wp_enqueue_style('main-style', get_template_directory_uri() . '/style.css', array(), filemtime(get_template_directory_uri() . '/style.css'));
}
add_action('wp_enqueue_scripts', 'azoth_styles');
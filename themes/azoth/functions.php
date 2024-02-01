<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 */

/**
 * Define Constants
 */

 define('AZOTH_DIR', trailingslashit(get_theme_file_path()));

/**
 * Enqueues styles.
 */
function azoth_styles() {
	wp_enqueue_style('main-style', get_template_directory_uri() . '/style.css', array(), filemtime(get_stylesheet_directory() . '/style.css'));
}
add_action('wp_enqueue_scripts', 'azoth_styles');

/**
 * Enqueues admin scripts.
 */
function azoth_admin_scripts() {
	if (!did_action('wp_enqueue_media')) {
        wp_enqueue_media();
    }
	wp_register_script('media-library-uploader-script', get_theme_file_uri('/assets/js/backoffice/media-library-uploader.js'), array('jquery'), false, true);
	wp_enqueue_script('media-library-uploader-script');
}
add_action('admin_enqueue_scripts', 'azoth_admin_scripts');

/**
 * Register menus.
 */
register_nav_menus(
	array(
		'primary' => esc_html__('Menu principal'),
		'footer'  => esc_html__('Menu secondaire')
	)
);

/**
 * Enable support for Post Thumbnails on posts and pages
 */
add_theme_support('post-thumbnails');
set_post_thumbnail_size(1568, 9999);

/**
 * Include Custom Post Types
 */

require_once AZOTH_DIR . 'inc/cpt/cpt-voies.php';
require_once AZOTH_DIR . 'inc/cpt/cpt-instructeurs.php';
require_once AZOTH_DIR . 'inc/cpt/cpt-lieux.php';
require_once AZOTH_DIR . 'inc/cpt/cpt-contacts.php';
require_once AZOTH_DIR . 'inc/cpt/cpt-conferences.php';
require_once AZOTH_DIR . 'inc/cpt/cpt-formations.php';
require_once AZOTH_DIR . 'inc/cpt/cpt-stages.php';

/**
 * Include Metaboxes
 */

require_once AZOTH_DIR . 'inc/metaboxes/mb-generator.php';

require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/mb-voies.php';
require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/mb-instructeurs.php';
require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/mb-lieux.php';
require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/mb-contacts.php';
require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/mb-evenements.php';
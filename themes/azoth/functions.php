<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 */

// add_action('admin_init','dump_admin');
function dump_admin() {
  if (is_admin()) {
    header('Content-Type:text/plain');
    var_dump($GLOBALS['menu']);
    exit;
  }
}

/**
 * Define Constants
 */

 define('AZOTH_DIR', trailingslashit(get_theme_file_path()));

/**
 * Enqueue styles
 */
function azoth_styles() {
	wp_enqueue_style('main-style', get_template_directory_uri() . '/style.css', array(), filemtime(get_stylesheet_directory() . '/style.css'));
}
add_action('wp_enqueue_scripts', 'azoth_styles');

/**
 * Enqueue login style
 */

 function azoth_login_styles() {
	wp_register_style('login-style', get_template_directory_uri() . '/assets/css/login-style.css', array(), false);
	wp_enqueue_style('login-style');
}
add_action( 'login_enqueue_scripts', 'azoth_login_styles', 10 );

/**
 * Enqueue admin styles
 */
function azoth_admin_styles() {
	wp_register_style('leaflet-style', get_template_directory_uri() . '/assets/css/leaflet/leaflet.css', array(), false);
	wp_enqueue_style('leaflet-style');
	wp_register_style('leaflet-search-style', get_stylesheet_directory_uri() . '/assets/css/leaflet/leaflet-search.css', array(), false);
	wp_enqueue_style('leaflet-search-style');
	wp_register_style('admin-style', get_stylesheet_directory_uri() . '/assets/css/admin-style.css',  array(), false);
	wp_enqueue_style('admin-style');
}
add_action('admin_enqueue_scripts', 'azoth_admin_styles');

// /* Add admin color scheme */
// function azoth_admin_color_scheme() {
// 	wp_admin_css_color(
// 		'azoth',
// 		'Azoth',
// 		get_stylesheet_directory_uri() . '/assets/css/admin-color-scheme.css',
// 		['#404040', '#fff', '#d47d7d' , '#cc0000']
// 	);
// };
// add_action('admin_init', 'azoth_admin_color_scheme');

// function user_admin_color_scheme( $color_scheme ) {
//     $color_scheme = 'azoth';
//     return $color_scheme;
// }
// add_filter( 'get_user_option_admin_color', 'user_admin_color_scheme', 5 );

// add_action( 'admin_head-profile.php', 'remove_admin_color_scheme_picker' );
// function remove_admin_color_scheme_picker() {
//     remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
// };

/**
 * Enqueue admin scripts
 */
function azoth_admin_scripts() {
	if (!did_action('wp_enqueue_media')) {
        wp_enqueue_media();
    }

	wp_register_script('media-library-uploader-script', get_theme_file_uri('/assets/js/backoffice/media-library-uploader.js'), array('jquery'), false, true);
	wp_enqueue_script('media-library-uploader-script');

	wp_register_script('leaflet', get_theme_file_uri('/assets/js/leaflet/leaflet.js'), array(), false, true);
	wp_enqueue_script('leaflet');
	wp_register_script('leaflet_search', get_theme_file_uri('/assets/js/leaflet/leaflet-search.js'), array('leaflet'), false, true);
	wp_enqueue_script('leaflet_search');

	global $post;

	if(get_current_screen()->base === 'post' && ($post->post_type === 'lieu' || $post->post_type === 'conference' || $post->post_type === 'formation' || $post->post_type === 'stage')) :
		wp_register_script('map-script', get_theme_file_uri('/assets/js/backoffice/map.js'), array('leaflet'), false, true);
    	wp_enqueue_script('map-script');
		wp_register_script('geo-zone-script', get_theme_file_uri('/assets/js/backoffice/geo-zone.js'), array('jquery'), false, true);
		wp_enqueue_script('geo-zone-script');
	endif;

	if(get_current_screen()->base === 'post' && ($post->post_type === 'conference' || $post->post_type === 'formation' || $post->post_type === 'stage')) :
		wp_register_script('contact-script', get_theme_file_uri('/assets/js/backoffice/contact.js'), array('leaflet'), false, true);
    	wp_enqueue_script('contact-script');
		wp_register_script('quick-add-post-script', get_theme_file_uri('/assets/js/backoffice/quick-add-post.js'), array('jquery'), false, true);
		wp_enqueue_script('quick-add-post-script');	
	endif;
	if(get_current_screen()->base === 'post' && ($post->post_type === 'formation' || $post->post_type === 'stage')) :
		wp_register_script('evenement-dates-script', get_theme_file_uri('/assets/js/backoffice/evenement-dates.js'), array('leaflet'), false, true);
    	wp_enqueue_script('evenement-dates-script');
	endif;
	if(get_current_screen()->base === 'post' && $post->post_type === 'stage') :
		wp_register_script('mouvement-immobile-script', get_theme_file_uri('/assets/js/backoffice/mouvement-immobile.js'), array('leaflet'), false, true);
    	wp_enqueue_script('mouvement-immobile-script');
	endif;

	wp_register_script('test-script', get_theme_file_uri('/test.js'), array('jquery'), false, true);
	wp_enqueue_script('test-script');
}
add_action('admin_enqueue_scripts', 'azoth_admin_scripts');

/**
 * Include miscellaneous
 */

require_once AZOTH_DIR . 'inc/menus.php';
require_once AZOTH_DIR . 'inc/support.php';
require_once AZOTH_DIR . 'inc/taxonomies.php';
require_once AZOTH_DIR . 'inc/roles.php';
require_once AZOTH_DIR . 'inc/dashboard.php';
require_once AZOTH_DIR . 'inc/admin-menu.php';
require_once AZOTH_DIR . 'inc/admin-bar.php';

/**
 * Add Custom Post Types
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

/* Fields Generators */

require_once AZOTH_DIR . 'inc/metaboxes/fields/field-types/inputs.php';
require_once AZOTH_DIR . 'inc/metaboxes/fields/field-types/map.php';
require_once AZOTH_DIR . 'inc/metaboxes/fields/field-types/media-library-uploader.php';
require_once AZOTH_DIR . 'inc/metaboxes/fields/field-types/radio.php';
require_once AZOTH_DIR . 'inc/metaboxes/fields/field-types/select.php';
require_once AZOTH_DIR . 'inc/metaboxes/fields/field-types/taxonomy.php';
require_once AZOTH_DIR . 'inc/metaboxes/fields/field-types/wysiwyg.php';

require_once AZOTH_DIR . 'inc/metaboxes/fields/fields-generator.php';

/* Add Metaboxes */

require_once AZOTH_DIR . 'inc/metaboxes/mb-generator.php';

require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/mb-voies.php';
require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/mb-instructeurs.php';
require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/mb-lieux.php';
require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/mb-contacts.php';

require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/fields-evenements.php';

require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/mb-conferences.php';
require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/mb-formations.php';
require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/mb-stages.php';

require_once AZOTH_DIR . 'inc/metaboxes/quick-add-post.php';

/* Set editor functionalities */

require_once AZOTH_DIR . 'inc/metaboxes/editor.php';

/* Set admin colums & filters */

require_once AZOTH_DIR . 'inc/metaboxes/admin-columns.php';
require_once AZOTH_DIR . 'inc/metaboxes/admin-filters.php';
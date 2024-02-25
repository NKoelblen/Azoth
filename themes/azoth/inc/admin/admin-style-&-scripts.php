<?php
/**
 * Enqueue admin styles
 */
add_action('admin_enqueue_scripts', 'azoth_admin_styles');
function azoth_admin_styles()
{
	wp_register_style('leaflet-style', get_template_directory_uri() . '/assets/css/leaflet/leaflet.css', array(), false);
	wp_enqueue_style('leaflet-style');
	wp_register_style('leaflet-search-style', get_stylesheet_directory_uri() . '/assets/css/leaflet/leaflet-search.css', array(), false);
	wp_enqueue_style('leaflet-search-style');
	wp_register_style('admin-style', get_stylesheet_directory_uri() . '/assets/css/admin/admin-style.css', array(), false);
	wp_enqueue_style('admin-style');
}

// /* Add admin color scheme */
// add_action('admin_init', 'azoth_admin_color_scheme');
// function azoth_admin_color_scheme() {
// 	wp_admin_css_color(
// 		'azoth',
// 		'Azoth',
// 		get_stylesheet_directory_uri() . '/assets/css/admin-color-scheme.css',
// 		['#404040', '#fff', '#d47d7d' , '#cc0000']
// 	);
// };
// add_filter( 'get_user_option_admin_color', 'user_admin_color_scheme', 5 );
// function user_admin_color_scheme( $color_scheme ) {
//     $color_scheme = 'azoth';
//     return $color_scheme;
// }
// add_action( 'admin_head-profile.php', 'remove_admin_color_scheme_picker' );
// function remove_admin_color_scheme_picker() {
//     remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
// };

/**
 * Enqueue admin scripts
 */
add_action('admin_enqueue_scripts', 'azoth_admin_scripts');
function azoth_admin_scripts()
{
	if (!did_action('wp_enqueue_media')):
		wp_enqueue_media();
	endif;

	wp_register_script('media-library-uploader-script', get_theme_file_uri('/assets/js/admin/media-library-uploader.js'), array('jquery'), false, true);
	wp_enqueue_script('media-library-uploader-script');

	wp_register_script('leaflet', get_theme_file_uri('/assets/js/leaflet/leaflet.js'), array(), false, true);
	wp_enqueue_script('leaflet');
	wp_register_script('leaflet_search', get_theme_file_uri('/assets/js/leaflet/leaflet-search.js'), array('leaflet'), false, true);
	wp_enqueue_script('leaflet_search');

	global $post;

	if (get_current_screen()->base === 'post' && ($post->post_type === 'lieu' || $post->post_type === 'conference' || $post->post_type === 'formation' || $post->post_type === 'stage')):
		wp_register_script('map-script', get_theme_file_uri('/assets/js/admin/map.js'), array('leaflet'), false, true);
		wp_enqueue_script('map-script');
		wp_register_script('geo-zone-script', get_theme_file_uri('/assets/js/admin/geo-zone.js'), array('jquery'), false, true);
		wp_enqueue_script('geo-zone-script');
	endif;
	if (get_current_screen()->base === 'post' && ($post->post_type === 'conference' || $post->post_type === 'formation' || $post->post_type === 'stage')):
		wp_register_script('contact-script', get_theme_file_uri('/assets/js/admin/contact.js'), array('leaflet'), false, true);
		wp_enqueue_script('contact-script');
		wp_register_script('quick-add-post-script', get_theme_file_uri('/assets/js/admin/quick-add-post.js'), array('jquery'), false, true);
		wp_enqueue_script('quick-add-post-script');
	endif;
	if (get_current_screen()->base === 'post' && ($post->post_type === 'formation' || $post->post_type === 'stage')):
		wp_register_script('evenement-dates-script', get_theme_file_uri('/assets/js/admin/evenement-dates.js'), array('leaflet'), false, true);
		wp_enqueue_script('evenement-dates-script');
	endif;
	if (get_current_screen()->base === 'post' && $post->post_type === 'stage'):
		wp_register_script('mouvement-immobile-script', get_theme_file_uri('/assets/js/admin/mouvement-immobile.js'), array('leaflet'), false, true);
		wp_enqueue_script('mouvement-immobile-script');
	endif;
	if (get_current_screen()->base === 'post' && $post->post_type === 'subscriber'):
		wp_register_script('newsletter-subscription-script', get_theme_file_uri('/inc/newsletter/admin-newsletter-subscription.js'), array('jquery'), false, true);
		wp_enqueue_script('newsletter-subscription-script');
	endif;

	// wp_register_script('test-script', get_theme_file_uri('/test.js'), array('jquery'), false, true);
	// wp_enqueue_script('test-script');
}
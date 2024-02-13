<?php

add_action( 'restrict_manage_posts', 'add_admin_filters', 10, 1 );
function add_admin_filters( $post_type ){
    if ($post_type === 'lieu') :
        $taxonomy = get_taxonomy( 'geo_zone' );
	    $selected = '';
	    // if the current page is already filtered, get the selected term slug
	    $selected = isset( $_REQUEST[ 'geo_zone' ] ) ? $_REQUEST[ 'geo_zone' ] : '';
	    // render a dropdown for this taxonomy's terms
	    wp_dropdown_categories(
            [
	    	    'show_option_all' =>  $taxonomy->labels->all_items,
	    	    'taxonomy'        =>  'geo_zone',
	    	    'name'            =>  'geo_zone',
	    	    'orderby'         =>  'name',
	    	    'value_field'     =>  'slug',
	    	    'selected'        =>  $selected,
	    	    'hierarchical'    =>  true,
	        ]
        );
    endif;
    if ($post_type === 'conference' || $post_type === 'formation' || $post_type === 'stage') :
        $selected = isset($_REQUEST['author']) ? (int)sanitize_text_field($_REQUEST['author']) : '';
        wp_dropdown_users(
            [
	    	    'show_option_all'   => 'Tous les instructeurs',
	    	    'orderby'           => 'display_name',
	    	    'order'             => 'ASC',
	    	    'name'              => 'author',
	    	    'who'				=> '',	
	    	    'include_selected'  => true,
	    	    'selected'        	=> $selected,
	        ]
        );
    endif;
    if ($post_type === 'stage') :
        $tax_name = 'stage_categorie';
	    $taxonomy = get_taxonomy( $tax_name );
	    // if the current page is already filtered, get the selected term slug
	    $selected = isset( $_REQUEST[ $tax_name ] ) ? $_REQUEST[ $tax_name ] : '';
	    // render a dropdown for this taxonomy's terms
	    wp_dropdown_categories(
            [
	    	    'show_option_all' =>  $taxonomy->labels->all_items,
	    	    'taxonomy'        =>  $tax_name,
	    	    'name'            =>  $tax_name,
	    	    'orderby'         =>  'name',
	    	    'value_field'     =>  'slug',
	    	    'selected'        =>  $selected,
	    	    'hierarchical'    =>  true,
	        ]
        );
    endif;
}

function cmp($a, $b)
{
	return strcmp($a["title"], $b["title"]);
}

add_action('restrict_manage_posts', 'add_voie_filter');
function add_voie_filter($post_type){
    
    global $wpdb;
    
    /** Ensure this is the correct Post Type*/
    if($post_type !== 'formation' && $post_type !== 'stage') :
		return;
	endif;
    
    /** Grab the results from the DB */
    $query = $wpdb->prepare('
        SELECT DISTINCT pm.meta_value FROM %1$s pm
        LEFT JOIN %2$s p ON p.ID = pm.post_id
        WHERE pm.meta_key = "%3$s" 
        AND p.post_status = "%4$s" 
        AND p.post_type = "%5$s"
        ORDER BY "%6$s"',
        $wpdb->postmeta,
        $wpdb->posts,
        'e_voie', // Your meta key - change as required
        'publish',          // Post status - change as required
        $post_type,
        'e_voie'
    );
    $results = $wpdb->get_col($query);

	foreach($results as $result) :
		if($result) :
			$voies[] = ['id' => $result, 'title' => get_the_title($result)];
		endif;
	endforeach;
    
    /** Ensure there are options to show */
    if(empty($voies)) :
        return;
	endif;

		$selected = isset( $_GET['f_voie'] ) && $_GET['f_voie'] !== '' ? $_GET['f_voie'] : '';
    
    /** Grab all of the options that should be shown */
    $options[] = '<option value="">Toutes les voies</option>';
    foreach($voies as $voie) :
        $options[] = $voie['id'] === $selected ?
            sprintf('<option value="%1$s" selected>%2$s</option>', esc_attr($voie['id']), $voie['title']) : 
            sprintf('<option value="%1$s">%2$s</option>', esc_attr($voie['id']), $voie['title']);
    endforeach;

    /** Output the dropdown menu */
    echo '<select class="" id="f_voie" name="f_voie">';
    echo join("\n", $options);
    echo '</select>';

}

add_filter( 'parse_query', 'parse_voie_filter' );
function  parse_voie_filter($query) {
    global $pagenow;
    $current_page = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
   
    if (is_admin() && 
        ('formation' === $current_page || 'stage' === $current_page) &&
        'edit.php' === $pagenow && 
        isset( $_GET['f_voie'] ) && 
        $_GET['f_voie'] != '') :
   
        $voie = $_GET['f_voie'];
        $query->query_vars['meta_key']     = 'e_voie';
        $query->query_vars['meta_value']   = $voie;
        $query->query_vars['meta_compare'] = '=';
    endif;
}

add_action('restrict_manage_posts', 'add_lieu_filter');
function add_lieu_filter($post_type){
    
    global $wpdb;
    
    /** Ensure this is the correct Post Type*/
    if($post_type !== 'conference' && $post_type !== 'formation' && $post_type !== 'stage') :
		return;
	endif;
    
    /** Grab the results from the DB */
    $query = $wpdb->prepare('
        SELECT DISTINCT pm.meta_value FROM %1$s pm
        LEFT JOIN %2$s p ON p.ID = pm.post_id
        WHERE pm.meta_key = "%3$s" 
        AND p.post_status = "%4$s" 
        AND p.post_type = "%5$s"
        ORDER BY "%6$s"',
        $wpdb->postmeta,
        $wpdb->posts,
        'lieu', // Your meta key - change as required
        'publish',          // Post status - change as required
        $post_type,
        'lieu'
    );
    $results = $wpdb->get_col($query);

	foreach($results as $result) :
		if ($result) :
			$lieux[] = ['id' => $result, 'title' => get_the_title($result)];
		endif;
	endforeach;

    if(isset($lieux)) :
	    usort($lieux, "cmp");
    endif;
    
    /** Ensure there are options to show */
    if(empty($lieux)) :
        return;
	endif;

		$selected = isset( $_GET['f_lieu'] ) && $_GET['f_lieu'] !== '' ? $_GET['f_lieu'] : '';
    
    /** Grab all of the options that should be shown */
    $options[] = '<option value="">Tous les lieux</option>';
    foreach($lieux as $lieu) :
        $options[] = $lieu['id'] === $selected ?
            sprintf('<option value="%1$s" selected>%2$s</option>', esc_attr($lieu['id']), $lieu['title']) :
            sprintf('<option value="%1$s">%2$s</option>', esc_attr($lieu['id']), $lieu['title']);
    endforeach;

    /** Output the dropdown menu */
    echo '<select class="" id="f_lieu" name="f_lieu">';
    echo join("\n", $options);
    echo '</select>';

}

add_filter( 'parse_query', 'parse_lieu_filter' );
function  parse_lieu_filter($query) {
    global $pagenow;
    $current_page = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
    
    if (is_admin() &&
        ('conference' === $current_page || 'formation' == $current_page || 'stage' == $current_page) &&
        'edit.php' === $pagenow && 
        isset( $_GET['f_lieu'] ) && 
        $_GET['f_lieu'] != '') :
   
        $lieu = $_GET['f_lieu'];
        $query->query_vars['meta_key']     = 'lieu';
        $query->query_vars['meta_value']   = $lieu;
        $query->query_vars['meta_compare'] = '=';
    endif;
}
<?php
/* Only one column for custom post types and !administrators */
function columns( $nr ) {
    if(current_user_can('administrator')) :
        return;
    else :
        return 1;
    endif;
}
add_filter( 'get_user_option_screen_layout_instructeur', 'columns' );
add_filter( 'get_user_option_screen_layout_lieu', 'columns' );
add_filter( 'get_user_option_screen_layout_contact', 'columns' );
add_filter( 'get_user_option_screen_layout_conference', 'columns' );
add_filter( 'get_user_option_screen_layout_formation', 'columns' );
add_filter( 'get_user_option_screen_layout_stage', 'columns' );

/* Hide scree options for !administrators */
function hide_screen_options() {
    if(current_user_can('administrator')) :
        return true;
    else :
        return false;
    endif;
}
add_filter('screen_options_show_screen', 'hide_screen_options');

/* Remove meta boxes */
function remove_meta_boxes() {
    if(!current_user_can('administrator')) :
        $post_types = get_post_types();
        foreach ( $post_types as $post_type ) :
            remove_meta_box( 'wpseo_meta' , $post_type , 'normal' );
            remove_meta_box( 'monsterinsights-metabox' , $post_type , 'side' );
        endforeach;
    endif;
}
add_action( 'admin_head' , 'remove_meta_boxes' );
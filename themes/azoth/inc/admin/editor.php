<?php
/* Only one column for custom post types and !administrators */
add_filter('get_user_option_screen_layout_instructeur', 'columns');
add_filter('get_user_option_screen_layout_lieu', 'columns');
add_filter('get_user_option_screen_layout_contact', 'columns');
add_filter('get_user_option_screen_layout_conference', 'columns');
add_filter('get_user_option_screen_layout_formation', 'columns');
add_filter('get_user_option_screen_layout_stage', 'columns');
function columns($nr)
{
    if (current_user_can('administrator')):
        return;
    else:
        return 1;
    endif;
}

/* Hide screen options for !administrators */
add_filter('screen_options_show_screen', 'hide_screen_options');
function hide_screen_options()
{
    return current_user_can('administrator') ? true : false;
}

/* Remove meta boxes */
add_action('admin_head', 'remove_meta_boxes');
function remove_meta_boxes()
{
    if (!current_user_can('administrator')):
        $post_types = get_post_types();
        foreach ($post_types as $post_type):
            remove_meta_box('wpseo_meta', $post_type, 'normal');
            remove_meta_box('monsterinsights-metabox', $post_type, 'side');
        endforeach;
    endif;
}

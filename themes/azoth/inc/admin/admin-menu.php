<?php
/**
 * Add admin menu separator
 */

function add_admin_menu_separator($position) {
    global $menu;
    $index = 1;
    foreach($menu as $offset => $section) :
        if (substr($section[2],0,9)=='separator') :
            $index++;
        endif;
        if ($offset>=$position) :
            $separator[] = ['','read',"separator{$index}",'','wp-menu-separator'];
            array_splice( $menu, $position, 0, $separator );
            break;
        endif;
    endforeach;
    ksort( $menu );
}
add_action('admin_menu', function() {
    add_admin_menu_separator(1);
    add_admin_menu_separator(2);
    add_admin_menu_separator(3);
    add_admin_menu_separator(4);
});

/**
 * Reorder menu
 */

function custom_menu_order( $menu_order ) {
    if ( !$menu_order ) :
        return true;
    endif;
    return [
        'index.php', // Dashboard

        'separator1', // First separator

        'edit.php?post_type=conference', // Custom-Post
        'edit.php?post_type=formation', // Custom-Post
        'edit.php?post_type=stage', // Custom-Post

        'separator2', // Second separator

        'edit.php?post_type=lieu', // Custom-Post
        'edit.php?post_type=contact', // Custom-Post

        'separator3',

        'edit.php', // Posts
        'upload.php', // Media
        'edit-comments.php', // Comments

        'separator4', // Second separator

        'edit.php?post_type=instructeur', // Custom-Post
        'users.php', // Users

        'separator5', // Second separator

        'edit.php?post_type=voie', // Custom-Post
        'edit.php?post_type=page', // Pages

        'separator6', // Second separator

        'themes.php', // Appearance
        'plugins.php', // Plugins
        'tools.php', // Tools
        'options-general.php', // Settings

        'separator-last', // Last separator

        'monsterinsights_reports',
        'wpseo_dashboard',
        'filebird-settings',
    ];
}
add_filter( 'custom_menu_order', 'custom_menu_order', 10, 1 );
add_filter( 'menu_order', 'custom_menu_order', 10, 1 );

/**
 * Remove menu items
 */
function remove_menus(){
  
    if(current_user_can('gestionnaire')) :
        remove_menu_page( 'tools.php' );
    endif;
    if(current_user_can('gestionnaire') || current_user_can('instructeur')) :
        remove_menu_page( 'wpseo_workouts' );
    endif;  
}
add_action( 'admin_menu', 'remove_menus' );
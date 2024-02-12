<?php
add_action( 'wp_before_admin_bar_render', 'adminbar_new_content_order' );
function adminbar_new_content_order() {
    global $wp_admin_bar;

    // get node for New + menu node
    $new_content_node = $wp_admin_bar->get_node('new-content');

    // change URL for node, edit for prefered link
    $new_content_node->href = admin_url( 'post-new.php?post_type=formation' );

    // Update New + menu node
    $wp_admin_bar->add_node($new_content_node);

    // remove all items from New Content menu
    $post_types = [
        'post',
        'media',
        'page',
        'user',
        'voie',
        'instructeur',
        'lieu',
        'contact',
        'conference',
        'formation',
        'stage'
    ];
    foreach($post_types as $post_type) :
        $wp_admin_bar->remove_node('new-' . $post_type);
    endforeach;

    // add back the new Post link
    if(current_user_can('edit_evenements')) :
        $new_items = [
            [
                'id'     => 'new-conference',    
                'title'  => 'Conférence', 
                'parent' => 'new-content',
                'href'  => admin_url( 'post-new.php?post_type=conference' ),
                'meta'  => ['class' => 'ab-item']
            ],
            [
                'id'     => 'new-formation',    
                'title'  => 'Formation', 
                'parent' => 'new-content',
                'href'  => admin_url( 'post-new.php?post_type=formation' ),
                'meta'  => ['class' => 'ab-item']
            ],
            [
                'id'     => 'new-stage',    
                'title'  => 'Stage', 
                'parent' => 'new-content',
                'href'  => admin_url( 'post-new.php?post_type=stage' ),
                'meta'  => ['class' => 'ab-item']
            ],
            [
                'id'     => 'new-lieu',    
                'title'  => 'Lieu', 
                'parent' => 'new-content',
                'href'  => admin_url( 'post-new.php?post_type=lieu' ),
                'meta'  => ['class' => 'ab-item']
            ],
            [
                'id'     => 'new-contact',    
                'title'  => 'Contact', 
                'parent' => 'new-content',
                'href'  => admin_url( 'post-new.php?post_type=contact' ),
                'meta'  => ['class' => 'ab-item']
            ],

        ];
    endif;
    if(current_user_can('edit_posts')) :
        $new_items[] = [
            'id'     => 'new-post',    
            'title'  => 'Article', 
            'parent' => 'new-content',
            'href'  => admin_url( 'post-new.php' ),
            'meta'  => ['class' => 'ab-item']
        ];
    endif;
    if(current_user_can('edit_users')) :
        $new_items[] = [
            'id'     => 'new-instructeur',    
            'title'  => 'Instructeur', 
            'parent' => 'new-content',
            'href'  => admin_url( 'post-new.php?post_type=instructeur' ),
            'meta'  => ['class' => 'ab-item']
        ];
        $new_items[] = [
            'id'     => 'new-user',    
            'title'  => 'Compte', 
            'parent' => 'new-content',
            'href'  => admin_url( 'user-new.php' ),
            'meta'  => ['class' => 'ab-item']
        ];
    endif;
    foreach ($new_items as $new_item) :
        $wp_admin_bar->add_node( $new_item );
    endforeach;
}

add_action( 'wp_before_admin_bar_render', 'adminbar_remove_nodes' );
function adminbar_remove_nodes() {
    global $wp_admin_bar;
    if(!current_user_can('administrator')) :
        $wp_admin_bar->remove_node( 'wpseo-menu' );
        $wp_admin_bar->remove_node( 'delete-cache' );
    endif;

}
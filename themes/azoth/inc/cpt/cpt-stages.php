<?php
/* Register Custom Post Type Stage */
add_action('init', 'stage_post_type', 0);
function stage_post_type()
{
    $labels = [
        'name'                  => _x('Stages', 'Post Type General Name'),
        'singular_name'         => _x('Stage', 'Post Type Singular Name'),
        'menu_name'             => __('Stages'),
        'name_admin_bar'        => __('Stage'),
        'archives'              => __('Archives du Stage'),
        'attributes'            => __('Attributs du Stage'),
        'parent_item_colon'     => __('Parent du Stage :'),
        'all_items'             => __('Tous les Stages'),
        'add_new_item'          => __('Ajouter un nouveau Stage'),
        'add_new'               => __('Nouveau Stage'),
        'new_item'              => __('Nouveau Stage'),
        'edit_item'             => __('Modifier le Stage'),
        'update_item'           => __('Mettre à jour le Stage'),
        'view_item'             => __('Voir le Stage'),
        'view_items'            => __('Voir les Stages'),
        'search_items'          => __('Chercher des Stages'),
        'not_found'             => __('Aucun Stage trouvé'),
        'not_found_in_trash'    => __('Aucun Stage trouvé dans la corbeille'),
        'featured_image'        => __('Image mise en avant'),
        'set_featured_image'    => __('Définir l\'image mise en avant'),
        'remove_featured_image' => __('Supprimer l\'image mise en avant'),
        'use_featured_image'    => __('Utiliser comme image mise en avant'),
        'insert_into_item'      => __('Insérer dans ce Stage'),
        'uploaded_to_this_item' => __('Télécharger dans ce Stage'),
        'items_list'            => __('Liste des Stages'),
        'items_list_navigation' => __('Navigation dans la liste des Stages'),
        'filter_items_list'     => __('Filtrer la liste des Stages'),
    ];
    $args = [
        'label'                 => __('Stage'),
        'description'           => __('Stages'),
        'labels'                => $labels,
        'supports'              => false,
        'taxonomies'            => array(),
        'hierarchical'          => false,
        'public'                => true,
        'show_in_rest'          => false, // Gutenberg
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-universal-access-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'map_meta_cap'          => true,
        'capabilities'          => [
            'edit_posts'                => 'edit_evenements',
            'delete_posts'              => 'delete_evenements',
        
            'publish_posts'             => 'publish_evenements',
            'edit_published_posts'      => 'edit_published_evenements',
            'delete_published_posts'    => 'delete_published_evenements',
        
            'edit_others_posts'         => 'edit_others_evenements',
            'delete_others_posts'       => 'delete_others_evenements',
            'read_private_posts'        => 'read_private_evenements',
            'edit_private_posts'        => 'edit_private_evenements',
            'delete_private_posts'      => 'delete_private_evenements',
        ]
    ];
    register_post_type('stage', $args);
}
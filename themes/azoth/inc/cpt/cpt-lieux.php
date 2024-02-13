<?php
/* Register Custom Post Type Lieu */
add_action('init', 'lieu_post_type', 0);
function lieu_post_type()
{
    $labels = [
        'name'                  => _x('Lieux', 'Post Type General Name'),
        'singular_name'         => _x('Lieu', 'Post Type Singular Name'),
        'menu_name'             => __('Lieux'),
        'name_admin_bar'        => __('Lieu'),
        'archives'              => __('Archives du Lieu'),
        'attributes'            => __('Attributs du Lieu'),
        'parent_item_colon'     => __('Parent du Lieu :'),
        'all_items'             => __('Tous les Lieux'),
        'add_new_item'          => __('Ajouter un Lieu'),
        'add_new'               => __('Nouveau Lieu'),
        'new_item'              => __('Nouveau Lieu'),
        'edit_item'             => __('Modifier le Lieu'),
        'update_item'           => __('Mettre à jour le Lieu'),
        'view_item'             => __('Voir le Lieu'),
        'view_items'            => __('Voir les Lieux'),
        'search_items'          => __('Chercher des Lieux'),
        'not_found'             => __('Aucun Lieu trouvé'),
        'not_found_in_trash'    => __('Aucun Lieu trouvé dans la corbeille'),
        'featured_image'        => __('Image mise en avant'),
        'set_featured_image'    => __('Définir l\'image mise en avant'),
        'remove_featured_image' => __('Supprimer l\'image mise en avant'),
        'use_featured_image'    => __('Utiliser comme image mise en avant'),
        'insert_into_item'      => __('Insérer dans ce Lieu'),
        'uploaded_to_this_item' => __('Télécharger dans ce Lieu'),
        'items_list'            => __('Liste des Lieux'),
        'items_list_navigation' => __('Navigation dans la liste des Lieux'),
        'filter_items_list'     => __('Filtrer la liste des Lieux'),
    ];
    $args = [
        'label'                 => __('Lieu'),
        'description'           => __('Lieux'),
        'labels'                => $labels,
        'supports'              => ['title'],
        'taxonomies'            => [],
        'hierarchical'          => false,
        'public'                => true,
        'show_in_rest'          => false, // Gutenberg
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-location',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'map_meta_cap'          => true,
        'capabilities'          => [
            'edit_posts'                => 'edit_lieux',
            'delete_posts'              => 'delete_lieux',
        
            'publish_posts'             => 'publish_lieux',
            'edit_published_posts'      => 'edit_published_lieux',
            'delete_published_posts'    => 'delete_published_lieux',
        
            'edit_others_posts'         => 'edit_others_lieux',
            'delete_others_posts'       => 'delete_others_lieux',
            'read_private_posts'        => 'read_private_lieux',
            'edit_private_posts'        => 'edit_private_lieux',
            'delete_private_posts'      => 'delete_private_lieux',
        ]
    ];
    register_post_type('lieu', $args);
}
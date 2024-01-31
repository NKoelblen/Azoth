<?php
/* Register Custom Post Type Instructeur */
add_action('init', 'instructeur_post_type', 0);
function instructeur_post_type()
{
    $labels = [
        'name'                  => _x('Instructeurs', 'Post Type General Name'),
        'singular_name'         => _x('Instructeur', 'Post Type Singular Name'),
        'menu_name'             => __('Instructeurs'),
        'name_admin_bar'        => __('Instructeur'),
        'archives'              => __('Archives du Instructeur'),
        'attributes'            => __('Attributs du Instructeur'),
        'parent_item_colon'     => __('Parent du Instructeur :'),
        'all_items'             => __('Tous les Instructeurs'),
        'add_new_item'          => __('Ajouter un nouveau Instructeur'),
        'add_new'               => __('Nouveau Instructeur'),
        'new_item'              => __('Nouveau Instructeur'),
        'edit_item'             => __('Modifier le Instructeur'),
        'update_item'           => __('Mettre à jour le Instructeur'),
        'view_item'             => __('Voir le Instructeur'),
        'view_items'            => __('Voir les Instructeurs'),
        'search_items'          => __('Chercher des Instructeurs'),
        'not_found'             => __('Aucun Instructeur trouvé'),
        'not_found_in_trash'    => __('Aucun Instructeur trouvé dans la corbeille'),
        'featured_image'        => __('Image mise en avant'),
        'set_featured_image'    => __('Définir l\'image mise en avant'),
        'remove_featured_image' => __('Supprimer l\'image mise en avant'),
        'use_featured_image'    => __('Utiliser comme image mise en avant'),
        'insert_into_item'      => __('Insérer dans ce Instructeur'),
        'uploaded_to_this_item' => __('Télécharger dans ce Instructeur'),
        'items_list'            => __('Liste des Instructeurs'),
        'items_list_navigation' => __('Navigation dans la liste des Instructeurs'),
        'filter_items_list'     => __('Filtrer la liste des Instructeurs'),
    ];
    $args = [
        'label'                 => __('Instructeur'),
        'description'           => __('Instructeurs'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail'),
        'taxonomies'            => array(),
        'hierarchical'          => false,
        'public'                => true,
        'show_in_rest'          => false, // Gutenberg
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    ];
    register_post_type('instructeur', $args);
}
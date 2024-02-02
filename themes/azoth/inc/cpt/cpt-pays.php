<?php
/* Register Custom Post Type Pays */
add_action('init', 'pays_post_type', 0);
function pays_post_type()
{
    $labels = [
        'name'                  => _x('Pays', 'Post Type General Name'),
        'singular_name'         => _x('Pays', 'Post Type Singular Name'),
        'menu_name'             => __('Pays'),
        'name_admin_bar'        => __('Pays'),
        'archives'              => __('Archives du Pays'),
        'attributes'            => __('Attributs du Pays'),
        'parent_item_colon'     => __('Parent du Pays :'),
        'all_items'             => __('Tous les Pays'),
        'add_new_item'          => __('Ajouter un nouveau Pays'),
        'add_new'               => __('Nouveau Pays'),
        'new_item'              => __('Nouveau Pays'),
        'edit_item'             => __('Modifier le Pays'),
        'update_item'           => __('Mettre à jour le Pays'),
        'view_item'             => __('Voir le Pays'),
        'view_items'            => __('Voir les Pays'),
        'search_items'          => __('Chercher des Pays'),
        'not_found'             => __('Aucun Pays trouvé'),
        'not_found_in_trash'    => __('Aucun Pays trouvé dans la corbeille'),
        'featured_image'        => __('Image mise en avant'),
        'set_featured_image'    => __('Définir l\'image mise en avant'),
        'remove_featured_image' => __('Supprimer l\'image mise en avant'),
        'use_featured_image'    => __('Utiliser comme image mise en avant'),
        'insert_into_item'      => __('Insérer dans ce Pays'),
        'uploaded_to_this_item' => __('Télécharger dans ce Pays'),
        'items_list'            => __('Liste des Pays'),
        'items_list_navigation' => __('Navigation dans la liste des Pays'),
        'filter_items_list'     => __('Filtrer la liste des Pays'),
    ];
    $args = [
        'label'                 => __('Pays'),
        'description'           => __('Pays'),
        'labels'                => $labels,
        'supports'              => array('title'),
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
    register_post_type('pays', $args);
}
<?php
/* Register Custom Post Type Formation */

add_action('init', 'formation_post_type', 0);
function formation_post_type()
{
    $labels = [
        'name'                  => _x('Formations', 'Post Type General Name'),
        'singular_name'         => _x('Formation', 'Post Type Singular Name'),
        'menu_name'             => __('Formations'),
        'name_admin_bar'        => __('Formation'),
        'archives'              => __('Archives de la Formation'),
        'attributes'            => __('Attributs de la Formation'),
        'parent_item_colon'     => __('Parent de la Formation :'),
        'all_items'             => __('Toutes les Formations'),
        'add_new_item'          => __('Ajouter une nouvelle Formation'),
        'add_new'               => __('Nouvelle Formation'),
        'new_item'              => __('Nouvelle Formation'),
        'edit_item'             => __('Modifier la Formation'),
        'update_item'           => __('Mettre à jour la Formation'),
        'view_item'             => __('Voir la Formation'),
        'view_items'            => __('Voir les Formations'),
        'search_items'          => __('Chercher des Formations'),
        'not_found'             => __('Aucune Formation trouvé'),
        'not_found_in_trash'    => __('Aucune Formation trouvée dans la corbeille'),
        'featured_image'        => __('Image mise en avant'),
        'set_featured_image'    => __('Définir l\'image mise en avant'),
        'remove_featured_image' => __('Supprimer l\'image mise en avant'),
        'use_featured_image'    => __('Utiliser comme image mise en avant'),
        'insert_into_item'      => __('Insérer dans cette Formation'),
        'uploaded_to_this_item' => __('Télécharger dans cette Formation'),
        'items_list'            => __('Liste des Formations'),
        'items_list_navigation' => __('Navigation dans la liste des Formations'),
        'filter_items_list'     => __('Filtrer la liste des Formations'),
    ];
    $args = [
        'label'                 => __('Formation'),
        'description'           => __('Formations'),
        'labels'                => $labels,
        'supports'              => array(),
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
    register_post_type('formation', $args);
}
<?php
/* Register Custom Post Type Voie */

add_action('init', 'voie_post_type', 0);
function voie_post_type()
{
    $labels = [
        'name'                  => _x('Voies', 'Post Type General Name'),
        'singular_name'         => _x('Voie', 'Post Type Singular Name'),
        'menu_name'             => __('Voies'),
        'name_admin_bar'        => __('Voie'),
        'archives'              => __('Archives de la Voie'),
        'attributes'            => __('Attributs de la Voie'),
        'parent_item_colon'     => __('Parent de la Voie :'),
        'all_items'             => __('Toutes les Voies'),
        'add_new_item'          => __('Ajouter une nouvelle Voie'),
        'add_new'               => __('Nouvelle Voie'),
        'new_item'              => __('Nouvelle Voie'),
        'edit_item'             => __('Modifier la Voie'),
        'update_item'           => __('Mettre à jour la Voie'),
        'view_item'             => __('Voir la Voie'),
        'view_items'            => __('Voir les Voies'),
        'search_items'          => __('Chercher des Voies'),
        'not_found'             => __('Aucune Voie trouvé'),
        'not_found_in_trash'    => __('Aucune Voie trouvée dans la corbeille'),
        'featured_image'        => __('Image mise en avant'),
        'set_featured_image'    => __('Définir l\'image mise en avant'),
        'remove_featured_image' => __('Supprimer l\'image mise en avant'),
        'use_featured_image'    => __('Utiliser comme image mise en avant'),
        'insert_into_item'      => __('Insérer dans cette Voie'),
        'uploaded_to_this_item' => __('Télécharger dans cette Voie'),
        'items_list'            => __('Liste des Voies'),
        'items_list_navigation' => __('Navigation dans la liste des Voies'),
        'filter_items_list'     => __('Filtrer la liste des Voies'),
    ];
    $args = [
        'label'                 => __('Voie'),
        'description'           => __('Voies'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail'),
        'taxonomies'            => array(),
        'hierarchical'          => false,
        'public'                => true,
        'show_in_rest'          => true, // Gutenberg
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    ];
    register_post_type('voie', $args);
}
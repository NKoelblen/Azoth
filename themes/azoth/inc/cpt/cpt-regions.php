<?php
/* Register Custom Post Type Région */

add_action('init', 'region_post_type', 0);
function region_post_type()
{
    $labels = [
        'name'                  => _x('Régions', 'Post Type General Name'),
        'singular_name'         => _x('Région', 'Post Type Singular Name'),
        'menu_name'             => __('Régions'),
        'name_admin_bar'        => __('Région'),
        'archives'              => __('Archives de la Région'),
        'attributes'            => __('Attributs de la Région'),
        'parent_item_colon'     => __('Parent de la Région :'),
        'all_items'             => __('Toutes les Régions'),
        'add_new_item'          => __('Ajouter une nouvelle Région'),
        'add_new'               => __('Nouvelle Région'),
        'new_item'              => __('Nouvelle Région'),
        'edit_item'             => __('Modifier la Région'),
        'update_item'           => __('Mettre à jour la Région'),
        'view_item'             => __('Voir la Région'),
        'view_items'            => __('Voir les Régions'),
        'search_items'          => __('Chercher des Régions'),
        'not_found'             => __('Aucune Région trouvé'),
        'not_found_in_trash'    => __('Aucune Région trouvée dans la corbeille'),
        'featured_image'        => __('Image mise en avant'),
        'set_featured_image'    => __('Définir l\'image mise en avant'),
        'remove_featured_image' => __('Supprimer l\'image mise en avant'),
        'use_featured_image'    => __('Utiliser comme image mise en avant'),
        'insert_into_item'      => __('Insérer dans cette Région'),
        'uploaded_to_this_item' => __('Télécharger dans cette Région'),
        'items_list'            => __('Liste des Régions'),
        'items_list_navigation' => __('Navigation dans la liste des Régions'),
        'filter_items_list'     => __('Filtrer la liste des Régions'),
    ];
    $args = [
        'label'                 => __('Région'),
        'description'           => __('Régions'),
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
    register_post_type('region', $args);
}
<?php
/* Register Custom Post Type Conférence */

add_action('init', 'conference_post_type', 0);
function conference_post_type()
{
    $labels = [
        'name'                  => _x('Conférences', 'Post Type General Name'),
        'singular_name'         => _x('Conférence', 'Post Type Singular Name'),
        'menu_name'             => __('Conférences'),
        'name_admin_bar'        => __('Conférence'),
        'archives'              => __('Archives de la Conférence'),
        'attributes'            => __('Attributs de la Conférence'),
        'parent_item_colon'     => __('Parent de la Conférence :'),
        'all_items'             => __('Toutes les Conférences'),
        'add_new_item'          => __('Ajouter une nouvelle Conférence'),
        'add_new'               => __('Nouvelle Conférence'),
        'new_item'              => __('Nouvelle Conférence'),
        'edit_item'             => __('Modifier la Conférence'),
        'update_item'           => __('Mettre à jour la Conférence'),
        'view_item'             => __('Voir la Conférence'),
        'view_items'            => __('Voir les Conférences'),
        'search_items'          => __('Chercher des Conférences'),
        'not_found'             => __('Aucune Conférence trouvé'),
        'not_found_in_trash'    => __('Aucune Conférence trouvée dans la corbeille'),
        'featured_image'        => __('Image mise en avant'),
        'set_featured_image'    => __('Définir l\'image mise en avant'),
        'remove_featured_image' => __('Supprimer l\'image mise en avant'),
        'use_featured_image'    => __('Utiliser comme image mise en avant'),
        'insert_into_item'      => __('Insérer dans cette Conférence'),
        'uploaded_to_this_item' => __('Télécharger dans cette Conférence'),
        'items_list'            => __('Liste des Conférences'),
        'items_list_navigation' => __('Navigation dans la liste des Conférences'),
        'filter_items_list'     => __('Filtrer la liste des Conférences'),
    ];
    $args = [
        'label'                 => __('Conférence'),
        'description'           => __('Conférences'),
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
    register_post_type('conference', $args);
}
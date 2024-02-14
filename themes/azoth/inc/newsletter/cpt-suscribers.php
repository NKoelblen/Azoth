<?php
/* Register Custom Post Type Abonné */

add_action('init', 'subscriber_post_type', 0);
function subscriber_post_type()
{
    $labels = [
        'name'                  => _x('Abonnés', 'Post Type General Name'),
        'singular_name'         => _x('Abonné', 'Post Type Singular Name'),
        'menu_name'             => __('Abonnés'),
        'name_admin_bar'        => __('Abonné'),
        'archives'              => __('Archives de l\'Abonné'),
        'attributes'            => __('Attributs de l\'Abonné'),
        'parent_item_colon'     => __('Parent de l\'Abonné :'),
        'all_items'             => __('Tous les Abonnés'),
        'add_new_item'          => __('Ajouter un Abonné'),
        'add_new'               => __('Nouvel Abonné'),
        'new_item'              => __('Nouvel Abonné'),
        'edit_item'             => __('Modifier l\'Abonné'),
        'update_item'           => __('Mettre à jour l\'Abonné'),
        'view_item'             => __('Voir l\'Abonné'),
        'view_items'            => __('Voir les Abonnés'),
        'search_items'          => __('Chercher des Abonnés'),
        'not_found'             => __('Aucun Abonné trouvé'),
        'not_found_in_trash'    => __('Aucun Abonné trouvée dans la corbeille'),
        'featured_image'        => __('Image mise en avant'),
        'set_featured_image'    => __('Définir l\'image mise en avant'),
        'remove_featured_image' => __('Supprimer l\'image mise en avant'),
        'use_featured_image'    => __('Utiliser comme image mise en avant'),
        'insert_into_item'      => __('Insérer dans cet Abonné'),
        'uploaded_to_this_item' => __('Télécharger dans cet Abonné'),
        'items_list'            => __('Liste des Abonnés'),
        'items_list_navigation' => __('Navigation dans la liste des Abonnés'),
        'filter_items_list'     => __('Filtrer la liste des Abonnés'),
    ];
    $args = [
        'label'                 => __('Abonné'),
        'description'           => __('Abonnés'),
        'labels'                => $labels,
        'supports'              => false,
        'taxonomies'            => [],
        'hierarchical'          => false,
        'public'                => true,
        'show_in_rest'          => false, // Gutenberg
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
    ];
    register_post_type('subscriber', $args);
}
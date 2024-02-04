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
        'archives'              => __('Archives de l\'Instructeur'),
        'attributes'            => __('Attributs de \'Instructeur'),
        'parent_item_colon'     => __('Parent de l\'Instructeur :'),
        'all_items'             => __('Tous les Instructeurs'),
        'add_new_item'          => __('Ajouter un nouvel Instructeur'),
        'add_new'               => __('Nouvel Instructeur'),
        'new_item'              => __('Nouvel Instructeur'),
        'edit_item'             => __('Modifier l\'Instructeur'),
        'update_item'           => __('Mettre à jour l\'Instructeur'),
        'view_item'             => __('Voir l\'Instructeur'),
        'view_items'            => __('Voir les Instructeurs'),
        'search_items'          => __('Chercher des Instructeurs'),
        'not_found'             => __('Aucun Instructeur trouvé'),
        'not_found_in_trash'    => __('Aucun Instructeur trouvé dans la corbeille'),
        'featured_image'        => __('Portrait'),
        'set_featured_image'    => __('Ajouter une image'),
        'remove_featured_image' => __('Supprimer l\'image'),
        'use_featured_image'    => __('Utiliser comme image'),
        'insert_into_item'      => __('Insérer dans cet Instructeur'),
        'uploaded_to_this_item' => __('Télécharger dans cet Instructeur'),
        'items_list'            => __('Liste des Instructeurs'),
        'items_list_navigation' => __('Navigation dans la liste des Instructeurs'),
        'filter_items_list'     => __('Filtrer la liste des Instructeurs'),
    ];
    $args = [
        'label'                 => __('Instructeur'),
        'description'           => __('Instructeurs'),
        'labels'                => $labels,
        'supports'              => ['title'],
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
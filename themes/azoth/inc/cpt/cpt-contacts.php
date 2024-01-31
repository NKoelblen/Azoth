<?php
/* Register Custom Post Type Contact */
add_action('init', 'contact_post_type', 0);
function contact_post_type()
{
    $labels = [
        'name'                  => _x('Contacts', 'Post Type General Name'),
        'singular_name'         => _x('Contact', 'Post Type Singular Name'),
        'menu_name'             => __('Contacts'),
        'name_admin_bar'        => __('Contact'),
        'archives'              => __('Archives du Contact'),
        'attributes'            => __('Attributs du Contact'),
        'parent_item_colon'     => __('Parent du Contact :'),
        'all_items'             => __('Tous les Contacts'),
        'add_new_item'          => __('Ajouter un nouveau Contact'),
        'add_new'               => __('Nouveau Contact'),
        'new_item'              => __('Nouveau Contact'),
        'edit_item'             => __('Modifier le Contact'),
        'update_item'           => __('Mettre à jour le Contact'),
        'view_item'             => __('Voir le Contact'),
        'view_items'            => __('Voir les Contacts'),
        'search_items'          => __('Chercher des Contacts'),
        'not_found'             => __('Aucun Contact trouvé'),
        'not_found_in_trash'    => __('Aucun Contact trouvé dans la corbeille'),
        'featured_image'        => __('Image mise en avant'),
        'set_featured_image'    => __('Définir l\'image mise en avant'),
        'remove_featured_image' => __('Supprimer l\'image mise en avant'),
        'use_featured_image'    => __('Utiliser comme image mise en avant'),
        'insert_into_item'      => __('Insérer dans ce Contact'),
        'uploaded_to_this_item' => __('Télécharger dans ce Contact'),
        'items_list'            => __('Liste des Contacts'),
        'items_list_navigation' => __('Navigation dans la liste des Contacts'),
        'filter_items_list'     => __('Filtrer la liste des Contacts'),
    ];
    $args = [
        'label'                 => __('Contact'),
        'description'           => __('Contacts'),
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
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    ];
    register_post_type('contact', $args);
}
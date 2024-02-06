<?php
function register_geo_zone() {
    
    // Déclaration de la Taxonomie
    $labels = array(
        'name'                  => 'Zones géographiques',
        'singular_name'         => 'Zone géographique',
        'search_items'          => 'Chercher une Zone géographique',
        'popular_items'         => 'Zones populaires',
        'all_items'             => 'Toutes les Zones géographiques',
        'parent_item'           => 'Zone géographique parente',
        'edit_item'             => 'Modifier la Zone géographique',
        'view_item'             => 'Voir la Zone géographique',
        'update_item'           => 'Mettre à jour la Zone géographique',
        'add_new_item'          => 'Ajouter une Zone géographique',
        'new_item_name'         => 'Nouvelle Zone géographique',
        'not_found'             => 'Aucune Zone géographique trouvée',
        'no_terms'              => 'Aucune Zone géographique',
        'filter_by_items'       => 'Filtrer par Zone géographique',
        'back_to_items'         => 'Retour aux Zones géographiques',
        'item_link'             => 'Lien vers la Zone géographique',
        'item_link_description' => 'Un lien vers la Zone géographique',
    );
    
    $args = array( 
        'labels'                => $labels,
        'public'                => true, 
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_rest'          => true,
        'hierarchical'          => true,
        'show_in_quick_edit'    => false,
        'meta_box_cb'           => false,
        'show_admin_column'     => true,
        'capabilities'  => [
            'manage_terms'  => 'manage_categories',
            'edit_terms'    => 'edit_lieux',
            'delete_terms'  => 'manage_categories',
            'assign_terms'  => 'edit_lieux'
        ]
    );

    register_taxonomy( 'geo_zone', 'lieu', $args );
}
add_action( 'init', 'register_geo_zone' );

function register_stage_categorie() {
    
    // Déclaration de la Taxonomie
    $labels = array(
        'name'                  => 'Catégories',
        'singular_name'         => 'Catégorie',
        'search_items'          => 'Chercher une Catégorie',
        'popular_items'         => 'Catégories populaires',
        'all_items'             => 'Toutes les Catégories',
        'parent_item'           => 'Catégorie parente',
        'edit_item'             => 'Modifier la Catégorie',
        'view_item'             => 'Voir la Catégorie',
        'update_item'           => 'Mettre à jour la Catégorie',
        'add_new_item'          => 'Ajouter une Catégorie',
        'new_item_name'         => 'Nouvelle Catégorie',
        'not_found'             => 'Aucune Catégorie trouvée',
        'no_terms'              => 'Aucune Catégorie',
        'filter_by_items'       => 'Filtrer par Catégorie',
        'back_to_items'         => 'Retour aux Catégories',
        'item_link'             => 'Lien vers la Catégorie',
        'item_link_description' => 'Un lien vers la Catégorie',
    );
    
    $args = array( 
        'labels'                => $labels,
        'public'                => true, 
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_rest'          => true,
        'hierarchical'          => true,
        'show_in_quick_edit'    => false,
        'meta_box_cb'           => false,
        'show_admin_column'     => true,
        'capabilities'  => [
            'manage_terms'  => 'manage_categories',
            'edit_terms'    => 'manage_categories',
            'delete_terms'  => 'manage_categories',
            'assign_terms'  => 'edit_evenements'
        ]
    );

    register_taxonomy( 'stage_categorie', 'stage', $args );
}
add_action( 'init', 'register_stage_categorie' );

function register_prerequis() {
    
    // Déclaration de la Taxonomie
    $labels = array(
        'name'                  => 'Prérequis',
        'singular_name'         => 'Prérequis',
        'search_items'          => 'Chercher un Prérequis',
        'popular_items'         => 'Prérequis populaires',
        'all_items'             => 'Tous les Prérequis',
        'parent_item'           => 'Prérequis parent',
        'edit_item'             => 'Modifier le Prérequis',
        'view_item'             => 'Voir le Prérequis',
        'update_item'           => 'Mettre à jour le Prérequis',
        'add_new_item'          => 'Ajouter un Prérequis',
        'new_item_name'         => 'Nouveau Prérequis',
        'not_found'             => 'Aucun Prérequis trouvée',
        'no_terms'              => 'Aucun Prérequis',
        'filter_by_items'       => 'Filtrer par Prérequis',
        'back_to_items'         => 'Retour aux Prérequis',
        'item_link'             => 'Lien vers le Prérequis',
        'item_link_description' => 'Un lien vers le Prérequis',
    );
    
    $args = array( 
        'labels'                => $labels,
        'public'                => true, 
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_rest'          => true,
        'hierarchical'          => true,
        'show_in_quick_edit'    => false,
        'meta_box_cb'           => false,
        'show_admin_column'     => false,
        'capabilities'  => [
            'manage_terms'  => 'manage_categories',
            'edit_terms'    => 'edit_evenements',
            'delete_terms'  => 'manage_categories',
            'assign_terms'  => 'edit_evenements'
        ]
    );

    register_taxonomy( 'prerequis', ['formation', 'stage'], $args );
}
add_action( 'init', 'register_prerequis' );

function register_media_categorie() {
    
    // Déclaration de la Taxonomie
    $labels = array(
        'name'                  => 'Catégories',
        'singular_name'         => 'Catégorie',
        'search_items'          => 'Chercher une Catégorie',
        'popular_items'         => 'Catégories populaires',
        'all_items'             => 'Toutes les Catégories',
        'parent_item'           => 'Catégorie parente',
        'edit_item'             => 'Modifier la Catégorie',
        'view_item'             => 'Voir la Catégorie',
        'update_item'           => 'Mettre à jour la Catégorie',
        'add_new_item'          => 'Ajouter une Catégorie',
        'new_item_name'         => 'Nouvelle Catégorie',
        'not_found'             => 'Aucune Catégorie trouvée',
        'no_terms'              => 'Aucune Catégorie',
        'filter_by_items'       => 'Filtrer par Catégorie',
        'back_to_items'         => 'Retour aux Catégories',
        'item_link'             => 'Lien vers la Catégorie',
        'item_link_description' => 'Un lien vers la Catégorie',
    );
    
    $args = array( 
        'labels'                => $labels,
        'public'                => true, 
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_rest'          => true,
        'hierarchical'          => true,
        'show_in_quick_edit'    => false,
        'meta_box_cb'           => "post_categories_meta_box",
        'show_admin_column'     => true,
        'capabilities'  => [
            'manage_terms'  => 'manage_categories',
            'edit_terms'    => 'manage_categories',
            'delete_terms'  => 'manage_categories',
            'assign_terms'  => 'manage_categories'
        ]
    );

    register_taxonomy( 'media_categorie', 'attachment', $args );
}
add_action( 'init', 'register_media_categorie' );
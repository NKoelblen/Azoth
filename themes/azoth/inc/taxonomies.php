<?php
function register_taxonomies() {
    
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
        'show_in_menu'          => false,
        'show_in_rest'          => true,
        'hierarchical'          => true,
        'show_in_quick_edit'    => true,
        'meta_box_cb'           => false,
        'show_admin_column'     => true,
    );

    register_taxonomy( 'geo_zone', 'lieu', $args );
}
add_action( 'init', 'register_taxonomies' );
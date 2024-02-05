<?php
/**
 * Admin Filters
 */
apply_filters('disable_months_dropdown', true, 'voie' );
apply_filters('disable_months_dropdown', true, 'instructeur' );
apply_filters('disable_months_dropdown', true, 'lieu' );
apply_filters('disable_months_dropdown', true, 'contact' );

/**
 * Admin Columns
 */

/* Voies */

add_filter( 'manage_voie_posts_columns', function ( $columns ) {
	unset( $columns['date'] );
	return $columns;
});

/* Instructeurs */

add_filter('manage_instructeur_posts_columns', function ($columns) {
    $newColumns = [
        'cb'        => $columns['cb'],
        'thumbnail' => 'Miniature',
        'title'     => 'Nom',
        'fonction'  => 'Fonction'
    ];
    return $newColumns;
});

add_filter('manage_instructeur_posts_custom_column', function ($column, $postId) {
    if ($column === 'thumbnail') :
        the_post_thmubnail('thumbnail', $postID);
    endif;
    if ($column === 'fonction') :
        echo get_post_meta($postId, 'i_fonction', true);
    endif;
}, 10, 2);

add_filter( 'manage_edit-instructeur_sortable_columns', function( $columns ) { 
    $columns['fonction'] = 'Fonction';
    return $columns;
});

/* Lieux */

add_filter( 'manage_lieu_posts_columns', function ( $columns ) {
	unset( $columns['date'] );
	return $columns;
});

add_filter( 'manage_edit-lieu_sortable_columns', function( $columns ) { 
    $columns['taxonomy-geo_zone'] = 'Zone géographique';
    return $columns;
});

/* Contact */

add_filter( 'manage_contact_posts_columns', function ( $columns ) {
	unset( $columns['date'] );
	return $columns;
});

/* Conférences */

add_filter('manage_conference_posts_columns', function ($columns) {
    $newColumns = [
        'cb'        => $columns['cb'],
        'author'  => 'Instructeur',
        'lieu'  => 'Lieu',
        'e_date'  => 'Date',
        'heure' => 'Heure',
    ];
    return $newColumns;
});

add_filter('manage_conference_posts_custom_column', function ($column, $postId) {
    if ($column === 'lieu') :
        if(get_post_meta($postId, 'lieu', true) !== "") :
            echo get_the_title(get_post_meta($postId, 'lieu', true));
        endif;    elseif ($column === 'e_date') :
        echo get_post_meta($postId, 'e_date_du', true);
    elseif ($column === 'heure') :
        echo get_post_meta($postId, 'e_heure', true);
    endif;
}, 10, 2);

add_filter( 'manage_edit-conference_sortable_columns', function( $columns ) { 
    $columns['author'] = 'Instructeur';
    $columns['lieu'] = 'Lieu';
    $columns['e_date'] = 'Date';
    return $columns;
});

/* Formations */

add_filter('manage_formation_posts_columns', function ($columns) {
    $newColumns = [
        'cb'        => $columns['cb'],
        'voie' => 'Voie',
        'author'  => 'Instructeur',
        'lieu'  => 'Lieu',
        'session' => 'Session',
        'date_du'  => 'Du...',
        'date_au' => '... Au',
    ];
    return $newColumns;
});

add_filter('manage_formation_posts_custom_column', function ($column, $postId) {
    if ($column === 'voie') :
        if(get_post_meta($postId, 'e_voie', true) !== "") :
            echo get_the_title(get_post_meta($postId, 'e_voie', true));
        endif;
    elseif ($column === 'lieu') :
        if(get_post_meta($postId, 'lieu', true) !== "") :
            echo get_the_title(get_post_meta($postId, 'lieu', true));
        endif;
    elseif ($column === 'session') :
        echo 'Session n° ' . get_post_meta($postId, 'e_session', true);
    elseif ($column === 'date_du') :
        echo get_post_meta($postId, 'e_date_du', true);
    elseif ($column === 'date_au') :
    echo get_post_meta($postId, 'e_date_au', true);
    endif;
}, 10, 2);

add_filter( 'manage_edit-formation_sortable_columns', function( $columns ) { 
    $columns['voie'] = 'Voie';
    $columns['author'] = 'Instructeur';
    $columns['lieu'] = 'Lieu';
    $columns['session'] = 'Session';
    $columns['date_du'] = 'Date';
    return $columns;
});

/* Stages */

add_filter('manage_stage_posts_columns', function ($columns) {
    $newColumns = [
        'cb'        => $columns['cb'],
        'taxonomy-stage_categorie' => 'Catégorie',
        'voie' => 'Voie',
        'author'  => 'Instructeur',
        'lieu'  => 'Lieu',
        'date_du'  => 'Du...',
        'date_au' => '... Au',
    ];
    return $newColumns;
});

add_filter('manage_stage_posts_custom_column', function ($column, $postId) {
    if ($column === 'voie') :
        if(get_post_meta($postId, 'e_voie', true) !== "") :
            echo get_the_title(get_post_meta($postId, 'e_voie', true));
        endif;
    elseif ($column === 'lieu') :
        if(get_post_meta($postId, 'lieu', true) !== "") :
            echo get_the_title(get_post_meta($postId, 'lieu', true));
        endif;
    elseif ($column === 'date_du') :
        echo get_post_meta($postId, 'e_date_du', true);
    elseif ($column === 'date_au') :
    echo get_post_meta($postId, 'e_date_au', true);
    endif;
}, 10, 2);

add_filter( 'manage_edit-stage_sortable_columns', function( $columns ) { 
    $columns['taxonomy-stage_categorie'] = 'Catégorie';
    $columns['voie'] = 'Voie';
    $columns['author'] = 'Instructeur';
    $columns['lieu'] = 'Lieu';
    $columns['date_du'] = 'Date';
    return $columns;
});
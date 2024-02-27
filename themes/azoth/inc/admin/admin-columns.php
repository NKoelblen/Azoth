<?php
/* All */
add_filter('manage_page_posts_columns', 'remove_yoast_columns', 18, 1);
add_filter('manage_post_posts_columns', 'remove_yoast_columns', 18, 1);
add_filter('manage_voie_posts_columns', 'remove_yoast_columns', 18, 1);
add_filter('manage_instructeur_posts_columns', 'remove_yoast_columns', 18, 1);
add_filter('manage_lieu_posts_columns', 'remove_yoast_columns', 18, 1);
add_filter('manage_contact_posts_columns', 'remove_yoast_columns', 18, 1);
add_filter('manage_conference_posts_columns', 'remove_yoast_columns', 18, 1);
add_filter('manage_formation_posts_columns', 'remove_yoast_columns', 18, 1);
add_filter('manage_stage_posts_columns', 'remove_yoast_columns', 18, 1);
add_filter('manage_susbscriber_posts_columns', 'remove_yoast_columns', 18, 1);
function remove_yoast_columns($columns)
{
    unset($columns['wpseo-score']);
    unset($columns['wpseo-score-readability']);
    unset($columns['wpseo-title']);
    unset($columns['wpseo-metadesc']);
    unset($columns['wpseo-focuskw']);
    unset($columns['wpseo-links']);
    unset($columns['wpseo-linked']);
    return $columns;
}

/* Pages, Voies & Lieux */
add_filter('manage_page_posts_columns', 'remove_date_column');
add_filter('manage_voie_posts_columns', 'remove_date_column');
add_filter('manage_lieu_posts_columns', 'remove_date_column');
add_filter('manage_contact_posts_columns', 'remove_date_column');
function remove_date_column($columns)
{
    unset($columns['date']);
    return $columns;
}

/* Instructeurs */

add_filter('manage_instructeur_posts_columns', function ($columns) {
    $newColumns = [
        'cb' => $columns['cb'],
        'thumbnail' => 'Miniature',
        'title' => 'Nom',
        'fonction' => 'Fonction'
    ];
    return $newColumns;
});

add_filter('manage_instructeur_posts_custom_column', function ($column, $postId) {
    if ($column === 'thumbnail'):
        the_post_thumbnail('thumbnail', $postId);
    endif;
    if ($column === 'fonction'):
        echo get_post_meta($postId, 'i_fonction', true);
    endif;
}, 10, 2);

add_filter('manage_edit-instructeur_sortable_columns', function ($columns) {
    $columns['fonction'] = 'Fonction';
    return $columns;
});

/* Lieux */

add_filter('manage_edit-lieu_sortable_columns', function ($columns) {
    $columns['taxonomy-geo_zone'] = 'Zone géographique';
    return $columns;
});

/* Conférences */

add_filter('manage_conference_posts_columns', function ($columns) {
    $newColumns = [
        'cb' => $columns['cb'],
        'title' => 'Intitulé',
        'author' => 'Instructeur',
        'e_date' => 'Date',
    ];
    return $newColumns;
});

add_filter('manage_conference_posts_custom_column', function ($column, $postId) {
    if ($column === 'e_date'):
        echo date_i18n('d/m/Y', strtotime(get_post_meta($postId, 'e_date_du', true)));
    endif;
}, 10, 2);

add_filter('manage_edit-conference_sortable_columns', function ($columns) {
    $columns['author'] = 'Instructeur';
    $columns['e_date'] = 'Date';
    return $columns;
});

/**
 * Formations & Stages
 */

add_filter('manage_formation_posts_custom_column', 'fs_custom_columns', 10, 2);
add_filter('manage_stage_posts_custom_column', 'fs_custom_columns', 10, 2);
function fs_custom_columns($column, $postId)
{
    switch ($column) {
        case 'session':
            echo get_post_meta($postId, 'e_session', true);
            break;
        case 'date_du':
            echo date_i18n('d/m/Y', strtotime(get_post_meta($postId, 'e_date_du', true)));
            break;
        case 'date_au':
            echo date_i18n('d/m/Y', strtotime(get_post_meta($postId, 'e_date_au', true)));
    }
}

add_filter('manage_edit-formation_sortable_columns', 'fs_sortable_columns');
add_filter('manage_edit-stage_sortable_columns', 'fs_sortable_columns');
function fs_sortable_columns($columns)
{
    $columns['author'] = 'Instructeur';
    $columns['session'] = 'Session';
    $columns['date_du'] = 'Date';
    return $columns;
}

/* Formations */

add_filter('manage_formation_posts_columns', function ($columns) {
    $newColumns = [
        'cb' => $columns['cb'],
        'title' => 'Intitulé',
        'author' => 'Instructeur',
        'session' => 'Session',
        'date_du' => 'Du...',
        'date_au' => '... Au',
    ];
    return $newColumns;
});

/* Stages */

add_filter('manage_stage_posts_columns', function ($columns) {
    $newColumns = [
        'cb' => $columns['cb'],
        'title' => 'Intitulé',
        'author' => 'Instructeur',
        'date_du' => 'Du...',
        'date_au' => '... Au',
    ];
    return $newColumns;
});

/* Medias */

add_filter('manage_upload_columns', function ($columns) {
    unset($columns['author']);
    unset($columns['date']);
    unset($columns['comments']);
    return $columns;
});
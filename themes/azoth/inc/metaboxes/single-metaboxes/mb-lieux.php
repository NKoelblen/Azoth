<?php
/* Lieu Metabox */

if (class_exists('MetaboxGenerator')) {
    $mb_lieu = new MetaboxGenerator; // Defined in ../mb-generator
};

/**
 *** How tu use : ***
 * method set_screens($post_types) ; method set_fields($groups_of_fields)
 * Refer to ./mb_generator comments
 */

$mb_lieu->set_screens(['lieu']);

$mb_lieu->set_labels(
    [
        'slug' => 'informations',
        'name'  => 'Informations'
    ]
);

$pays_posts = new WP_Query(
    [
        'post_type'     => 'pays',
        'post_status'   => 'publish',
        'order_by'      => 'title',
        'order'         => 'ASC'
    ]
);
$pays = [];
if ($pays_posts->have_posts()) :
    while ($pays_posts->have_posts()) :
        $pays_posts->the_post();
        $pays[] =
            [
                'id'    => get_the_ID(),
                'title' => get_the_title()
            ];
    endwhile;
endif;
wp_reset_postdata();

$region_posts = new WP_Query(
    [
        'post_type'     => 'region',
        'post_status'   => 'publish',
        'order_by'      => 'title',
        'order'         => 'ASC'
    ]
);
$regions = [];
if ($region_posts->have_posts()) :
    while ($region_posts->have_posts()) :
        $region_posts->the_post();
        $regions[] =
            [
                'id'    => get_the_ID(),
                'title' => get_the_title()
            ];
    endwhile;
endif;
wp_reset_postdata();

$fields = [
    [
        'group_label' => 'Nom', // group_label required, can be empty
        [
            'id'    => 'title',
            'type'  => 'text'
        ], // title
    ], // group
    [
        'group_label' => 'Localité', // group_label required, can be empty
        [
            'label'     => 'Pays',
            'id'        => 'l_pays',
            'type'      => 'select',
            'options'   => $pays,
            'width'     => '49.7%'
        ], // pays
        [
            'label'     => 'Région',
            'id'        => 'l_region',
            'type'      => 'select',
            'options'   => $regions,
            'width'     => '49.7%',
            'display'   => 'none'
        ], // region
        [
            'label'     => 'Carte',
            'id'        => 'l_carte',
            'type'      => 'map'
        ] // carte
    ], // localité
    [
        'group_label' => 'Photo', // group_label required, can be empty
        [
            'id'    => 'thumbnail',
            'type'  => 'media-library-uploader'
        ], // thumbnail
    ],
    [
        'group_label' => 'Description', // group_label required, can be empty
        [
            'id'    => 'content',
            'type'  => 'WYSIWYG'
        ] // content
    ], // group
]; // fields
$mb_lieu->set_fields($fields);
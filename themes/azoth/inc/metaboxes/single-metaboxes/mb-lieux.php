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

$mb_lieu->set_fields(
    [
        [
            'group_label' => 'Localité', // group_label required, can be empty
            [
                'id'        => 'l_zone',
                'type'      => 'taxonomy',
                'taxonomy'  => 'geo_zone'
            ], // zone
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
    ] // fields
);
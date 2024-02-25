<?php
/* Lieu Metabox */

function lieu_fields()
{
    $fields = [
        [
            'group_label' => 'Localité', // group_label required, can be empty
            [
                'id' => 'l_zone',
                'type' => 'taxonomy',
                'taxonomy' => 'geo_zone',
                'required' => true
            ], // zone
            [
                'id' => 'l_carte',
                'type' => 'map',
                'required' => true
            ] // carte
        ], // localité
        [
            'group_label' => 'Photo', // group_label required, can be empty
            [
                'id' => 'thumbnail',
                'type' => 'media-library-uploader'
            ], // thumbnail
        ],
        [
            'group_label' => 'Description', // group_label required, can be empty
            [
                'id' => 'content',
                'type' => 'WYSIWYG'
            ] // content
        ], // group
    ]; // fields
    return $fields;
}

if (class_exists('MetaboxGenerator')) {
    $mb_lieu = new MetaboxGenerator; // Defined in ../mb-generator
}
;

/**
 *** How tu use : ***
 * method set_screens($post_types) ; method set_fields($groups_of_fields)
 * Refer to ./mb_generator comments
 */

$mb_lieu->set_screens(['lieu']);

$mb_lieu->set_args(
    [
        'id' => 'informations',
        'title' => 'Informations',
        'context' => 'advanced',
    ]
);

$mb_lieu->set_fields(lieu_fields());
<?php
/* Voie Metabox */

if (class_exists('MetaboxGenerator')) {
    $mb_voie = new MetaboxGenerator; // Defined in ../mb-generator
};

/**
 *** How tu use : ***
 * method set_screens($post_types) ; method set_fields($groups_of_fields)
 * Refer to ./mb_generator comments
 */

$mb_voie->set_screens(['voie']);

$mb_voie->set_labels(
    [
        'slug' => 'informations',
        'name'  => 'Informations'
    ]
);

$mb_voie->set_fields(
    [
        [
            'group_label' => '', // group_label required, can be empty
            [
                'label' => 'Ordre',
                'id'    => 'v_ordre',
                'type'  => 'number'
            ], // ordre
            [
                'label' => 'Déroulement de la formation',
                'id'    => 'v_conditions',
                'type'  => 'WYSIWYG'
            ] // conditions
        ], // group
    ] // fields
);
<?php
/* Contact Metabox */

if (class_exists('MetaboxGenerator')) {
    $mb_contact = new MetaboxGenerator; // Defined in ../mb-generator
};

/**
 *** How tu use : ***
 * method set_screens($post_types) ; method set_fields($groups_of_fields)
 * Refer to ./mb_generator comments
 */

$mb_contact->set_screens(['contact']);

$mb_contact->set_labels(
    [
        'slug' => 'informations',
        'name'  => 'Informations'
    ]
);

$mb_contact->set_fields(
    [
        [
            'group_label' => 'Intitulé', // group_label required, can be empty
            [
                'id'    => 'title',
                'type'  => 'text'
            ], // title
        ], // group
        [
            'group_label' => 'Nom', // group_label required, can be empty
            [
                'id'    => 'c_nom',
                'type'  => 'text'
            ] // nom
        ], // group
        [
            'group_label' => 'Coordonnées', // group_label required, can be empty
            [
                'label' => 'Email',
                'id'    => 'c_email',
                'type'  => 'email'
            ], // title
            [
                'label' => 'Téléphone',
                'id'    => 'c_telephone',
                'type'  => 'text'
            ] // nom
        ], // group
    ] // fields
);
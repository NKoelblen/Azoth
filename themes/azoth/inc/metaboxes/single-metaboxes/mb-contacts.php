<?php
/**
 * CONTACT METABOX
 */

function contact_fields()
{
    $fields = [
        [
            'group_label' => 'Nom', // group_label required, can be empty
            [
                'id' => 'c_nom',
                'type' => 'text'
            ] // nom
        ], // nom
        [
            'group_label' => 'Coordonnées', // group_label required, can be empty
            [
                'label' => 'Email',
                'id' => 'c_email',
                'type' => 'email'
            ], // title
            [
                'label' => 'Téléphone',
                'id' => 'c_telephone',
                'type' => 'text'
            ] // téléphone
        ], // coordonnées
    ]; // fields
    return $fields;
}

if (class_exists('MetaboxGenerator')) {
    $mb_contact = new MetaboxGenerator; // Defined in ../mb-generator
}
;

/*** How tu use : ***
 * 
 * method set_screens($post_types) ; method set_labels($labels) ; method set_fields($groups_of_fields)
 * Refer to ./mb_generator comments
 */

$mb_contact->set_screens(['contact']);
$mb_contact->set_args(
    [
        'id' => 'informations',
        'title' => 'Informations',
        'context' => 'advanced',
    ]
);
$mb_contact->set_fields(contact_fields());
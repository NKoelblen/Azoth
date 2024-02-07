<?php
/* Formations Metabox */

if (class_exists('MetaboxGenerator')) {
    $mb_formation = new MetaboxGenerator; // Defined in ../mb-generator
};

/**
 *** How tu use : ***
 * method set_screens($post_types) ; method set_fields($groups_of_fields)
 * Refer to ./mb_generator comments
 */

$mb_formation->set_screens(['formation']);

$mb_formation->set_args(
    [
        'id' => 'informations',
        'title'  => 'Informations',
        'context' => 'advanced',
    ]
);

$mb_formation->set_fields(evenement_fields('formation'));
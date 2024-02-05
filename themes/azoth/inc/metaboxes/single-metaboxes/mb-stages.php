<?php
/* Stages Metabox */

if (class_exists('MetaboxGenerator')) {
    $mb_stage = new MetaboxGenerator; // Defined in ../mb-generator
};

/**
 *** How tu use : ***
 * method set_screens($post_types) ; method set_fields($groups_of_fields)
 * Refer to ./mb_generator comments
 */

$mb_stage->set_screens(['stage']);

$mb_stage->set_labels(
    [
        'slug'  => 'informations',
        'name'  => 'Informations'
    ]
);

$mb_stage->set_fields(evenement_fields('stage'));
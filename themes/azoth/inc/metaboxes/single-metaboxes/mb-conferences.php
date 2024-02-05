<?php
/* Conférences Metabox */

if (class_exists('MetaboxGenerator')) {
    $mb_conference = new MetaboxGenerator; // Defined in ../mb-generator
};

/**
 *** How tu use : ***
 * method set_screens($post_types) ; method set_fields($groups_of_fields)
 * Refer to ./mb_generator comments
 */

$mb_conference->set_screens(['conference']);

$mb_conference->set_labels(
    [
        'slug' => 'informations',
        'name'  => 'Informations'
    ]
);

$mb_conference->set_fields(evenement_fields('conference'));
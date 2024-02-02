<?php
/* Instructeur Metabox */

if (class_exists('MetaboxGenerator')) {
    $mb_instructeur = new MetaboxGenerator; // Defined in ../mb-generator
};

/**
 *** How tu use : ***
 * method set_screens($post_types) ; method set_fields($groups_of_fields)
 * Refer to ./mb_generator comments
 */

$mb_instructeur->set_screens(['instructeur']);

$mb_instructeur->set_labels(
    [
        'slug' => 'informations',
        'name'  => 'Informations'
    ]
);

$users_query = new WP_User_Query(
    [
        'role__in'  => array( 'administrator', 'editor', 'author'),
        'orderby'   => 'display_name',
        'order'     => 'ASC'
    ]
);
$users = $users_query->get_results();
$users_infos = [];
if ($users) :
	foreach ($users as $user) :
        $users_infos[] = [
            'id'=> $user->ID,
            'title'=> $user->display_name,
        ];
    endforeach;
endif;

$fields = [
    [
        'group_label' => 'Nom', // group_label required, can be empty
        [
            'label' => '',
            'id'    => 'title',
            'type'  => 'text'
        ], // title
    ],
    [
        'group_label' => 'Portrait', // group_label required, can be empty
        [
            'label' => '',
            'id'    => 'thumbnail',
            'type'  => 'media-library-uploader'
        ], // thumbnail
    ],
    [
        'group_label' => 'Biographie', // group_label required, can be empty
        [
            'label' => '',
            'id'    => 'content',
            'type'  => 'WYSIWYG'
        ] // content
    ], // identité
    [
        'group_label' => 'Coordonnées', // group_label required, can be empty
        [
            'label' => 'E-mail',
            'id'    => 'i_email',
            'type'  => 'email',
            'width' => '49.7%'
        ], // email
        [
            'label' => 'Téléphone',
            'id'    => 'i_telephone',
            'type'  => 'text',
            'width' => '49.7%'
        ] // telephone
    ], // coordonnées
]; // fields
if (current_user_can( 'edit_pages' )) :
    $fields[] = [
        'group_label' => 'Informations avancées', // group_label required, can be empty
        [
            'label'     => 'Compte',
            'id'        => 'i_compte',
            'type'      => 'select',
            'options'   => $users_infos
        ], // compte
        [
            'label'     => 'Fonction',
            'default'   => 'Instructeur',
            'id'        => 'i_fonction',
            'type'      => 'text',
            'width'     => '74.7%'
        ], // fonction
        [
            'label'     => 'Ordre',
            'default'   => 3,
            'id'        => 'i_ordre',
            'type'      => 'number',
            'width'     => '24.7%'
        ]
    ]; // ordre
endif;
$mb_instructeur->set_fields($fields);
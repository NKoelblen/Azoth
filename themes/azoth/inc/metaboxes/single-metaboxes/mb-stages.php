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
        'slug' => 'informations',
        'name'  => 'Informations'
    ]
);

$voie_posts = new WP_Query(
    [
        'post_type'         => 'voie',
        'post_status'       => 'publish',
        'order_by'          => 'title',
        'order'             => 'ASC',
        'posts_per_page'    => -1
    ]
);
$voies = [];
if ($voie_posts->have_posts()) :
    while ($voie_posts->have_posts()) :
        $voie_posts->the_post();
        $voies[] =
            [
                'id'    => get_the_ID(),
                'title' => get_the_title()
            ];
    endwhile;
endif;
wp_reset_postdata();

$lieu_posts = new WP_Query(
    [
        'post_type'         => 'lieu',
        'post_status'       => 'publish',
        'order_by'          => 'title',
        'order'             => 'ASC',
        'posts_per_page'    => -1
    ]
);
$lieux = [];
if ($lieu_posts->have_posts()) :
    while ($lieu_posts->have_posts()) :
        $lieu_posts->the_post();
        $lieux[] =
            [
                'id'    => get_the_ID(),
                'title' => get_the_title()
            ];
    endwhile;
endif;
wp_reset_postdata();

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

$contact_posts = new WP_Query(
    [
        'post_type'         => 'contact',
        'post_status'       => 'publish',
        'order_by'          => 'title',
        'order'             => 'ASC',
        'posts_per_page'    => -1
    ]
);
$contacts = [];
if ($contact_posts->have_posts()) :
    while ($contact_posts->have_posts()) :
        $contact_posts->the_post();
        $contacts[] =
            [
                'id'    => get_the_ID(),
                'title' => get_the_title()
            ];
    endwhile;
endif;
wp_reset_postdata();

$fields = [
    'categorie' => [
        'group_label' => 'Catégorie', // group_label required, can be empty
        [
            'id'        => 's_categorie',
            'type'      => 'taxonomy',
            'taxonomy'  => 'stage_categorie'
        ] // catégorie
    ], // catégorie
    [
        'group_label' => 'Voie', // group_label required, can be empty
        [
            'id'        => 'e_voie',
            'type'      => 'select',
            'options'   => $voies
        ] // voie
    ], //voie
    [
        'group_label' => 'Lieu', // group_label required, can be empty
        [
            'id'        => 'e_lieu',
            'type'      => 'select',
            'options'   => $lieux
        ] // lieu
    ], // lieu
    'user' => [
        'group_label' => 'Instructeur', // group_label required, can be empty
        'user' => [
            'id'        => 'author',
            'type'      => 'select',
            'options'   => $users_infos,
            'default'   => wp_get_current_user()->ID,
            'disabled'  => 'disabled'
        ] // author
    ], // author
    [
        'group_label' => 'Contact', // group_label required, can be empty
        [
            'label'     => 'Utiliser les coordonnées...',
            'id'        => 'e_coordonnees',
            'type'      => 'radio',
            'options'   => [
                            [
                                'id'    => 'e_c_instructeur',
                                'slug'  =>  'instructeur',
                                'title' => 'de l\'instructeur'
                            ],
                            [
                                'id'    => 'e_c_autre_instructeur',
                                'slug'  => 'autre-instructeur',
                                'title' => 'd\'un autre instructeur'
                            ],
                            [
                                'id'    => 'e_c_contact',
                                'slug'  => 'contact',
                                'title' => 'd\'un contact'
                            ]
                           ],
            'width'     => '49.7%'
        ], // coordonnees
        [
            'label'     => 'Instructeur',
            'id'        => 'e_autre_instructeur',
            'type'      => 'select',
            'options'   => $users_infos,
            'width'     => '49.7%',
            'display'   => 'none'
        ], // instructeurs
        [
            'label'     => 'Contact',
            'id'        => 'e_contact',
            'type'      => 'select',
            'options'   => $contacts,
            'width'     => '49.7%',
            'display'   => 'none'
        ] // contact
    ], // coordonnées
    [
        'group_label' => 'Prérequis', // group_label required, can be empty
        [
            'id'        => 'e_prerequis',
            'type'      => 'taxonomy',
            'taxonomy'  => 'prerequis'
        ] // catégorie
    ],
    'time' => [
        'group_label' => 'Date(s)',
        [
            'label' => 'Du...',
            'id'    => 'e_date_du',
            'type'  => 'date',
            'width' => '49.7%'
        ], // du...
        [
            'label' => '... Au',
            'id'    => 'e_date_au',
            'type'  => 'date',
            'width' => '49.7%'
        ], // au...
    ], // dates
    [
        'group_label' => 'Informations complémentaires', // group_label required, can be empty
        [
            'id'        => 'e_informations',
            'type'      => 'WYSIWYG'
        ] // instages
    ] // instages
]; // fields

if  (current_user_can('edit_pages')) :
    unset($fields['user']['user']['disabled']);
endif;

$mb_stage->set_fields($fields);
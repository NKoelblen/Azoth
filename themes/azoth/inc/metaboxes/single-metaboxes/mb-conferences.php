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

$lieu_posts = new WP_Query(
    [
        'post_type'         => 'lieu',
        'post_status'       => 'publish',
        'posts_per_page'    => -1,
        'orderby'           => array( 'title' => 'ASC' )
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

$user_args = [
    'role__in'  => array( 'administrator', 'editor', 'author'),
    'orderby'   => 'display_name',
    'order'     => 'ASC'
];
$users_query = new WP_User_Query($user_args);
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

$user_args['exclude'] = wp_get_current_user()->ID;
$users_query = new WP_User_Query($user_args);
$users = $users_query->get_results();
$other_users_infos = [];
if ($users) :
	foreach ($users as $user) :
        $other_users_infos[] = [
            'id'=> $user->ID,
            'title'=> $user->display_name,
        ];
    endforeach;
endif;

$contact_posts = new WP_Query(
    [
        'post_type'         => 'contact',
        'post_status'       => 'publish',
        'posts_per_page'    => -1,
        'orderby'           => array( 'title' => 'ASC' )
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
    [
        'group_label' => 'Lieu', // group_label required, can be empty
        [
            'id'        => 'lieu',
            'type'      => 'select',
            'options'   => $lieux,
            'add'       => 'Ajouter un nouveau lieu'
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
            'options'   => $other_users_infos,
            'width'     => '49.7%',
            'display'   => 'none'
        ], // instructeurs
        [
            'label'     => 'Contact',
            'id'        => 'contact',
            'type'      => 'select',
            'options'   => $contacts,
            'width'     => '49.7%',
            'display'   => 'none',
            'add'       => 'Ajouter un nouveau Contact'
        ] // contact
    ], // coordonnées
    [
        'group_label' => 'Date(s)',
        [
            'label' => 'Date',
            'id'    => 'e_date_du',
            'type'  => 'date',
            'width' => '49.7%'
        ], // du...
        [
            'label' => 'Heure',
            'id'    => 'e_heure',
            'type'  => 'time',
            'width' => '49.7%'
        ] // heure
    ], // dates
    [
        'group_label' => 'Informations complémentaires', // group_label required, can be empty
        [
            'id'        => 'e_informations',
            'type'      => 'WYSIWYG'
        ] // informations
    ] // informations
]; // fields

if  (current_user_can('edit_pages')) :
    unset($fields['user']['user']['disabled']);
endif;

$mb_conference->set_fields($fields);
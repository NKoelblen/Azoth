<?php

function evenement_fields($post_type) {

    $voie_posts = new WP_Query(
        [
            'post_type'         => 'voie',
            'post_status'       => 'publish',
            'posts_per_page'    => -1,
            'order'             => 'ASC'
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
        'role__in'  => array('gestionnaire', 'instructeur'),
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
        'categorie' => [
            'group_label' => 'Catégorie', // group_label required, can be empty
            [
                'id'        => 's_categorie',
                'type'      => 'taxonomy',
                'taxonomy'  => 'stage_categorie',
                'required'  => true
            ] // catégorie
        ], // catégorie
        'voie' => [
            'group_label' => 'Voie', // group_label required, can be empty
            [
                'id'        => 'e_voie',
                'type'      => 'select',
                'options'   => $voies,
                'required'  => true
            ] // voie
        ], //voie
        'time' => [
            'group_label' => 'Date(s)',
            'session' => [
                'label'     => 'Session n°',
                'id'        => 'e_session',
                'type'      => 'number',
                'width'     => '32.9%',
                'required'  => true
            ],
            'du' => [
                'label'     => 'Du...',
                'id'        => 'e_date_du',
                'type'      => 'date',
                'width'     => '49.7%',
                'default'   => date('Y-m-d', strtotime('now')),
                'required'  => true
            ], // du...
            'au' => [
                'label'     => '... Au',
                'id'        => 'e_date_au',
                'type'      => 'date',
                'width'     => '49.7%',
                'default'   => date('Y-m-d', strtotime('+1 day')),
                'required'  => true
            ], // au...
            'heure' => [
                'label'     => 'Heure',
                'id'        => 'e_heure',
                'type'      => 'time',
                'width'     => '49.7%',
                'required'  => true
            ] // heure
        ], // dates
        [
            'group_label' => 'Lieu', // group_label required, can be empty
            [
                'id'        => 'lieu',
                'type'      => 'select',
                'options'   => $lieux,
                'add'       => '+ Ajouter un Lieu',
                'required'  => true
            ] // lieu
        ], // lieu
        'user' => [
            'group_label' => 'Instructeur', // group_label required, can be empty
            'user' => [
                'id'        => 'author',
                'type'      => 'select',
                'options'   => $users_infos,
                'default'   => wp_get_current_user()->ID,
                'disabled'  => 'disabled',
                'required'  => true
            ] // author
        ], // author
        [
            'group_label' => 'Coordonnées...', // group_label required, can be empty
            [
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
                'width'     => '49.7%',
                'required'  => true
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
                'add'       => '+ Ajouter un Contact'
            ] // contact
        ], // coordonnées
        'prerequis' => [
            'group_label' => 'Prérequis', // group_label required, can be empty
            [
                'id'        => 'e_prerequis',
                'type'      => 'taxonomy',
                'taxonomy'  => 'prerequis'
            ], // zone
        ],
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

    if ($post_type === 'conference') :
        unset($fields['voie']);
        unset($fields['prerequis']);
        unset($fields['time']['au']);
        $fields['time']['du']['label'] = 'Date';
    endif;
    if ($post_type === 'conference' || $post_type === 'formation') :
        unset($fields['categorie']);
    endif;
    if ($post_type === 'conference' || $post_type === 'stage') :
        unset($fields['time']['session']);
    endif;
    if ($post_type === 'formation') :
        $fields['time']['du']['width'] = '32.9%';
        $fields['time']['au']['width'] = '32.9%';
    endif;
    if ($post_type === 'formation' || $post_type === 'stage') :
        unset($fields['time']['heure']);
    endif;

    return $fields;
}

global $post;
// global $wpdb;

add_action( 'save_post', 'evenement_title_and_time' );
function evenement_title_and_time( $post_id ) {
	
	if ( get_post_type( $post_id ) !== 'conference' && get_post_type( $post_id ) !== 'formation' && get_post_type( $post_id ) !== 'stage' ) :
		return ;
    else :
		$e_title = [] ;
        $categories = get_the_terms( $post_id, 'stage_categorie');
		if($categories) :
            foreach($categories as $e_categorie) :
                $e_categories[] = $e_categorie->name;
            endforeach;
			$e_title[] = implode( ", ", $e_categories );
		endif;
        $voie = get_post_meta( $post_id, 'e_voie', true );
		if($voie) :
			$e_title[] = get_the_title($voie);
        endif;
        $session = get_post_meta($post_id, 'e_session', true );
		if($session) :
			$e_title[] = 'Session n°' . $session;
        endif;
		$e_title[] = get_the_title( get_post_meta( $post_id, 'lieu', true ) );
		$e_date = strtotime( get_post_meta( $post_id, 'e_date_du', true ) ) ;
		$e_title[] = date_i18n( 'F Y', $e_date ) ;
		
		$post_title =  implode( " - ", $e_title ) ;
		$post_name =  sanitize_title( $post_title ) ;
        $post_date = date( "Y-m-d H:i:s", $e_date );

	endif ;

	remove_action( 'save_post', 'evenement_title_and_time' );
	wp_update_post(['ID' => $post_id, 'post_title' => $post_title, 'post_name' => $post_name, 'post_date' => $post_date]);
	add_action( 'save_post', 'evenement_title_and_time' );
}
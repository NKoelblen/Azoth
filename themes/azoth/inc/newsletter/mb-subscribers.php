<?php
/* Subscribers Metabox */

function subscriber_fields() {
$voie_posts = new WP_Query(
    [
        'post_type'         => 'voie',
        'post_status'       => 'publish',
        'posts_per_page'    => -1,
        'order'             => 'ASC'
    ]
);

$stages_categories = get_terms( [ 
    'taxonomy' => 'stage_categorie',
    'parent'   => 0,
    'hide_empty' => false,
    'hierarchical' => false
] );

$categories_options = [
  'c' => [
    'id' => 'conferences',
    'title' => 'Conférences'
  ],
  'f' => [
    'id' => 'formations',
    'title' => 'Nouveaux cycles de Formations',
  ],
  's' => [
    'id' => 'stages',
    'title' => 'Stages',
  ]
];
foreach($categories_options as $option) :
    switch ($option['title']) {
        case 'Nouveaux cycles de Formations' :
            $voies = [];
            if ($voie_posts->have_posts()) :
                while ($voie_posts->have_posts()) :
                    $voie_posts->the_post();
                    $voies[] =
                        [
                            'id'    => json_encode(['evenement' => $option['id'], 'voie' => get_the_ID()]),
                            'title' => get_the_title()
                        ];
                endwhile;
            endif;
            wp_reset_postdata();
            $option['children'] = $voies;
            $categories_options['f'] = $option;
            break;
        case 'Stages' :
            foreach($stages_categories as $stages_categorie) :
                $voies = [];
                if ($voie_posts->have_posts()) :
                    while ($voie_posts->have_posts()) :
                        $voie_posts->the_post();
                        $voies[] =
                            [
                                'id'    => json_encode(['evenement' => $option['id'], 'stage_categorie' => $stages_categorie->term_id, 'voie' => get_the_ID()]),
                                'title' => get_the_title()
                            ];
                    endwhile;
                endif;
                wp_reset_postdata();
                $option['children'][] =
                $stages_categorie->name === 'Le Mouvement Immobile' ?
                [
                    'id' => json_encode(['evenement' => $option['id'], 'stage_categorie' => $stages_categorie->term_id]),
                    'title' => $stages_categorie->name
                ] : 
                [
                    'id' => json_encode(['evenement' => $option['id'], 'stage_categorie' => $stages_categorie->term_id]),
                    'title' => $stages_categorie->name,
                    'children' => $voies
                ] ;
            endforeach;
            $categories_options['s'] = $option;
    }
endforeach;

$geo_zones = get_terms( [ 
    'taxonomy' => 'geo_zone',
    'parent'   => 0,
    'hide_empty' => false,
    'hierarchical' => true
] );

$geo_options = [];
foreach ($geo_zones as $geo_zone) :
    $geo_options[$geo_zone->term_id] = [
        'id' => json_encode(['geo_zone' => $geo_zone->term_id]),
        'title' => $geo_zone->name
    ];
    $children = get_terms( [ 
        'taxonomy' => 'geo_zone',
        'parent'   => $geo_zone->term_id,
        'hide_empty' => false,
        'hierarchical' => true
    ] );
    if($children) :
        foreach ( $children as $child ) :
            // $term = get_term_by( 'id', $child, 'geo_zone' );
            $geo_options[$geo_zone->term_id]['children'][] = [
                'id' => json_encode(['geo_zone' => $child->term_id, 'parent_zone' => $geo_zone->term_id]),
                'title' => $child->name
            ];
        endforeach;
    endif;
endforeach;

$subscriber_fields = [
    [
        'group_label' => 'Email', // group_label required, can be empty
        [
            'id'        => 'title',
            'type'      => 'email',
            'required'  => true
        ] // évènements
    ], //évènement
    [
        'group_label' => 'Blog', // group_label required, can be empty
        [
            'id'        => 'blog',
            'type'      => 'checkbox',
            'options'   => [
                [
                    'id'    => 'posts',
                    'title' => 'Articles du blog',
                    'default'   => 'posts',
                    'disabled'  => 'disabled',
                ],
            ],
        ] // évènements
    ], //évènement
    [
        'group_label' => 'Evènements', // group_label required, can be empty
        [
            'id'        => 'evenements',
            'type'      => 'checkbox',
            'options'   => $categories_options,
        ] // évènements
    ], //évènement
    [
        'group_label' => 'Localité', // group_label required, can be empty
        [
            'id'        => 'zone',
            'type'      => 'checkbox',
            'options'   => $geo_options,
        ], // zone
    ]
]; // fields
    return $subscriber_fields;

}

add_action('admin_init','test');
function test() {

if (class_exists('MetaboxGenerator')) {
    $mb_subscriber = new MetaboxGenerator; // Defined in ../mb-generator
};

/**
 *** How tu use : ***
 * method set_screens($post_types) ; method set_fields($groups_of_fields)
 * Refer to ./mb_generator comments
 */

$mb_subscriber->set_screens(['subscriber']);

$mb_subscriber->set_args(
    [
        'id' => 'informations',
        'title'  => 'Informations',
        'context' => 'advanced',
    ]
);



$mb_subscriber->set_fields(subscriber_fields());

};
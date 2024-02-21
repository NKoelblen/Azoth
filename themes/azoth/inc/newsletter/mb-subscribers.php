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

$evenement_options = [
    [
    'id' => 'conference',
    ],
    ['id' => 'formation'],
    ['id' => 'stage']
];
foreach($evenement_options as $key => $option) :
    $pt = get_post_type_object( $evenement_options[$key]['id'] );
    $evenement_options[$key]['title'] = $pt->labels->name;
    switch ($evenement_options[$key]['id']) {
        case 'formation' :
            $evenement_options[$key]['title'] = "Nouveaux cycles de " . $evenement_options[$key]['title'];
            $voies = [];
            if ($voie_posts->have_posts()) :
                while ($voie_posts->have_posts()) :
                    $voie_posts->the_post();
                    $voies[] =
                        [
                            'id'    => json_encode([
                                'post_type' => $evenement_options[$key]['id'],
                                'id'        => get_the_ID(),
                            ]),
                            'title' => get_the_title(),
                        ];
                endwhile;
            endif;
            wp_reset_postdata();
            $evenement_options[$key]['children'] = $voies;
            break;
        case 'stage' :
            foreach($stages_categories as $stages_categorie) :
                wp_reset_postdata();
                $evenement_options[$key]['children'][$stages_categorie->term_id] = [
                    'id' => json_encode([
                        'post_type' => $evenement_options[$key]['id'],
                        'id'        => $stages_categorie->term_id,
                    ]),
                    'title' => $stages_categorie->name,
                ];
                if ($voie_posts->have_posts() && $stages_categorie->name === 'Approfondissement') :
                    while ($voie_posts->have_posts()) :
                        $voie_posts->the_post();
                        $evenement_options[$key]['children'][$stages_categorie->term_id]['children'][] =
                            [
                                'id'    => json_encode([
                                    'post_type'         => $evenement_options[$key]['id'],
                                    'stage_categorie'   => json_decode($evenement_options[$key]['children'][$stages_categorie->term_id]['id'], true)['id'],
                                    'id'                => get_the_ID(),
                                ]),
                                'title' => get_the_title(),
                            ];
                    endwhile;
                endif;
                if($stages_categorie->name === 'Stage en extérieur') :
                    $evenement_options[$key]['children'][$stages_categorie->term_id]['default'] = $evenement_options[$key]['children'][$stages_categorie->term_id]['id'];
                    $evenement_options[$key]['children'][$stages_categorie->term_id]['disabled'] = 'disabled';
                endif;
            endforeach;
    }
endforeach;

$geo_zones = get_terms( [ 
    'taxonomy'      => 'geo_zone',
    'parent'        => 0,
    'hide_empty'    => false,
    'hierarchical'  => true
] );

$geo_options = [];
foreach ($geo_zones as $geo_zone) :
    $geo_options[$geo_zone->term_id] = [
        'id' => json_encode([
            'id'        => $geo_zone->term_id,
            'taxonomy'  => 'geo_zone'
        ]),
        'title' => $geo_zone->name,
    ];
    $children = get_terms( [ 
        'taxonomy'      => 'geo_zone',
        'parent'        => $geo_zone->term_id,
        'hide_empty'    => false,
        'hierarchical'  => true
    ] );
    if($children) :
        foreach ( $children as $child ) :
            $geo_options[$geo_zone->term_id]['children'][] = [
                'id' => json_encode([
                    'parent'    => json_decode($geo_options[$geo_zone->term_id]['id'], true),
                    'id'        => $child->term_id,
                ]),
                'title' => $child->name,
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
                    'id'        => 'posts',
                    'title'     => 'Articles du blog',
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
            'options'   => $evenement_options,
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
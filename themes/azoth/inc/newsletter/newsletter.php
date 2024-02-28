<?php
/**
 * Newsletter sent every Friday at midnight via O2Switch CRON tool :
 * https:// faq.o2switch.fr/hebergement-mutualise/tutoriels-cpanel/taches-cron
 */


/**
 * Get posts from the last 7 days
 */

// The post types to request
$post_types = ['conference', 'formation', 'stage', 'post'];
foreach ($post_types as $post_type):

    // The Query
    $posts_args = [
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'date_query' => [
            [
                'after' => '1 week ago',
            ],
        ],
    ];
    if ($post_type === 'formation'):
        $posts_args['meta_query'][] = [
            'key' => 'e_session',
            'value' => 1
        ];
    endif; // $post_type === 'formation'
    $posts = new WP_Query($posts_args);

    // The Loop
    if ($posts->have_posts()):
        while ($posts->have_posts()):
            $posts->the_post();

            $id = get_the_id();

            // Voie
            $voie = "";
            if (get_post_meta($id, 'e_voie', true)):
                $voie = intval(get_post_meta($id, 'e_voie', true));
            endif; // $voie

            // Catégorie de Stage
            $stage_categorie_terms = get_the_terms($id, 'stage_categorie');
            $stage_categorie = "";
            $stage_categorie_name = "";
            if ($stage_categorie_terms):
                $stage_categorie = $stage_categorie_terms[0]->term_id;
                $stage_categorie_name = $stage_categorie_terms[0]->name;
            endif;

            // Evènements
            $evenement = [];
            $evenement['post_type'] = $post_type;
            if ($stage_categorie):
                $evenement['stage_categorie'] = $stage_categorie;
            elseif ($voie && $stage_categorie_name !== 'Stage en extérieur'):
                $evenement['voie'] = $voie;
            endif;
            $evenements[] = $evenement;

            // Zones
            if ($post_type === 'conference' || ($post_type === 'formation' && get_the_title($voie) === 'La Voie de la Gestuelle')):

                $geo_zones = get_the_terms(get_post_meta($id, 'lieu', true), 'geo_zone');
                if ($geo_zones):
                    $geo_zone = $geo_zones[0]->term_id;
                    $parent_zone = get_term_by('id', $geo_zones[0]->parent, 'geo_zone');
                    if ($parent_zone):
                        $parent_zone = $parent_zone->term_id;
                    endif;
                endif;

                $zone = [];
                if ($parent_zone):
                    $zone['parent']['geo_zone'] = $parent_zone;
                endif;
                $zone['geo_zone'] = $geo_zone;
                $zones[] = $zone;

            endif; // conference || formation/La Voie de la Gestuelle

        endwhile; // $posts
    endif; // $posts
    // Restore original Post Data
    wp_reset_postdata();

endforeach; // $post_type

$evenements = isset($evenements) ? array_map("unserialize", array_unique(array_map("serialize", $evenements))) : "";
$zones = isset($zones) ? array_map("unserialize", array_unique(array_map("serialize", $zones))) : "";

/**
 * Group subscribers whose settings match posts from the last 7 days 
 */

// The Query
$subscribers_args = [
    'post_type' => 'subscriber',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'meta_query' => [
        'relation' => 'OR',
        [
            'key' => 'blog',
            'value' => 'posts',
            'compare' => 'LIKE'
        ]
    ],
];
if ($evenements):
    foreach ($evenements as $evenement):

        $subscribers_args['meta_query'][] = [
            'key' => 'evenements',
            'value' => json_encode($evenement),
            'compare' => 'LIKE'
        ];

    endforeach;
endif;
if ($zones):
    foreach ($zones as $zone):

        $subscribers_args['meta_query'][] = [
            'key' => 'zones',
            'value' => json_encode($zone),
            'compare' => 'LIKE'
        ];

    endforeach;
endif;
$subsribers = new WP_Query($subscribers_args);

// The Loop
if ($subsribers->have_posts()):
    while ($subsribers->have_posts()):
        $subsribers->the_post();

        $id = get_the_id();

        $email = get_the_title();

        $settings = [];

        if ($evenements):
            foreach ($evenements as $evenement):
                $evenement = json_encode($evenement);
                if (in_array($evenement, get_post_meta($id, 'evenements', true))):
                    $settings['evenements'][] = $evenement;
                endif;
            endforeach;
        endif;
        if ($zones):
            foreach ($zones as $zone):
                $zone = json_encode($zone);
                if (in_array($zone, get_post_meta($id, 'zones', true))):
                    $settings['zones'][] = $zone;
                endif;
            endforeach;
        endif;

        $subscribers_lists[json_encode($settings)][] = $email;

    endwhile; // $subscribers
endif; // $subscribers
// Restore original Post Data
wp_reset_postdata();

/**
 * Set emails by subscriber groups
 * where posts from the last 7 days match subscribers settings
 */

foreach ($subscribers_lists as $settings => $emails):

    // The Recipient
    $to = implode(', ', $emails);

    // The Subject
    $title = "Il y a du mouvement chez Azoth !";

    // The Message
    ob_start();

    get_template_part('/inc/newsletter/newsletter-header');

    $settings = json_decode($settings, true);

    $evenements = [];

    if ($settings['evenements']): ?>
        <h2>Evènements :</h2>
        <p>Pour plus d'informations, cliquez sur l'icone <span class="dashicons dashicons-info-outline"
                style="font-size: 1em;"></span>.</p>

        <?php foreach ($settings['evenements'] as $evenement):

            $evenement = json_decode($evenement, true);

            $stage_categorie = isset($evenement['stage_categorie']) ? $evenement['stage_categorie'] : 0;
            $voie = isset($evenement['voie']) ? $evenement['voie'] : 0;
            $evenements[$evenement['post_type']][$stage_categorie][$voie] = $voie;

        endforeach; // $evenement

        $post_type_titles = [];
        foreach ($evenements as $post_type => $stage_categories):

            $post_type_object = get_post_type_object($post_type);

            $stage_categorie_titles = [];
            foreach ($stage_categories as $stage_categorie => $voies):

                if ($stage_categorie):
                    $term = get_term_by('term_id', $stage_categorie, 'stage_categorie');
                endif;

                $voie_titles = [];
                foreach ($voies as $voie):

                    if ($voie):
                        $voie_title = $voie ? get_the_title($voie) : "";
                    endif;

                    $evenements_args = [
                        'post_type' => $post_type,
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'date_query' => [
                            [
                                'after' => '1 week ago',
                            ],
                        ],
                        'meta_query' => [
                            'relation' => 'AND',
                        ]
                    ];
                    if ($post_type === 'formation'):
                        $evenements_args['meta_query'][] = [
                            'key' => 'e_session',
                            'value' => 1
                        ];
                    endif; // $post_type === 'formation'
                    if ($stage_categorie):
                        $evenements_args['tax_query'][] = [
                            'taxonomy' => 'stage_categorie',
                            'field' => 'term_id',
                            'terms' => $stage_categorie,
                        ];
                    endif; // $stage_categorie['stage_categorie']
                    if ($voie):
                        $evenements_args['meta_query'][] = [
                            'key' => 'e_voie',
                            'value' => $voie
                        ];
                    endif; // $voie[$voie]

                    if ($post_type === 'conference' || ($post_type === 'formation' && $voie_title === 'La Voie de la Gestuelle')):

                        $zones = [];

                        foreach ($settings['zones'] as $zone):
                            $zones[] = json_decode($zone, true)['geo_zone'];
                        endforeach; // $zone

                        $lieu_posts = get_posts(
                            [
                                'posts_per_page' => -1,
                                'post_type' => 'lieu',
                                'post_status' => 'publish',
                                'tax_query' => [
                                    [
                                        'taxonomy' => 'geo_zone',
                                        'field' => 'term_id',
                                        'terms' => $zones,
                                    ]
                                ]
                            ]
                        );
                        $lieux = [];
                        foreach ($lieu_posts as $lieu):
                            $lieux[] = $lieu->ID;
                        endforeach;

                        $evenements_args['meta_query'][] = [
                            'key' => 'lieu',
                            'value' => $lieux,
                            'compare' => 'IN'
                        ];

                    endif; // $post_type === 'conference' || ($post_type === 'formation' && $voie_title === 'La Voie de la Gestuelle')
                    $evenement_posts = new WP_Query($evenements_args);
                    if ($evenement_posts->have_posts()):
                        while ($evenement_posts->have_posts()):
                            $evenement_posts->the_post();

                            $id = get_the_ID();

                            if (!in_array($post_type_object->labels->name, $post_type_titles)):
                                $post_type_titles[] = $post_type_object->labels->name; ?>
                                <h3>
                                    <?= $post_type === 'formation' ? 'Nouveaux cycles de ' : ""; ?>
                                    <?= $post_type_object->labels->name; ?>
                                </h3>
                            <?php endif;

                            if ($stage_categorie && !in_array($term->name, $stage_categorie_titles)):
                                $stage_categorie_titles[] = $term->name; ?>
                                <h4>
                                    <?= $term->name; ?>
                                </h4>
                            <?php endif;

                            if ($voie && !in_array($voie_title, $voie_titles)):
                                if ($stage_categorie): ?>
                                    <h5>
                                        <?= $voie_title; ?>
                                    </h5>
                                <?php else: ?>
                                    <h4>
                                        <?= $voie_title; ?>
                                    </h4>
                                <?php endif;
                            endif; ?>

                            <p>
                                <span class="dashicons dashicons-info-outline" style="font-size: 1em;"></span>
                                <?= $stage_categorie && $term->name === 'Stage en extérieur' ? get_the_title(get_post_meta($id, 'e_voie', true)) . ' : ' : ""; ?>
                                <?= get_the_title(get_post_meta($id, 'lieu', true)) . ', '; ?>
                                <?php switch ($post_type) {
                                    case 'conference':
                                        echo 'le ';
                                        break;
                                    case 'formation':
                                        echo 'à partir du ';
                                        break;
                                    case 'stage':
                                        echo 'du ';
                                }
                                ; ?>
                                <?= get_post_meta($id, 'e_date_du', true); ?>
                                <?php switch ($post_type) {
                                    case 'conference':
                                        echo ' à ' . get_post_meta($id, 'e_heure', true);
                                        break;
                                    case 'stage':
                                        echo ' au ' . get_post_meta($id, 'e_date_au', true);
                                }
                                ; ?>
                            </p>

                        <?php endwhile; // $evenement_posts
                    endif; // $evenement_posts
                    wp_reset_postdata();
                endforeach; // $voie

            endforeach; // $stage_categories

        endforeach; // $evenements         ?>

        <p>... Et plus encore sur Azoth.fr !</p>
        <a href="#">Découvrir tous les derniers évènements programmés</a>

    <?php endif; // $settings['evenements']

    $blog_posts = new WP_Query([
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'date_query' => [
            [
                'after' => '1 week ago',
            ],
        ],
    ]);

    if ($blog_posts->have_posts()): ?>
        <h2>Actualités :</h2>
        <?php while ($blog_posts->have_posts()):
            $blog_posts->the_post();

            $id = get_the_ID();

            echo the_post_thumbnail('small');
            echo the_title('<h3>', '</h3>');
            echo get_the_term_list($id, 'category', '<p>', ' | ', '</p>');

        endwhile; // $blog_posts
    endif; // $blog_posts
    wp_reset_postdata(); ?>
    <?php get_template_part('/inc/newsletter/newsletter-footer');

endforeach; // $subscribers_lists

$message = ob_get_clean();

wp_mail($to, $title, $message);
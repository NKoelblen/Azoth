<?php

add_shortcode('newsletter-mail', 'newsletter_mail_shortcode');
function newsletter_mail_shortcode()
{
    ob_start();

    $post_types = ['conference', 'formation', 'stage', 'post'];

    foreach ($post_types as $post_type):

        $evenements_args = [
            'post_type' => $post_type,
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'date_query' => [
                [
                    'after' => strtotime("-1 week"),
                ],
            ],
        ];

        if ($post_type === 'formation'):
            $evenements_args['meta_query'][] = [
                'key' => 'e_session',
                'value' => 1
            ];
        endif; // $post_type === 'formation'

        $evenements = new WP_Query($evenements_args);
        if ($evenements->have_posts()):
            while ($evenements->have_posts()):
                $evenements->the_post();

                $id = get_the_id();

                $zones = get_the_terms(get_post_meta($id, 'lieu', true), 'geo_zone');
                if ($zones):
                    $zone = $zones[0]->term_id;
                    $parent_zone = get_term_by('id', $zones[0]->parent, 'geo_zone');
                    if ($parent_zone):
                        $parent_zone = $parent_zone->term_id;
                    endif; //$parent_zone
                endif; //$zones

                $voie = "";

                if (get_post_meta($id, 'e_voie', true)):
                    $voie = intval(get_post_meta($id, 'e_voie', true));
                endif; //$voie

                $stage_categorie_terms = get_the_terms($id, 'stage_categorie');
                $stage_categorie = "";
                $stage_categorie_name = "";

                if ($stage_categorie_terms):
                    $stage_categorie = $stage_categorie_terms[0]->term_id;
                    $stage_categorie_name = $stage_categorie_terms[0]->name;
                endif; //$stage_categorie_terms

                $e_categorie = [];
                $e_categorie['post_type'] = $post_type;

                if ($stage_categorie):
                    $e_categorie['stage_categorie'] = $stage_categorie;
                elseif ($voie && $stage_categorie_name !== 'Stage en extérieur'):
                    $e_categorie['voie'] = $voie;
                endif; //$stage_categorie

                $e_categories[] = $e_categorie;

                $e_zone = [];

                if ($parent_zone):
                    $e_zone['parent']['geo_zone'] = $parent_zone;
                endif; //$parent_zone

                $e_zone['geo_zone'] = $zone;
                $e_zones[] = $e_zone;

            endwhile; //$evenements
        endif; //$evenements
        wp_reset_postdata();

    endforeach; //$post_type

    $unique_categories = isset($e_categories) ? array_map("unserialize", array_unique(array_map("serialize", $e_categories))) : "";
    $unique_zones = isset($e_zones) ? array_map("unserialize", array_unique(array_map("serialize", $e_zones))) : "";

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

    if ($unique_categories):
        foreach ($unique_categories as $evenement):

            $subscribers_args['meta_query'][] = [
                'key' => 'evenements',
                'value' => json_encode($evenement),
                'compare' => 'LIKE'
            ];

        endforeach; // $evenement
    endif; // $unique_categories

    if ($unique_zones):
        foreach ($unique_zones as $zone):

            $subscribers_args['meta_query'][] = [
                'key' => 'zones',
                'value' => json_encode($zone),
                'compare' => 'LIKE'
            ];

        endforeach; // $zone
    endif; // $unique_zones

    $subsribers = new WP_Query($subscribers_args);
    if ($subsribers->have_posts()):
        while ($subsribers->have_posts()):
            $subsribers->the_post();

            $id = get_the_id();
            $email = get_the_title();
            $settings = [];
            $settings[] = get_post_meta($id, 'evenements', true);
            $settings[] = get_post_meta($id, 'zones', true) ? get_post_meta($id, 'zones', true) : "";
            $subscribers_lists[json_encode($settings)][] = $email;

        endwhile; // $subscribers
    endif; // $subscribers
    wp_reset_postdata();

    foreach ($subscribers_lists as $key => $values):

        $to = implode(', ', $values);
        $title = "Il y a du mouvement chez Azoth !" ?>

        <!DOCTYPE html PUBLIC "...">
        <html xmlns="https://www.yourwebsite.com/1999/xhtml">

        <head>
            <title>
                <?= $title ?>
            </title>
            <style></style>
        </head>
        <header>
            <a href="<?= get_site_url(); ?>">
                <img src="<?= get_site_url(null, '/wp-content/themes/azoth/assets/images/logo-full.webp'); ?>" height="256px">
            </a>
            <h1>
                <?= $title; ?>
            </h1>
        </header>

        <body>

            <?php $settings = json_decode($key, true);

            $post_types = [];
            $stage_categories = [];
            $voies = [];

            if ($settings[0]): ?>
                <h2>Evènements :</h2>
                <p>Pour plus d'informations, cliquez sur l'icone <span class="dashicons dashicons-info-outline"
                        style="font-size: 1em;"></span>.</p>

                <?php foreach ($settings[0] as $evenement):

                    $evenement = json_decode($evenement, true);

                    $post_types[] = $evenement['post_type'];
                    $stage_categories[] = [
                        'post_type' => $evenement['post_type'],
                        'stage_categorie' => isset($evenement['stage_categorie']) ? $evenement['stage_categorie'] : ""
                    ];
                    $voies[] = [
                        'post_type' => $evenement['post_type'],
                        'stage_categorie' => isset($evenement['stage_categorie']) ? $evenement['stage_categorie'] : "",
                        'voie' => isset($evenement['voie']) ? $evenement['voie'] : ""
                    ];

                endforeach; // $evenement
    
                $post_types = array_unique($post_types);
                $stage_categories = array_map("unserialize", array_unique(array_map("serialize", $stage_categories)));

                $post_type_titles = [];
                foreach ($post_types as $post_type):

                    $post_type_object = get_post_type_object($post_type);

                    $stage_categorie_titles = [];
                    foreach ($stage_categories as $stage_categorie):
                        if ($stage_categorie['post_type'] === $post_type):

                            $term = get_term_by('term_id', $stage_categorie['stage_categorie'], 'stage_categorie');

                            $voie_titles = [];
                            foreach ($voies as $voie):
                                if ($voie['post_type'] === $post_type && $voie['stage_categorie'] === $stage_categorie['stage_categorie']):

                                    $voie_title = $voie['voie'] ? get_the_title($voie['voie']) : "";

                                    $evenements_args = [
                                        'post_type' => $post_type,
                                        'post_status' => 'publish',
                                        'posts_per_page' => -1,
                                        'date_query' => [
                                            [
                                                'after' => strtotime("-1 week"),
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
    
                                    if ($stage_categorie['stage_categorie']):
                                        $evenements_args['tax_query'][] = [
                                            'taxonomy' => 'stage_categorie',
                                            'field' => 'term_id',
                                            'terms' => $stage_categorie['stage_categorie'],
                                        ];
                                    endif; // $stage_categorie['stage_categorie']
    
                                    if ($voie['voie']):
                                        $evenements_args['meta_query'][] = [
                                            'key' => 'e_voie',
                                            'value' => $voie['voie']
                                        ];
                                    endif; // $voie[$voie]
    
                                    if ($post_type === 'conference' || ($post_type === 'formation' && $voie_title === 'La Voie de la Gestuelle')):

                                        $zones = [];

                                        foreach ($settings[1] as $zone):
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
                                    if ($evenement_posts->have_posts()): ?>

                                        <?php

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

                                            if ($term && !in_array($term->name, $stage_categorie_titles)):
                                                $stage_categorie_titles[] = $term->name; ?>
                                                <h4>
                                                    <?= $term->name; ?>
                                                </h4>
                                            <?php endif;

                                            if ($voie_title && !in_array($voie_title, $voie_titles)):
                                                if ($term): ?>
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

                                                <?= $term && $term->name === 'Stage en extérieur' ? get_the_title(get_post_meta($id, 'e_voie', true)) . ' : ' : ""; ?>

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

                                endif; // $voie['post_type'] === $post_type && $voie['stage_categorie'] === $stage_categorie['stage_categorie']
                            endforeach; // $voie
    
                        endif; // $stage_categorie['post_type'] === $post_type
                    endforeach; // $stage_categorie
    
                endforeach; // $post_type
                ?>

                <p>... Et plus encore sur Azoth.fr !</p>
                <a href="#">Découvrir tous les derniers évènements programmés</a>

            <?php endif; // $settings[0]
    
            $blog_posts = new WP_Query([
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'date_query' => [
                    [
                        'after' => strtotime("-1 week"),
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
        </body>

        <footer>
            <p><a href="<?= get_site_url(); ?>">azoth.fr</a> | <a href="mailto:email@contact@azoth.fr">contact@azoth.fr</a></p>
            <div>
                <a href="#"><img src="<?= get_site_url(null, '/wp-content/themes/azoth/assets/images/square-facebook.svg'); ?>"
                        height="24px"></a>
                <a href="#"><img src="<?= get_site_url(null, '/wp-content/themes/azoth/assets/images/square-youtube.svg'); ?>"
                        height="24px"></a>
                <p><a href="#">Modifier mon inscription</a> | <a href="#">Me désinscrire</a></p>
        </footer>

        </html>
    <?php endforeach; // $subscribers_lists

    $message = ob_get_clean();

    // return wp_mail($to, $title, $message);

    return $message;
}
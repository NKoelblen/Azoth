<?php
add_action('admin_init','test_admin');
function test_admin() {
    if (is_admin()) :
    header('Content-Type:text/plain');

    $evenements = new WP_Query ([
        'post_type'         => ['conference', 'formation', 'stage'],
        'post_status'       => 'publish',
        'posts_per_page'    => -1,
        'date_query' => [
            [
                'after' => strtotime("-1 week"),
            ],
        ],
    ]);
    if($evenements->have_posts()) :
        while ($evenements->have_posts()) :
            $evenements->the_post();
            $id = get_the_id();
            $post_type = get_post_type();
            // $e_lieu = get_post_meta($id, 'lieu', true);
            $zones = get_the_terms(get_post_meta($id, 'lieu', true), 'geo_zone');
            $zone = $zones[0]->term_id;
            $parent_zone = get_term_by('id', $zones[0]->parent, 'geo_zone');
            if($parent_zone) :
                $parent_zone = $parent_zone->term_id;
            endif;
            $voie = "";
            if(get_post_meta($id, 'e_voie', true)) :
                $voie = intval(get_post_meta($id, 'e_voie', true));
            endif;
            $stage_categorie_terms = get_the_terms($id, 'stage_categorie');
            $stage_categorie = "";
            if($stage_categorie_terms) :
                $stage_categorie = $stage_categorie_terms[0]->term_id;
            endif;
            $e_categorie = [];
            if($voie) :
                if($stage_categorie) :
                    $e_categorie['parent']['parent']['id']      = $post_type;
                    $e_categorie['parent']['parent']['type']    = 'post_type';

                    $e_categorie['parent']['id']        = $stage_categorie;
                    $e_categorie['parent']['type']      = 'term';
                    $e_categorie['parent']['taxonomy']  = 'stage_categorie';
                else :
                    $e_categorie['parent']['id'] = $post_type;
                    $e_categorie['parent']['type'] = 'post_type';
                endif;
                $e_categorie['id']          = $voie;
                $e_categorie['type']        = 'post';
                $e_categorie['post_type']   = 'voie';
            elseif($stage_categorie) :
                $e_categorie['parent']['id']    = $post_type;
                $e_categorie['parent']['type']  = 'post_type';

                $e_categorie['id']          = $stage_categorie;
                $e_categorie['type']        = 'term';
                $e_categorie['taxonomy']    = 'stage_categorie';
            else :
                $e_categorie['id']      = $post_type;
                $e_categorie['type']    = 'post_type';
            endif;

            $e_categories[] = $e_categorie;

            if($parent_zone) :
                $e_zone['parent']['id']         = $parent_zone;
                $e_zone['parent']['type']       = 'term';
                $e_zone['parent']['taxonomy']   = 'geo_zone';
            endif;
            $e_zone['id']       = $zone;
            $e_zone['type']     = 'term';
            $e_zone['taxonomy'] = 'geo_zone';

            $e_zones[] = $e_zone; 

        endwhile;
    endif;
    
    $unique_categories = array_map("unserialize", array_unique(array_map("serialize", $e_categories)));
    $unique_zones = array_map("unserialize", array_unique(array_map("serialize", $e_zones)));
    wp_reset_postdata();

    $subscribers_args = [
        'post_type'         => 'subscriber',
        'post_status'       => 'publish',
        'posts_per_page'    => -1,
        'meta_query' => [
            'relation' => 'OR',
        ],
    ];
    foreach ($unique_categories as $categorie) :
        $categorie = json_encode($categorie);
        $subscribers_args['meta_query'][] = [
            'key'   => $categorie,
            'value' => $categorie
        ];
    endforeach;
    foreach ($unique_zones as $zone) :
        $zone = json_encode($zone);
        $subscribers_args['meta_query'][] = [
            'key'   => $zone,
            'value' => $zone
        ];
    endforeach;
    $subsribers = new WP_Query ($subscribers_args);
    $subscribers_lists = [];
    if ($subsribers->have_posts()) :
        while ($subsribers->have_posts()) :
            $subsribers->the_post();

            $id = get_the_id();

            $settings = [];
            foreach ($unique_categories as $categorie) :
                $categorie = json_encode($categorie);
                $post_meta = get_post_meta($id, $categorie, true);
                if($post_meta) :
                    $settings[] = $post_meta;
                endif;
            endforeach;
            foreach ($unique_zones as $zone) :
                $zone = json_encode($zone);
                $post_meta = get_post_meta($id, $zone, true);
                if($post_meta) :
                    $settings[] = $post_meta;
                endif;
            endforeach;
            $subscribers_lists[json_encode($settings)]['post_metas'] = $settings;
            $subscribers_lists[json_encode($settings)]['subscribers'][] = $id;
        endwhile;
    endif;
    wp_reset_postdata();
    print_r($subscribers_lists);
    exit;
  endif;
}
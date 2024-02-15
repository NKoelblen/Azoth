<?php
add_shortcode('subscription-form', 'subscription_form_shortcode');
function subscription_form_shortcode() {
    ob_start(); ?>
    <div class="modal-outer">
        <form
            action="<?php echo admin_url( 'admin-ajax.php' ); ?>" 
            method="post"
            id="subscription-form" 
            class="modal-inner"
        >
            <button type="button" class="modal-close">
                <span class="modal-icon">
                    <span class="screen-reader-text">Fermez la boite de dialogue</span>
                </span>
            </button>
            <p>Déjà inscrit ?</a>
            <a href="#">Modifier mon inscription</a>
            <?php $inner_post_type = 'subscriber';
            $call = $inner_post_type . '_fields';
            $fields = $call();
            $new_subscriber = new stdClass();
            $new_subscriber->ID = -99;
            $new_subscriber->post_type = 'subscriber';
            $new_subscriber->filter = 'raw'; ?>
            <?php fields_generator($new_subscriber, $fields); ?>
            <input 
                type="hidden" 
                name="nonce" 
                value="<?php echo wp_create_nonce( 'subscription_post' ); ?>"
            > 
            <input
                type="hidden"
                name="action"   
                value="subscription_post"
            >
            <button id = "subscription-btn">S'abonner</button>
        </form>
    </div>
    <?php return ob_get_clean();
}

add_action('wp_ajax_subscription_post', 'subscription_post');
add_action('wp_ajax_nopriv_subscription_post', 'subscription_post');
function subscription_post() {
    	// Vérification de sécurité
  	if(!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'subscription_post')) :
        ob_start(); ?>
        <p class="subscriber error">Vous n'avez pas le droit d'effectuer cette action.</p>
    	<?php wp_send_json_error(ob_get_clean(), 403);
        return;
    endif;

    $title = sanitize_text_field($_POST['title']);
    if( ! is_email( $title ) ) : ?>
        <p class="subscriber error">Vous n'avez pas le droit d'effectuer cette action.</p>
    	<?php wp_send_json_error(ob_get_clean(), 403);
        return;
    endif;

    $subscriber_posts = new WP_Query(
        [
            'post_type'         => 'subscriber',
            'post_status'       => 'publish',
            'posts_per_page'    => -1
        ]
    );
    if ($subscriber_posts->have_posts()) :
        while ($subscriber_posts->have_posts()) :
            $subscriber_posts->the_post();
            if ($_POST['title'] === get_the_title()) :
                ob_start(); ?>
                <p class="subscriber yet"><?= $_POST['title'] ?> reçoit déjà nos actualités suivantes :</p>
                <ul>
                    <li>Articles du Blog</li>
                </ul>
                <?php $fields = get_post_meta(get_the_ID());
                $evenements = [];
                $stage_categories = [];
                $voies = [];
                $parent_zones = [];
                $geo_zones = [];
                foreach ($fields as $field) :
                    $meta_values = json_decode($field[0], true);
                    if($meta_values['evenement']) :
                        $evenements[] = $meta_values['evenement'];
                    endif;
                    if($meta_values['stage_categorie']) :
                        $stage_categories[] = ['evenement' => $meta_values['evenement'], 'stage_categorie' => $meta_values['stage_categorie']];
                    endif;
                    if($meta_values['voie']) :
                        $voies[] = ['evenement' => $meta_values['evenement'], 'stage_categorie' => $meta_values['stage_categorie'], 'voie' => $meta_values['voie']];
                    endif;
                    if($meta_values['parent_zone']) :
                        $parent_zones[] = $meta_values['parent_zone'];
                    endif;
                    if ($meta_values['geo_zone']) :
                        $geo_zones[] = ['parent_zone' => $meta_values['parent_zone'], 'geo_zone' => $meta_values['geo_zone']];
                    endif;
                endforeach;
                $evenements = array_unique($evenements);
                $stage_categories = array_map("unserialize", array_unique(array_map("serialize", $stage_categories)));
                $parent_zones = array_unique($parent_zones); ?>
                <ul>
                    <?php foreach($evenements as $evenement) : ?>
                        <li>
                            <?php switch ($evenement) {
                                case 'conferences' : 
                                    echo 'Conférences';
                                    break;
                                case 'formations' : 
                                    echo 'Nouveaux cycles de Formations';
                                    break;
                                case 'stages' : 
                                    echo 'Stages';
                            } ?>
                            <ul>
                                <?php foreach($stage_categories as $stage_categorie) : ?>
                                    <?php if($stage_categorie['evenement'] === $evenement) :
                                        $sc_term = get_term_by('id', $stage_categorie['stage_categorie'], 'stage_categorie'); ?>
                                        <li>
                                            <?= $sc_term->name; ?>
                                            <ul>
                                                <?php foreach($voies as $voie) :
                                                    if($voie['evenement'] === $evenement && $voie['stage_categorie'] === $stage_categorie['stage_categorie']) : ?>
                                                        <li><?= get_the_title($voie['voie']); ?></li>
                                                    <?php endif;
                                                endforeach; ?>
                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php foreach($voies as $voie) :
                                    if($voie['evenement'] === $evenement && !$voie['stage_categorie']) : ?>
                                        <li><?= get_the_title($voie['voie']); ?></li>
                                    <?php endif;
                                endforeach; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <ul>
                    <?php foreach($parent_zones as $parent_zone) :
                        $pz_term = get_term_by('id', $parent_zone, 'geo_zone'); ?>
                        <li>
                            <?= $pz_term->name; ?>
                            <ul>
                                <?php foreach($geo_zones as $geo_zone) : ?>
                                    <?php if($geo_zone['parent_zone'] === $parent_zone) :
                                        $gz_term = get_term_by('id', $geo_zone['geo_zone'], 'geo_zone');; ?>
                                        <li><?= $gz_term->name; ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                    <?php foreach($geo_zones as $geo_zone) : ?>
                        <?php if(!$geo_zone['parent_zone']) :
                            $gz_term = get_term_by('id', $geo_zone['geo_zone'], 'geo_zone');; ?>
                            <li><?= $gz_term->name; ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
                <a href="#">Modifier mon inscription</a>
                <?php wp_send_json_error(ob_get_clean());
                return;
            endif;
        endwhile;
    endif;
    wp_reset_postdata();

    $subscriber = [
        'post_title'    => $title,
        'post_content'  => $_POST['content'] ? $_POST['content'] : "",
        'post_status'   => 'publish',
        'post_type' 	=> 'subscriber'
    ];

    foreach($_POST as $key => $field) :
        if ($field !== $_POST['action'] &&
            $field !== $_POST['nonce'] && 
            $field !== $_POST['title'] &&
            $field !== $_POST['content']
            ) :

            $subscriber['meta_input'][$key] = $field;

        endif;
    endforeach;

    wp_insert_post($subscriber);

    ob_start() ?>
    <p class="subscriber sucess">Merci ! Votre inscription à bien été prise en compte !</p>
    <p>Vous recevrez un mail de confirmation dans les prochaines minutes à l'adresse suivante : <?= $title ?></p>
    <?php wp_send_json_success(ob_get_clean());
}
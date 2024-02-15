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
    	wp_send_json_error('Vous n’avez pas l’autorisation d’effectuer cette action.', 403);
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
            if ($_POST['title'] === get_the_title()) : ?>
                <p class="subscriber yet"><?= $_POST['title'] ?> reçoit déjà nos actualité concernant :</p>
                <pre><?php print_r(get_post_meta(get_the_ID())); ?></pre>
                <?php wp_send_json_error(ob_get_clean());
                return;
            endif;
        endwhile;
    endif;
    wp_reset_postdata();

    $subscriber = [
        'post_title'    => $_POST['title'],
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
    <p>Vous recevrez un mail de confirmation dans les prochaines minutes à l'adresse suivante : <?= $_POST['title'] ?></p>
    <?php wp_send_json_success(ob_get_clean());
}
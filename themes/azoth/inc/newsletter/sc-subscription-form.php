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
            <p> Renseignez votre adresse email pour modifier votre inscription.<p>
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
                id="update-nonce" 
                name="update-nonce" 
                value="<?php echo wp_create_nonce( 'subscription_update' ); ?>"
            > 
            <input
                type="hidden"
                id="update-action"   
                name="update-action"   
                value="subscription_update"
            >
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
            <button id="subscription-btn">S'abonner</button>
        </form>
    </div>
    <?php return ob_get_clean();
}
add_action('wp_ajax_subscription_update', 'subscription_update');
add_action('wp_ajax_nopriv_subscription_update', 'subscription_update');
function subscription_update() {
  	if(!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'subscription_update')) :
    	wp_send_json_error("Vous n'avez pas le droit d'effectuer cette action.", 403);
        return;
    endif;

    $email = $_POST['value'] ? $_POST['value'] : "";
    $subsribers = get_posts(
        [
            'post_type'     => 'subscriber',
            'title'         => $email,
            'post_status'   => 'publish',
            'numberposts'   => 1,
        ]
    );
    if($subsribers) :
        $ID = $subsribers[0]->ID;
        ob_start(); ?>
        <a href="#" class="delete-btn"
            data-ajaxurl='<?= admin_url('admin-ajax.php'); ?>'
        	data-nonce='<?= wp_create_nonce('subscription_delete'); ?>'
        	data-action='subscription_delete'
            data-id='<?= $ID ?>'
        >
            Me désincrire
        </a>
        <?php wp_send_json_success(['ID' => $ID, 'meta-values' => get_post_meta($ID), 'delete-btn' => ob_get_clean()]);
    endif;
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

    if(isset($_POST['subscriber-id'])) :
        $meta_values = get_post_meta($_POST['subscriber-id']);
        foreach($meta_values as $meta_value) :
            if(!in_array($meta_value[0], $subscriber['meta_input'])) :
                delete_post_meta($_POST['subscriber-id'], $meta_value[0], $meta_value[0]);
            endif;
        endforeach;
        foreach($subscriber['meta_input'] as $meta_value) :
            update_post_meta($_POST['subscriber-id'], $meta_value, $meta_value);
        endforeach;
        ob_start() ?>
        <p class="subscriber sucess">Merci ! Vos changements ont bien été pris en compte !</p>
        <?php wp_send_json_success(ob_get_clean());
    else :
        wp_insert_post($subscriber);
        ob_start() ?>
        <p class="subscriber sucess">Merci ! Votre inscription à bien été prise en compte !</p>
        <p>Vous recevrez un mail de confirmation dans les prochaines minutes à l'adresse suivante : <?= $title ?></p>
        <?php wp_send_json_success(ob_get_clean());
    endif;

}

add_action('wp_ajax_subscription_delete', 'subscription_delete');
add_action('wp_ajax_nopriv_subscription_delete', 'subscription_delete');
function subscription_delete() {
    if(!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'subscription_delete')) :
        ob_start(); ?>
        <p class="subscriber error">Vous n'avez pas le droit d'effectuer cette action.</p>
    	<?php wp_send_json_error(ob_get_clean(), 403);
        return;
    endif;

    $subscriber = [
        'ID'            => $_POST['id'],
        'post_status'   => 'trash',
    ];
    wp_update_post($subscriber);
    ob_start() ?>
    <p class="subscriber sucess">Votre désinscription a bien été prise en compte.</p>
    <?php wp_send_json_success(ob_get_clean());
}
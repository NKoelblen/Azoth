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
                id="subscriber-id" 
                name="subscriber-id" 
                value=""
            > 
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
                id="nonce" 
                name="nonce" 
                value="<?php echo wp_create_nonce( 'subscription_post' ); ?>"
            > 
            <input
                type="hidden"
                id="action"
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
        $evenements = get_post_meta($ID, 'evenements');
        $zones = get_post_meta($ID, 'zones');
        ob_start(); ?>
        <a href="#" class="delete-btn"
            data-ajaxurl='<?= admin_url('admin-ajax.php'); ?>'
        	data-nonce='<?= wp_create_nonce('subscription_delete'); ?>'
        	data-action='subscription_delete'
            data-id='<?= $ID ?>'
        >
            Me désincrire
        </a>
        <?php wp_send_json_success(['ID' => $ID, 'evenements' => $evenements, 'zones' => $zones, 'delete-btn' => ob_get_clean()]);
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

    $email = sanitize_text_field($_POST['email']);
    if( ! is_email( $email ) ) : ?>
        <p class="subscriber error">Vous n'avez pas le droit d'effectuer cette action.</p>
    	<?php wp_send_json_error(ob_get_clean(), 403);
        return;
    endif;

    $subscriber = [
        'post_title'    => $email,
        'post_content'  => "",
        'post_status'   => 'publish',
        'post_type' 	=> 'subscriber',
        'meta_input'    => [
            'blog'          => $_POST['blog'],
            'evenements'    => json_decode(stripslashes($_POST['evenements']), true),
            'zones'         => json_decode(stripslashes($_POST['zones']), true),
        ]
    ];

    if($_POST['id']) :
        update_post_meta($_POST['id'], 'evenements', json_decode(stripslashes($_POST['evenements']), true));
        update_post_meta($_POST['id'], 'zones', json_decode(stripslashes($_POST['zones']), true));
        ob_start() ?>
        <p class="subscriber sucess">Merci ! Vos changements ont bien été pris en compte !</p>
        <?php wp_send_json_success(ob_get_clean());
    else :
        wp_insert_post($subscriber);
        ob_start() ?>
        <p class="subscriber sucess">Merci ! Votre inscription à bien été prise en compte !</p>
        <p>Vous recevrez un mail de confirmation dans les prochaines minutes à l'adresse suivante : <?= $email ?></p>
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
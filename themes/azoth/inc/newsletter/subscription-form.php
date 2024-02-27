<div id="subscription-modal" class="modal-outer">
    <form action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" id="subscription-form" class="modal-inner">
        <button type="button" class="modal-close">
            <span class="modal-icon">
                <span class="screen-reader-text">Fermez la boite de dialogue</span>
            </span>
        </button>
        <p>Newsletter</p>
        <p>Déjà inscrit ?</a>
        <p> Renseignez votre adresse email pour modifier votre inscription.
        <p>
            <?php $inner_post_type = 'subscriber';
            $call = $inner_post_type . '_fields';
            $fields = $call();
            $new_subscriber = new stdClass();
            $new_subscriber->ID = -99;
            $new_subscriber->post_type = 'subscriber';
            $new_subscriber->filter = 'raw'; ?>
            <?php fields_generator($new_subscriber, $fields); ?>
            <input type="hidden" id="subscriber-id" name="subscriber-id" value="">
            <input type="hidden" id="update-nonce" name="update-nonce"
                value="<?php echo wp_create_nonce('subscription_update'); ?>">
            <input type="hidden" id="update-action" name="update-action" value="subscription_update">
            <input type="hidden" id="nonce" name="nonce" value="<?php echo wp_create_nonce('subscription_post'); ?>">
            <input type="hidden" id="action" name="action" value="subscription_post">
            <button id="subscription-btn">S'abonner</button>
    </form>
</div>
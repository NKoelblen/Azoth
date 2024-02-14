<?php
add_shortcode('subscription-form', 'subscription_form_shortcode');
function subscription_form_shortcode() {
    ob_start(); ?>
    <div class="modal-outer">
        <form class="modal-inner subscription-form">
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
            <button>S'abonner</button>
        </form>
    </div>
    <?php return ob_get_clean();
}
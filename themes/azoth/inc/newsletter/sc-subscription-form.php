<?php
// Récupérer les données de l'abonnement
add_action('wp_ajax_subscription_update', 'subscription_update');
add_action('wp_ajax_nopriv_subscription_update', 'subscription_update');
function subscription_update()
{
    if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'subscription_update')):
        wp_send_json_error("Vous n'avez pas le droit d'effectuer cette action.", 403);
        return;
    endif;

    if ($_POST['value']):

        $subsribers = get_posts(
            [
                'post_type' => 'subscriber',
                'title' => $_POST['value'],
                'post_status' => 'publish',
                'numberposts' => 1,
            ]
        );
        if ($subsribers):
            $ID = $subsribers[0]->ID;
            $evenements = get_post_meta($ID, 'evenements');
            $zones = get_post_meta($ID, 'zones');
            ob_start(); ?>
            <a href="#" class="delete-btn" data-ajaxurl='<?= admin_url('admin-ajax.php'); ?>'
                data-nonce='<?= wp_create_nonce('subscription_delete'); ?>' data-action='subscription_delete' data-id='<?= $ID ?>'>
                Me désincrire
            </a>
            <?php wp_send_json_success(['ID' => $ID, 'evenements' => $evenements, 'zones' => $zones, 'delete-btn' => ob_get_clean()]);
        endif;

    endif;
}

// Créer ou mettre à jour l'abonnement
add_action('wp_ajax_subscription_post', 'subscription_post');
add_action('wp_ajax_nopriv_subscription_post', 'subscription_post');
function subscription_post()
{
    // Vérifications de sécurité
    if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'subscription_post')):
        ob_start(); ?>
        <p class="subscriber error">Vous n'avez pas le droit d'effectuer cette action.</p>
        <?php wp_send_json_error(ob_get_clean(), 403);
        return;
    endif;
    $email = sanitize_text_field($_POST['email']);
    if (!is_email($email)):
        ob_start(); ?>
        <p class="subscriber error">Vous n'avez pas le droit d'effectuer cette action.</p>
        <?php wp_send_json_error(ob_get_clean(), 403);
        return;
    endif;
    $evenements = json_decode(stripslashes($_POST['evenements']), true);
    foreach ($evenements as $evenement):
        if (
            !json_validate($evenement) ||
            str_contains($evenement, "<") ||
            str_contains($evenement, ">") ||
            str_contains($evenement, "$")
        ):
            ob_start(); ?>
            <p class="subscriber error">Vous n'avez pas le droit d'effectuer cette action.</p>
            <?php wp_send_json_error(ob_get_clean(), 403);
        endif;
    endforeach;
    $zones = json_decode(stripslashes($_POST['zone']), true);
    foreach ($zones as $zone):
        if (
            !json_validate($zone) ||
            str_contains($evenement, "<") ||
            str_contains($evenement, ">") ||
            str_contains($evenement, "$")
        ):
            ob_start(); ?>
            <p class="subscriber error">Vous n'avez pas le droit d'effectuer cette action.</p>
            <?php wp_send_json_error(ob_get_clean(), 403);
        endif;
    endforeach;

    // Données de l'abonnement
    $subscriber = [
        'post_title' => $email,
        'post_content' => "",
        'post_status' => 'publish',
        'post_type' => 'subscriber',
        'meta_input' => [
            'blog' => $_POST['blog'],
            'evenements' => json_decode(stripslashes($_POST['evenements']), true),
            'zones' => json_decode(stripslashes($_POST['zones']), true),
        ]
    ];

    // Création ou mise à jour de l'abonnement et affichage d'un message de confirmation
    ob_start() ?>
    <div class="subscriber sucess">
        <p>
            <?php if ($_POST['id']):
                $ID = $_POST['id'];
                // Mise à jour de l'abonnement
                update_post_meta($_POST['id'], 'evenements', json_decode(stripslashes($_POST['evenements']), true));
                update_post_meta($_POST['id'], 'zones', json_decode(stripslashes($_POST['zones']), true));
                echo 'Merci ! Vos changements ont bien été pris en compte !';
            else:
                // Création de l'abonnement
                $ID = wp_insert_post($subscriber);
                echo 'Merci ! Votre inscription à bien été prise en compte !';
            endif; ?>
        </p>
        <p>Vous recevrez un mail de confirmation dans les prochaines minutes à l'adresse suivante :
            <?= $email ?>
        </p>
    </div>
    <?php $message = ob_get_clean();
    ob_start(); ?>
    <a href="#" class="delete-btn" data-ajaxurl='<?= admin_url('admin-ajax.php'); ?>'
        data-nonce='<?= wp_create_nonce('subscription_delete'); ?>' data-action='subscription_delete' data-id='<?= $ID ?>'>
        Me désincrire
    </a>
    <?php $delete_btn = ob_get_clean();
    wp_send_json_success(['message' => $message, 'ID' => $ID, 'delete-btn' => $delete_btn]);

    // Envoi d'un email de confirmation
    ob_start();
    $title = 'Confirmation d\'abonnement à notre newsletter'; ?>
    <!DOCTYPE html>
    <html xmlns="https://www.yourwebsite.com/1999/xhtml">

    <head>
        <title>
            <?= $title ?>
        </title>
        <style></style>
    </head>
    <header>
        <a href="<?= get_site_url(); ?>"><img
                src="<?= get_site_url(null, '/wp-content/themes/azoth/assets/images/logo-full.webp'); ?>"
                height="256px"></a>
        <h1>
            <?= $title; ?>
        </h1>
    </header>

    <body>
        <p>
            Nous avons le plaisir de vous confirmer
            <?= $_POST['id'] ? ' la modification de ' : ' '; ?>
            votre abonnement à notre newsletter !
        </p>
        <p>Vous serez informé de nos actualités, dès leur publication, et selon vos préférences :</p>
        <!-- ... -->
        <p>Retrouvez également les dernières publications à l'adresse suivante :</p>
        <a href="#">azoth.fr</a>
        <p>Au plaisir de vous retrouver lors de nos prochaines rencontres !</p>
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
    <?php $message = ob_get_clean();
    // wp_mail($email, $title, $message);
}

// Supprimer l'abonnement
add_action('wp_ajax_subscription_delete', 'subscription_delete');
add_action('wp_ajax_nopriv_subscription_delete', 'subscription_delete');
function subscription_delete()
{
    // Vérifications de sécurité
    if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'subscription_delete')):
        ob_start(); ?>
        <p class="subscriber error">Vous n'avez pas le droit d'effectuer cette action.</p>
        <?php wp_send_json_error(ob_get_clean(), 403);
        return;
    endif;

    // Suppression de l'abonnement (mise à la corbeille)
    $subscriber = [
        'ID' => $_POST['id'],
        'post_status' => 'trash',
    ];
    wp_update_post($subscriber);

    // Affichage d'un message de confirmation
    $email = get_the_title($_POST['id']);
    ob_start() ?>
    <div class="subscriber sucess">
        <p class="subscriber sucess">Votre désinscription a bien été prise en compte.</p>
        <p>Vous recevrez un mail de confirmation dans les prochaines minutes à l'adresse suivante :
            <?= $email ?>
        </p>
    </div>
    <?php wp_send_json_success(ob_get_clean());

    // Envoi d'un mail de confirmation
    ob_start();
    $title = 'Confirmation de désabonnement à notre newsletter'; ?>
    <!DOCTYPE html>
    <html xmlns="https://www.yourwebsite.com/1999/xhtml">

    <head>
        <title>
            <?= $title ?>
        </title>
        <style></style>
    </head>
    <header>
        <a href="<?= get_site_url(); ?>"><img
                src="<?= get_site_url(null, '/wp-content/themes/azoth/assets/images/logo-full.webp'); ?>"
                height="256px"></a>
        <h1>
            <?= $title; ?>
        </h1>
    </header>

    <body>
        <p>Nous vous confirmons votre désabonnement à notre newsletter.</p>
        <p>Pour rappel, vous pouvez retrouver les dernières publications à l'adresse suivante :</p>
        <a href="#">azoth.fr</a>
        <p>En espérant vous retrouver lors de nos prochaines rencontres.</p>
    </body>

    <footer>
        <p><a href="<?= get_site_url(); ?>">azoth.fr</a> | <a href="mailto:email@contact@azoth.fr">contact@azoth.fr</a></p>
        <div>
            <a href="#"><img src="<?= get_site_url(null, '/wp-content/themes/azoth/assets/images/square-facebook.svg'); ?>"
                    height="24px"></a>
            <a href="#"><img src="<?= get_site_url(null, '/wp-content/themes/azoth/assets/images/square-youtube.svg'); ?>"
                    height="24px"></a>
    </footer>

    </html>
    <?php $message = ob_get_clean();
    // wp_mail($email, $title, $message);
}
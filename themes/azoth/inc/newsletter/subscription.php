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

    <?php get_template_part('/inc/newsletter/newsletter-header'); ?>
    <p>
        Nous avons le plaisir de vous confirmer
        <?= $_POST['id'] ? ' la modification de ' : ' '; ?>
        votre abonnement à notre newsletter !
    </p>
    <p>Vous serez informé de nos actualités dans les 7 jours suivant leurs publications, et selon vos préférences :</p>
    <ul>
        <li>Articles du blog</li>
        <?php $list_evenements = [];

        $evenements = get_post_meta($ID, 'evenements', true);

        foreach ($evenements as $evenement):
            $evenement = json_decode($evenement, true);

            $list_evenements[$evenement['post_type']]['post_type'] = $evenement['post_type'];

            if (
                isset($evenement['stage_categorie'])
            ):
                $list_evenements[$evenement['post_type']]['stage_categories'][$evenement['stage_categorie']]['stage_categorie'] = $evenement['stage_categorie'];
                if (
                    isset($evenement['voie'])
                ):
                    $list_evenements[$evenement['post_type']]['stage_categories'][$evenement['stage_categorie']]['voies'][] = $evenement['voie'];
                    // echo get_the_title($evenement['voie']);
                endif;
            else:
                if (
                    isset($evenement['voie'])
                ):
                    $list_evenements[$evenement['post_type']]['voies'][] = $evenement['voie'];
                endif;
            endif;
        endforeach;

        foreach ($list_evenements as $item):
            $post_type_object = get_post_type_object($item['post_type']); ?>
            <li>
                <?php if ($item['post_type'] === 'formation'):
                    echo 'Nouveaux cycles de ';
                endif;
                echo $post_type_object->labels->name;
                if (isset($item['stage_categories'])): ?>
                    <ul>
                        <?php foreach ($item['stage_categories'] as $stage_categorie):
                            $term = get_term_by('term_id', $stage_categorie['stage_categorie'], 'stage_categorie'); ?>
                            <li>
                                <?php echo $term->name;
                                if (isset($stage_categorie['voies'])): ?>
                                    <ul>
                                        <?php foreach ($stage_categorie['voies'] as $voie): ?>
                                            <li>
                                                <?= get_the_title($voie); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif;
                if (isset($item['voies'])): ?>
                    <ul>
                        <?php foreach ($item['voies'] as $voie): ?>
                            <li>
                                <?= get_the_title($voie); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endforeach;

        if (
            in_array('{"post_type":"conference"}', $evenements) ||
            in_array('{"post_type":"formation","voie":237}', $evenements)
        ):
            $list_zones = [];
            foreach (get_post_meta($ID, 'zones', true) as $zone):
                $zone = json_decode($zone, true);
                if (isset($zone['parent'])):
                    $list_zones[$zone['parent']['geo_zone']]['parent'] = $zone['parent']['geo_zone'];
                    $list_zones[$zone['parent']['geo_zone']]['geo_zones'][] = $zone['geo_zone'];
                else:
                    $list_zones[$zone['geo_zone']] = $zone['geo_zone'];
                endif;
            endforeach;
            foreach ($list_zones as $item): ?>
                <li>
                    <?php if (isset($item['parent'])):
                        $parent = get_term_by('term_id', $item['parent'], 'geo_zone');
                        echo $parent->name; ?>
                        <ul>
                            <?php foreach ($item['geo_zones'] as $geo_zone):
                                $term = get_term_by('term_id', $geo_zone, 'geo_zone'); ?>
                                <li>
                                    <?= $term->name; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else:
                        $term = get_term_by('term_id', $item, 'geo_zone');
                        echo $term->name;
                    endif; ?>
                </li>
            <?php endforeach;
        endif; ?>
    </ul>
    <p>Retrouvez également les dernières publications à l'adresse suivante :</p>
    <a href="#">azoth.fr</a>
    <p>Au plaisir de vous retrouver lors de nos prochaines rencontres !</p>
    <?php get_template_part('/inc/newsletter/newsletter-footer'); ?>

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

    <?php get_template_part('/inc/newsletter/newsletter-header'); ?>
    <p>Nous vous confirmons votre désabonnement à notre newsletter.</p>
    <p>Pour rappel, vous pouvez retrouver les dernières publications à l'adresse suivante :</p>
    <a href="#">azoth.fr</a>
    <p>En espérant vous retrouver lors de nos prochaines rencontres.</p>
    <?php get_template_part('/inc/newsletter/newsletter-footer'); ?>

    <?php $message = ob_get_clean();
    // wp_mail($email, $title, $message);
}
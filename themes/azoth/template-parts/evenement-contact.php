<?php
$e_coordonnees = get_post_meta($post->ID, 'e_coordonnees', true);
if ($e_coordonnees === 'contact'):
    get_post_meta($post->ID, 'contact', true);
    $contact_args = [
        'post_type' => 'contact',
        'post_status' => 'publish',
        'posts_per_page' => 1,
    ];
    $contact_post = new WP_Query($contact_args);
    if ($contact_post->have_posts()):
        while ($contact_post->have_posts()):
            $contact_post->the_post();
            $nom = get_post_meta($post->ID, 'c_nom', true);
            $email = get_post_meta($post->ID, 'c_email', true);
            $telephone = get_post_meta($post->ID, 'c_telephone', true);
        endwhile;
    endif;
    wp_reset_postdata();
else:
    if ($e_coordonnees === 'autre-instructeur'):
        $instructeur_args['author'] = get_post_meta($post->ID, 'e_autre_instructeur', true);
        $instructeur_post = new WP_Query($instructeur_args);
    endif;
    if ($instructeur_post->have_posts()):
        while ($instructeur_post->have_posts()):
            $instructeur_post->the_post();
            $nom = get_the_title();
            $email = get_post_meta($post->ID, 'i_email', true);
            $telephone = get_post_meta($post->ID, 'i_telephone', true);
        endwhile;
    endif;
    wp_reset_postdata();
endif;
if ($email || $telephone):
    if ($nom):
        $coordonnees[] = $nom;
    endif;
    if ($email):
        $coordonnees[] = $email;
    endif;
    if ($telephone):
        $coordonnees[] = $telephone;
    endif;
endif;
if (isset($coordonnees)): ?>
    <p><span>Contact : </span>
        <?= implode(' | ', $coordonnees); ?>
    </p>
<?php endif;

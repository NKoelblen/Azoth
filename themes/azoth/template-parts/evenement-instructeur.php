<?php
$author = get_the_author_meta('ID');
$instructeur_args = [
    'post_type'         => 'instructeur',
    'author'            => $author,
    'post_status'       => 'publish',
    'posts_per_page'    => 1,
];
$instructeur_post = new WP_Query($instructeur_args);
if ($instructeur_post->have_posts()) :
    while ($instructeur_post->have_posts()) :
        $instructeur_post->the_post(); ?>
        <p>Par <a href="<?= get_the_permalink(); ?>"><?= get_the_title(); ?></a></p>
    <?php endwhile;
endif;
wp_reset_postdata();
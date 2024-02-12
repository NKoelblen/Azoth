<?php
/**
 * The template for displaying all single formations.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#custom-post-types
 *
 */

get_header();

/* Start the Loop */
while (have_posts()) :
	the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <?php $voie = get_post_meta($post->ID, 'e_voie', true); ?>
		<h1 class="entry-title">Formation : Session n°<?= get_post_meta($post->ID, 'e_session', true) ?> de <a href="<?= get_the_permalink($voie); ?>"><?= get_the_title($voie); ?></a></h1>

		<div class="entry-content">

            <!-- Instructeur -->

            <?php $author = get_the_author_meta('ID');
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
            wp_reset_postdata(); ?>

            <!-- Contact -->

            <?php $e_coordonnees = get_post_meta($post->ID, 'e_coordonnees', true);
            if ($e_coordonnees === 'contact') :
                get_post_meta($post->ID, 'contact', true);
                $contact_args = [
                    'post_type'         => 'contact',
                    'post_status'       => 'publish',
                    'posts_per_page'    => 1,
                ];
                $contact_post = new WP_Query($contact_args);
                if ($contact_post->have_posts()) :
                    while ($contact_post->have_posts()) :
                        $contact_post->the_post();
                        $nom = get_post_meta($post->ID, 'c_nom', true);
                        $email = get_post_meta($post->ID, 'c_email', true);
                        $telephone = get_post_meta($post->ID, 'c_telephone', true);
                    endwhile;
                endif;
                wp_reset_postdata();
            else :
                if ($e_coordonnees === 'autre-instructeur') :
                    $instructeur_args['author'] = get_post_meta($post->ID, 'e_autre_instructeur', true);
                    $instructeur_post = new WP_Query($instructeur_args);
                endif;
                if ($instructeur_post->have_posts()) :
                    while ($instructeur_post->have_posts()) :
                        $instructeur_post->the_post();
                        $nom = get_the_title();
                        $email = get_post_meta($post->ID, 'i_email', true);
                        $telephone = get_post_meta($post->ID, 'i_telephone', true);
                    endwhile;
                endif;
                wp_reset_postdata();
            endif;
            if($email || $telephone) :
                if($nom) :
                    $coordonnees[] = $nom;
                endif;
                if($email) :
                    $coordonnees[] = $email;
                endif;
                if($telephone) :
                    $coordonnees[] = $telephone;
                endif;
            endif;
            if (isset($coordonnees)) : ?>
                <p><span>Contact : </span><?= implode(' | ', $coordonnees); ?></p>
            <?php endif; ?>

            <!-- Rendez-vous -->

            <?php $lieu = get_post_meta($post->ID, 'lieu', true);
            $date_du = get_post_meta($post->ID, 'e_date_du', true);
            $date_au = get_post_meta($post->ID, 'e_date_au', true); ?>
            <p>
                <?php if ($lieu) : ?>
                    <a href="<?= get_the_permalink($lieu); ?>"><?= get_the_title($lieu); ?></a>, 
                <?php endif; ?>
                <?php if ($date_du) : ?>
                    du <?= date_i18n( get_option( 'date_format' ), strtotime($date_du)); ?>
                <?php endif; ?>
                <?php if ($date_au) : ?>
                    au <?= date_i18n( get_option( 'date_format' ), strtotime($date_au)); ?>
                <?php endif; ?>
            </p>

            <?php $terms = get_the_terms($post->ID, 'prerequis');
            if ($terms) : ?>
                <p class="post-taxonomies"> Prérequis : 
                    <?php foreach ($terms as $term) :
                        echo $term->name;
                    endforeach; ?>
                </p>
            <?php endif; ?>

            <!-- Informations -->
            <?php $informations = get_post_meta($post->ID, 'e_informations', true);
            if($informations) : ?>
                <div>
                    <p>Informations complémentaires : </p>
                    <?= wpautop($informations); ?>
                </div>
            <?php endif; ?>

		</div><!-- .entry-content -->

	</article><!-- #post-<?php the_ID(); ?> -->

    <?php get_template_part('template-parts/post-navigation');

endwhile; // End of the loop.

get_footer();
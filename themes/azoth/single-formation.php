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

            <?php get_template_part('/tempate-parts/evenement-instructeur'); ?>

            <?php get_template_part('/tempate-parts/evenement-contact'); ?>

            <?php get_template_part('/tempate-parts/evenement-rdv'); ?>

            <?php get_template_part('/tempate-parts/evenement-prerequis'); ?>            

            <?php get_template_part('/tempate-parts/evenement-informations'); ?>            

		</div><!-- .entry-content -->

	</article><!-- #post-<?php the_ID(); ?> -->

    <?php get_template_part('template-parts/post-navigation');

endwhile; // End of the loop.

get_footer();
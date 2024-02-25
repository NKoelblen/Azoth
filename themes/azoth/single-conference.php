<?php
/**
 * The template for displaying all single conférences.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#custom-post-types
 *
 */
get_header();

/* Start the Loop */
while (have_posts()):
	the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<h1 class="entry-title">Conférence</h1>

		<div class="entry-content">

			<?php get_template_part('/tempate-parts/evenement-instructeur'); ?>

			<?php get_template_part('/tempate-parts/evenement-contact'); ?>

			<?php get_template_part('/tempate-parts/evenement-rdv'); ?>

			<?php get_template_part('/tempate-parts/evenement-informations'); ?>

		</div><!-- .entry-content -->

	</article><!-- #post-<?php the_ID(); ?> -->

	<?php get_template_part('template-parts/post-navigation');

endwhile; // End of the loop.

get_footer();
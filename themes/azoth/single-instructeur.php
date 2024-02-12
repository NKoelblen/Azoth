<?php
/**
 * The template for displaying all single instructeurs.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#custom-post-types
 *
 */
get_header();

/* Start the Loop */
while (have_posts()) :
	the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
			<?php the_post_thumbnail('medium'); ?>
			<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
			<p><?= get_post_meta($post->ID, 'i_fonction', true); ?></p>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content();

			wp_link_pages(
				array(
					'before'   => '<nav class="page-links" aria-label="Page">',
					'after'    => '</nav>',
					/* translators: %: Page number. */
					'pagelink' => 'Page %',
				)
			); ?>
		</div><!-- .entry-content -->

	</article><!-- #post-<?php the_ID(); ?> -->

    <?php get_template_part('template-parts/post-navigation');

endwhile; // End of the loop.

get_footer();
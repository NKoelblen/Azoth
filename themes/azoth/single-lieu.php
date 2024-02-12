<?php
/**
 * The template for displaying all single lieux.
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
            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
			<?php the_post_thumbnail('large'); ?>
            <p class="post-taxonomies">
                <?php $terms = get_the_terms($post->ID, 'geo_zone');
                foreach ($terms as $term) :
                    echo get_term_parents_list($term->term_id, 'geo_zone', ['separator' => ' | ']);
                endforeach; ?>
            </p>
		</header><!-- .entry-header -->

		<div class="entry-content">
            <div id="map" class="leaflet-container leaflet-touch leaflet-retina leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom"></div>
            <input type="hidden" value="<?= get_post_meta($post->ID, 'l_carte', true); ?>">

			<?php the_content(); ?>

			<?php wp_link_pages(
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
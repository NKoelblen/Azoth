<?php
/**
 * The template for displaying instructeur's archive pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */
get_header();

if (have_posts()) : ?>
	<header class="page-header">
		<h1 class="page-title">Instructeurs</h1>
	</header><!-- .page-header -->
	<?php while (have_posts()) :
	    the_post(); ?>
	    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
			<?php the_post_thumbnail('medium'); ?>
			<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
			<p><?= get_post_meta($post->ID, 'i_fonction', true); ?></p>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->

	</article><!-- #post-<?php the_ID(); ?> -->
	<?php endwhile;

    the_posts_pagination(
			array(
				'before_page_number' => 'Page' . ' ',
				'mid_size'           => 0,
				'prev_text'          => '<span class="nav-prev-text"></span>Articles <span class="nav-short">précédents</span>',
				'next_text'          => '<span class="nav-next-text"></span>Articles <span class="nav-short">suivants</span>',
			)
		);
endif; ?>

<?php get_footer();
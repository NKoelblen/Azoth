<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */

get_header();

/* Start the Loop */
while (have_posts()):
	the_post();

	get_template_part('template-parts/content');


	if (is_attachment()):
		// Parent post navigation.
		the_post_navigation(
			[
				'prev_text' => sprintf(__('<span class="meta-nav">Publié dans</span><span class="post-title">%s</span>'), '%title'),
			]
		);
	endif;

	get_template_part('template-parts/post-navigation');

endwhile; // End of the loop.

get_footer();
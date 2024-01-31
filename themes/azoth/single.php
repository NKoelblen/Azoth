<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */

get_header();

/* Start the Loop */
while (have_posts()) :
	the_post();?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    	<header class="entry-header">
    		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
    		<?php the_post_thumbnail('large'); ?>
    	</header><!-- .entry-header -->

    	<div class="entry-content">
    		<?php the_content();

    		wp_link_pages(
    			array(
    				'before'   => '<nav class="page-links" aria-label="' . esc_attr__('Page') . '">',
    				'after'    => '</nav>',
    				/* translators: %: Page number. */
    				'pagelink' => esc_html__('Page %'),
    			)
    		); ?>
    	</div><!-- .entry-content -->

    	<footer class="entry-footer">
            <div class="posted-on">
		    	<?php $time_string = '<time class="entry-date" datetime="%1$s">%2$s</time>';
                $time_string = sprintf(
                    $time_string,
                    esc_attr(get_the_date(DATE_W3C)),
                    esc_html(get_the_date())
                ); ?>
                <span class="posted-on">'
                <?php printf(
                    /* translators: %s: Publish date. */
                    esc_html__('Publié le %s'),
                    $time_string
                ); ?>
                </span>
		    </div>
            <?php if (has_category() || has_tag()) : ?>
                <div class="post-taxonomies">
                    <?php $categories_list = get_the_category_list(wp_get_list_item_separator());
                    if ($categories_list) :
                        printf(
                            /* translators: %s: List of categories. */
                            '<span class="cat-links">' . esc_html__('%s') . ' </span>',
                            $categories_list // phpcs:ignore WordPress.Security.EscapeOutput
                        );
                    endif;
                    $tags_list = get_the_tag_list('', wp_get_list_item_separator());
                    if ($tags_list) :
                        printf(
                            /* translators: %s: List of tags. */
                            '<span class="tags-links">' . esc_html__('%s') . '</span>',
                            $tags_list // phpcs:ignore WordPress.Security.EscapeOutput
                        );
                    endif ?>
                </div>
            <?php endif; ?>
    	</footer><!-- .entry-footer -->

    </article><!-- #post-<?php the_ID(); ?> -->

	<?php if (is_attachment()) {
		// Parent post navigation.
		the_post_navigation(
			array(
				/* translators: %s: Parent post link. */
				'prev_text' => sprintf(__('<span class="meta-nav">Publié dans</span><span class="post-title">%s</span>'), '%title'),
			)
		);
	}

	// Previous/next post navigation.
	$next_label     = esc_html__('Suivant');
	$previous_label = esc_html__('Précédent');

	the_post_navigation(
		array(
			'next_text' => '<p class="meta-nav">' . $twentytwentyone_next_label . '</p><p class="post-title">%title</p>',
			'prev_text' => '<p class="meta-nav">' . $twentytwentyone_previous_label . '</p><p class="post-title">%title</p>',
		)
	);
endwhile; // End of the loop.

get_footer();
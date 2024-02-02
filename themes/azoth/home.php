<?php
/**
 * The template for displaying the home page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#home-page-display
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

<?php endwhile; // End of the loop.

get_footer();
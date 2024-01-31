<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */
get_header();

$description = get_the_archive_description();

if ( have_posts() ) : ?>
	<header class="page-header">
		<?php the_archive_title( '<h1 class="page-title">', '</h1>' );
		if ( $description ) : ?>
			<div class="archive-description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
		<?php endif; ?>
	</header><!-- .page-header -->
	<?php while ( have_posts() ) :
	    the_post(); ?>
	    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        	<header class="entry-header">
        		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' );
        		the_post_thumbnail('large'); ?>
        	</header><!-- .entry-header -->
            
        	<div class="entry-content">
        		<?php the_content(
        			sprintf(
                        /* translators: %s: Post title. Only visible to screen readers. */
                        esc_html__( 'Continuer à lire %s' )
                    )
        		);
            
        		wp_link_pages(
        			array(
        				'before'   => '<nav class="page-links" aria-label="' . esc_attr__('Page') . '">',
        				'after'    => '</nav>',
        				/* translators: %: Page number. */
        				'pagelink' => esc_html__( 'Page %' ),
        			)
        		);
            
        		?>
        	</div><!-- .entry-content -->
            
        	<footer class="entry-footer">
                <div class="posted-on">
		        	<?php $time_string = '<time class="entry-date" datetime="%1$s">%2$s</time>';
                    $time_string = sprintf(
                        $time_string,
                        esc_attr( get_the_date( DATE_W3C ) ),
                        esc_html( get_the_date() )
                    ); ?>
                    <span class="posted-on">'
                    <?php printf(
                        /* translators: %s: Publish date. */
                        esc_html__( 'Publié le %s' ),
                        $time_string
                    ); ?>
                    </span>
		        </div>
                <?php if ( has_category() || has_tag() ) : ?>
                    <div class="post-taxonomies">
                        <?php $categories_list = get_the_category_list( wp_get_list_item_separator() );
                        if ( $categories_list ) :
                            printf(
                                /* translators: %s: List of categories. */
                                '<span class="cat-links">' . esc_html__( '%s') . ' </span>',
                                $categories_list // phpcs:ignore WordPress.Security.EscapeOutput
                            );
                        endif;
                        $tags_list = get_the_tag_list( '', wp_get_list_item_separator() );
                        if ( $tags_list ) :
                            printf(
                                /* translators: %s: List of tags. */
                                '<span class="tags-links">' . esc_html__( '%s') . '</span>',
                                $tags_list // phpcs:ignore WordPress.Security.EscapeOutput
                            );
                        endif ?>
                    </div>
                <?php endif; ?>
        	</footer><!-- .entry-footer -->
        </article><!-- #post-<?php the_ID(); ?> -->
	<?php endwhile; ?>

	<?php twenty_twenty_one_the_posts_navigation(); ?>

<?php else : ?>
	<?php get_template_part( 'template-parts/content/content-none' ); ?>
<?php endif; ?>

<?php
get_footer();
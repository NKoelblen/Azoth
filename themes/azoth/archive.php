<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */
get_header();

$description = get_the_archive_description();

if (have_posts()) : ?>
	<header class="page-header">
		<?php the_archive_title('<h1 class="page-title">', '</h1>');
		if ($description) : ?>
			<div class="archive-description"><?php echo wp_kses_post(wpautop($description)); ?></div>
		<?php endif; ?>
	</header><!-- .page-header -->
	<?php while (have_posts()) :
	    the_post(); ?>
	    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        	<header class="entry-header">
        		<?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>');
        		the_post_thumbnail('large'); ?>
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
            
        	<footer class="entry-footer">
                <div class="posted-on">
		        	<?php $time_string = '<time class="entry-date" datetime="%1$s">%2$s</time>';
                    $time_string = sprintf(
                        $time_string,
                        get_the_date(DATE_W3C),
                        get_the_date()
                    ); ?>
                    <span class="posted-on">Publié le <?= $time_string ?></span>
		        </div>
                <?php if (has_category() || has_tag()) : ?>
                    <div class="post-taxonomies">
                        <?php $categories_list = get_the_category_list(wp_get_list_item_separator());
                        if ($categories_list) : ?>
							<span class="cat-links"><?= $categories_list?></span>
                        <?php endif;
                        $tags_list = get_the_tag_list('', wp_get_list_item_separator());
                        if ($tags_list) : ?>
                            <span class="tags-links"><?= $tags_list ?></span>
                        <?php endif ?>
                    </div>
                <?php endif; ?>
        	</footer><!-- .entry-footer -->
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
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
		<?php the_post_thumbnail('large'); ?>
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
		
	<?php if (get_post_type() === 'post') : ?>
		<footer class="entry-footer">
    	    <div class="posted-on">
		    	<?php $time_string = '<time class="entry-date" datetime="' . get_the_date(DATE_W3C) . '">' . get_the_date() . '</time>'; ?>
    	        <span class="posted-on">Publié le <?= $time_string ?></span>
		    </div>
    	    <?php if (has_category() || has_tag()) : ?>
    	        <div class="post-taxonomies">
    	            <?php $categories_list = get_the_category_list(wp_get_list_item_separator());
    	            if ($categories_list) : ?>
						<span class="cat-links"><?= $categories_list ?></span>
    	            <?php endif;
    	            $tags_list = get_the_tag_list('', wp_get_list_item_separator());
    	            if ($tags_list) : ?>
    	                <span class="tags-links"><?= $tags_list ?></span>
    	            <?php endif ?>
    	        </div>
    	    <?php endif; ?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
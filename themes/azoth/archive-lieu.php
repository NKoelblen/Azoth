<?php
/**
 * The template for displaying lieu's archive pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */
get_header();

$evenement_posts = new WP_Query(
    [
        'post_type'         => ['conference', 'formation', 'stage'],
        'post_status'       => 'publish',
        'posts_per_page'    => -1,
    ]
);

// foreach ($terms as $term) :
//     $term_parents_list =  get_term_parents_list($term->term_id, 'geo_zone', ['separator' => '|']);
// 	$term_parents = explode('|', $term_parents_list);
// 	array_pop($term_parents);
// 	echo implode(' | ', $term_parents);
// endforeach;

$lieux = [];
$markers = [];
if ($evenement_posts->have_posts()) :
    while ($evenement_posts->have_posts()) :
        $evenement_posts->the_post();
        $lieu = get_post_meta($post->ID, 'lieu', true);
        $lieux[] = get_post_meta($post->ID, 'lieu', true);
        $markers[] = get_post_meta($lieu, 'l_carte', true);
    endwhile;
endif;
wp_reset_postdata();

$lieux_posts = new WP_Query(
    [
        'post__in'  => array_unique($lieux),
        'post_type' => 'lieu',
        'posts_per_page'    => -1,
    ]
);
if ($lieux_posts->have_posts()) : ?>
	
    <header class="page-header">
		<h1 class="page-title">Lieux de rencontre</h1>
	</header><!-- .page-header -->
    
    <div id="map" class="leaflet-container leaflet-touch leaflet-retina leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom"></div>
    <input type="text" value='<?= json_encode(array_unique($markers)) ?>'>
    <?php while ($lieux_posts->have_posts()) :
        $lieux_posts->the_post(); ?>

	    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	    	<header class="entry-header">
                <?php the_title('<h2 class="entry-title">', '</h2>'); ?>
	    		<?php the_post_thumbnail('large'); ?>
                <p class="post-taxonomies">
                    <?php $terms = get_the_terms($post->ID, 'geo_zone');
                    foreach ($terms as $term) :
                        $term_parents_list =  get_term_parents_list($term->term_id, 'geo_zone', ['separator' => '|']);
	    				$term_parents = explode('|', $term_parents_list);
	    				array_pop($term_parents);
	    				echo implode(' | ', $term_parents);
                    endforeach; ?>
                </p>
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
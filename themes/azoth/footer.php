<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of main and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 */
?>
</main><!-- #main -->

<footer id="colophon" class="site-footer">
	<?php if (has_nav_menu('footer')): ?>
		<nav aria-label="Menu Secondaire" class="footer-navigation">
			<ul class="footer-navigation-wrapper">
				<?php wp_nav_menu(
					[
						'theme_location' => 'footer',
						'items_wrap' => '%3$s',
						'container' => false,
						'depth' => 1,
						'link_before' => '<span>',
						'link_after' => '</span>',
						'fallback_cb' => false,
					]
				); ?>
			</ul><!-- .footer-navigation-wrapper -->
		</nav><!-- .footer-navigation -->
	<?php endif; ?>
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>

</html>
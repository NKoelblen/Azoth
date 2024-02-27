<?php
/**
 * The template for displaying the header.
 *
 * Displays all of the <head> section and everything up until main.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 */
?>

<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<header id="masthead" class="site-header">

		<?php $blog_info = get_bloginfo('name');
		$description = get_bloginfo('description', 'display'); ?>

		<div class="site-branding">
			<div class="site-logo"><a href="<?= esc_url(home_url('/')); ?>"><img
						src="<?= get_site_url(null, '/wp-content/themes/azoth/assets/images/logo.webp'); ?>"></a></div>
			<?php if ($blog_info): ?>
				<p><a href="<?= esc_url(home_url('/')); ?>">
						<?= $blog_info ?>
					</a></p>
			<?php endif; ?>
			<?php if ($description): ?>
				<p class="site-description">
					<?= $description; ?>
				</p>
			<?php endif; ?>
		</div><!-- .site-branding -->
		<div>
			<?php if (has_nav_menu('primary')): ?>
				<nav id="site-navigation" class="primary-navigation" aria-label="Menu Principal">
					<div class="menu-button-container">
						<button id="primary-mobile-menu" class="button" aria-controls="primary-menu-list"
							aria-expanded="false">
							<span class="dropdown-icon open"></span>
							<span class="dropdown-icon close"></span>
						</button><!-- #primary-mobile-menu -->
					</div><!-- .menu-button-container -->
					<?php wp_nav_menu(
						[
							'theme_location' => 'primary',
							'menu_class' => 'menu-wrapper',
							'container_class' => 'primary-menu-container',
							'items_wrap' => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
							'fallback_cb' => false,
						]
					); ?>
				</nav><!-- #site-navigation -->
			<?php endif;
			if (is_active_sidebar('primary-widget-area')):
				dynamic_sidebar('primary-widget-area');
			endif; ?>
		</div>
		<!-- Formulaire d'inscription à la Newsletter -->
		<?php get_template_part('/inc/newsletter/subscription-form'); ?>
	</header><!-- #masthead -->

	<main id="main" class="site-main">
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

    <?php $blog_info = get_bloginfo( 'name' );
    $description = get_bloginfo( 'description', 'display' ); ?>

        <div class="site-branding">
        	<div class="site-logo"></div>
        	<?php if ( $blog_info ) : ?>
        			<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $blog_info ); ?></a></p>
        	<?php endif; ?>
        	<?php if ( $description) : ?>
        		<p class="site-description">
        			<?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput ?>
        		</p>
        	<?php endif; ?>
        </div><!-- .site-branding -->

        <?php if ( has_nav_menu( 'primary' ) ) : ?>
        	<nav id="site-navigation" class="primary-navigation" aria-label="Menu Principal">
        		<div class="menu-button-container">
        			<button id="primary-mobile-menu" class="button" aria-controls="primary-menu-list" aria-expanded="false">
        				<span class="dropdown-icon open"></span>
        				<span class="dropdown-icon close"></span>
        			</button><!-- #primary-mobile-menu -->
        		</div><!-- .menu-button-container -->
        		<?php
        		wp_nav_menu(
        			array(
        				'theme_location'  => 'primary',
        				'menu_class'      => 'menu-wrapper',
        				'container_class' => 'primary-menu-container',
        				'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
        				'fallback_cb'     => false,
        			)
        		); ?>
        	</nav><!-- #site-navigation -->
        <?php endif; ?>
    </header><!-- #masthead -->

    <main id="main" class="site-main">
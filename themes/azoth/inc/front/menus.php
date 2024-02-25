<?php
/**
 * Register menus.
 */
register_nav_menus(
	array(
		'primary' => esc_html__('Menu principal'),
		'footer' => esc_html__('Menu secondaire')
	)
);
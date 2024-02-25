<?php
add_action('widgets_init', 'register_primary_widget_area');
function register_primary_widget_area()
{
    register_sidebar(
        array(
            'id' => 'primary-widget-area',
            'name' => 'Zone de widgets principale',
            'description' => 'Zone de widgets du menu principal',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
        )
    );
}
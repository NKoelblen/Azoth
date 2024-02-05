<?php

function columns( $nr ) {
    return 1;
}
add_filter( 'get_user_option_screen_layout_instructeur', 'columns' );
add_filter( 'get_user_option_screen_layout_lieu', 'columns' );
add_filter( 'get_user_option_screen_layout_contact', 'columns' );
add_filter( 'get_user_option_screen_layout_conference', 'columns' );
add_filter( 'get_user_option_screen_layout_formation', 'columns' );
add_filter( 'get_user_option_screen_layout_stage', 'columns' );
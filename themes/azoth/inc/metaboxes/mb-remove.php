<?php
function remove_metaboxes() {
	remove_meta_box( 'submitdiv', 'instructeur', 'side' );
	remove_meta_box( 'submitdiv', 'lieu', 'side' );
	remove_meta_box( 'submitdiv', 'contact', 'side' );
	remove_meta_box( 'submitdiv', 'conference', 'side' );
	remove_meta_box( 'submitdiv', 'formation', 'side' );
	remove_meta_box( 'submitdiv', 'stage', 'side' );
}
add_action( 'do_meta_boxes', 'remove_metaboxes' );
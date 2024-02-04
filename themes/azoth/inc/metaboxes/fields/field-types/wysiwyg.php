<?php
function wysiwyg_field($field, $meta_value) {
    ob_start();
    wp_editor(
        $meta_value,
        $field['id'],
        [
            'media_buttons' => false,
            'quicktags'     => false
        ]
    );
    $input = ob_get_contents();
    ob_end_clean();
    echo $input;
}

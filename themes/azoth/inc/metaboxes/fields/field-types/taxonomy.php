<?php
function taxonomy_field($field, $post)
{
    $box['args']['taxonomy'] = $field['taxonomy'];
    post_categories_meta_box($post, $box);
}
;
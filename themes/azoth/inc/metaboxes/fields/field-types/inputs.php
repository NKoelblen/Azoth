<?php
function input_field($field, $meta_value) {
    if(!$meta_value && array_key_exists('default', $field)) :
        $meta_value = $field['default'];
    endif; ?>
    <input
        id="<?= $field['id'] ?>"
        name="<?= $field['id'] ?>"
        type="<?= $field['type'] ?>"
        value="<?= $meta_value ?>"
        style="width: 100%;"
    >
<?php };
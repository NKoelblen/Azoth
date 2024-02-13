<?php
function input_field($field, $meta_value) { ?>
    <input
        id="<?= $field['id'] ?>"
        name="<?= $field['id'] ?>"
        type="<?= $field['type'] ?>"
        value="<?= $meta_value ?>"
        <?= isset($field['required']) && $field['required'] ? 'required' : '' ?>
    >
<?php };
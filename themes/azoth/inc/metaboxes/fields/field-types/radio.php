<?php
function radio_field($field, $meta_value)
{ ?>
    <?php foreach ($field['options'] as $option): ?>
        <label for="<?= $option['id'] ?>">
            <input type="radio" id="<?= $option['id'] ?>" name="<?= $field['id'] ?>" value="<?= $option['slug'] ?>"
                <?= isset($meta_value) && $meta_value === $option['slug'] ? 'checked' : ''; ?>         <?= isset($field['required']) && $field['required'] ? 'required' : '' ?>>
            <?= $option['title'] ?>
        </label>
    <?php endforeach; // option  ?>
<?php }
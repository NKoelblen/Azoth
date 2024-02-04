<?php
function radio_field($field, $meta_value) { ?>
    <?php foreach ($field['options'] as $option) :
        $checked  = isset($meta_value) && $meta_value === $option['slug'] ? 'checked' : ''; ?>
        <div>
            <input
                type="radio"
                id="<?= $option['id'] ?>"
                name="<?= $field['id'] ?>"
                value="<?= $option['slug'] ?>"
                <?= $checked ?>
            >
            <label for="<?= $option['id'] ?>"><?= $option['title'] ?></label>
        </div>
    <?php endforeach; // option ?>
<?php }
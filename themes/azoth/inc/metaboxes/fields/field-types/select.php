<?php
function select_field($field, $meta_value, $disabled) {
    if ($meta_value) :
        $selected  = isset($meta_value) ? $meta_value : '';
        $selected_key = array_search(
            $selected,
            array_column($field['options'], 'id')
        ); ?>
        <select
            id="<?= $field['id'] ?>"
            name="<?= $field['id'] ?>"
            style="width: 100%;"
            <?= $disabled ?>
        >
            <option value="<?= $selected ?>">
                <?= $field['options'][$selected_key]['title']; ?>
            </option>
            <?php unset($field['options'][$selected_key]);
            foreach ($field['options'] as $option) : ?>
                <option value="<?= $option['id'] ?>">
                    <?= $option['title'] ?>
                </option>
            <?php endforeach; // option 
    else : // !meta_value ?>
        <select
            id="<?= $field['id'] ?>"
            name="<?= $field['id'] ?>"
            style="width: 100%;"
            <?= $disabled ?>
        >
            <?php foreach ($field['options'] as $option) : ?>
                <option value="<?= $option['id'] ?>">
                    <?= $option['title'] ?>
                </option>
            <?php endforeach; // option
    endif; // meta_value ?>
    </select>
<?php }
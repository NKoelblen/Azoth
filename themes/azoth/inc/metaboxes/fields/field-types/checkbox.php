<?php
function option_children($field, $option, $meta_value) { ?>
    <ul style="margin-left: 18px;">
        <?php foreach($option['children'] as $child) : ?>
            <li><label for="<?= $child['id'] ?>" style="font-weight: normal">
                <input
                    type="checkbox"
                    id="<?= $child['id'] ?>"
                    name="<?= $child['id'] ?>"
                    value="<?= $child['id'] ?>"
                    style="width: 16px; display: inline-block;"
                    <?php if (isset($meta_value)) :
                        foreach($meta_value as $value) :
                            echo $value === $child['id'] ? 'checked' : '';
                        endforeach;
                    endif; ?>
                    <?= isset($field['required']) && $field['required'] ? 'required' : '' ?>
                >
                <?= $child['title'] ?>
                <?php if(isset($child['children'])) :
                    option_children($field, $child, $meta_value);
                endif; ?>
            </label></li>
        <?php endforeach; ?>
    </ul>
<?php }
function checkbox_field($field, $meta_value) { ?>
    <ul>
        <?php foreach ($field['options'] as $option) : ?>
            <li><label for="<?= $option['id'] ?>" style="font-weight: normal">
                <input
                    type="checkbox"
                    id="<?= $option['id'] ?>"
                    name="<?= $option['id'] ?>"
                    value="<?= $option['id'] ?>"
                    style="width: 16px; display: inline-block;"
                    <?php if (isset($meta_value)) :
                        foreach($meta_value as $value) :
                            echo $value === $option['value'] ? 'checked' : '';
                        endforeach;
                    endif; ?>
                    <?= isset($field['required']) && $field['required'] ? 'required' : '' ?>
                >
                <?= $option['title'] ?>
                <?php if(isset($option['children'])) :
                        option_children($field, $option, $meta_value);
                endif; ?>
            </label></li>
        <?php endforeach; // option ?>
    </ul>
<?php }
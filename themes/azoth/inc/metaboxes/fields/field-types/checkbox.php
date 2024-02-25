<?php
function option_children($field, $option, $meta_value)
{ ?>
    <input type="checkbox" id='<?= $option['id'] ?>' class="parent-checkbox" style="width: 16px; display: inline-block;">
    <label for='<?= $option['id'] ?>' style='font-weight: bold'>
        <?= $option['title'] ?>
    </label>
    <ul class="children-checkboxes" style="margin-left: 18px;">
        <?php foreach ($option['children'] as $child): ?>
            <li>
                <?php if (isset($child['children'])):
                    option_children($field, $child, $meta_value);
                else: ?>
                    <input type="checkbox" id='<?= $child['id'] ?>' name='<?= $field['id'] ?>[]' value='<?= $child['id'] ?>'
                        style="width: 16px; display: inline-block;" <?php if (isset($meta_value)):
                            if (is_array($meta_value)):
                                foreach ($meta_value as $value):
                                    echo $value === $child['id'] ? 'checked' : '';
                                endforeach;
                            else:
                                echo $meta_value === $child['id'] ? 'checked' : '';
                            endif;
                        endif; ?>             <?= isset($child['disabled']) && $child['disabled'] === 'disabled' ? 'disabled' : ''; ?>>
                    <label for='<?= $child['id'] ?>' style="font-weight: normal">
                        <?= $child['title'] ?>
                    </label>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php }
function checkbox_field($field, $meta_value)
{ ?>
    <ul>
        <?php foreach ($field['options'] as $option): ?>
            <li>
                <?php if (isset($option['children'])):
                    option_children($field, $option, $meta_value);
                else: ?>
                    <input type="checkbox" id='<?= $option['id'] ?>' name='<?= $field['id'] ?>[]' value='<?= $option['id'] ?>'
                        style="width: 16px; display: inline-block;" <?php if (isset($meta_value)):
                            if (is_array($meta_value)):
                                foreach ($meta_value as $value):
                                    echo $value === $option['id'] ? 'checked' : '';
                                endforeach;
                            else:
                                echo $meta_value === $option['id'] ? 'checked' : '';
                            endif;
                        endif; ?>             <?= isset($field['required']) && $field['required'] ? 'required' : '' ?>             <?= isset($option['disabled']) && $option['disabled'] === 'disabled' ? 'disabled' : ''; ?>>
                    <label for='<?= $option['id'] ?>' style="font-weight: normal">
                        <?= $option['title'] ?>
                    </label>
                <?php endif; ?>
            </li>
        <?php endforeach; // option  ?>
    </ul>
<?php }
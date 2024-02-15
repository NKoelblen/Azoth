<?php

function chekbox_children_values($post, $option, $meta_value) {
    if (isset($option['children'])) :
        foreach ($option['children'] as $child) :
            $meta_value[] = get_post_meta($post->ID, $child['id'], true);
            $meta_value = chekbox_children_values($post, $child, $meta_value);
        endforeach;
    endif;
    return $meta_value;
}

function fields_generator($post, $fields) {
    
    foreach ($fields as $group_of_fields) : ?>
        <!-- Form groups -->

        <fieldset id="<?= sanitize_title($group_of_fields['group_label']) ?>">
            <?php if ($group_of_fields['group_label']) : ?>
                <legend>
                    <h3>
                        <?= $group_of_fields['group_label'] ?>
                    </h3>
                </legend>
            <?php endif; // group_label ?>

            <!-- Fields -->

            <div class="<?= sanitize_title($group_of_fields['group_label']) ?>">

                <?php array_shift($group_of_fields); 
                
                foreach ($group_of_fields as $field) :
                    $display = isset($field['display']) ? 'style="display: ' . $field['display'] . '"' : '';
                    $disabled = isset($field['disabled']) ? $field['disabled'] : "";
                
                    /* Registered Meta values */

                    switch ($field['id']) {
                        case 'title':
                            $meta_value = isset($post->post_title) ? $post->post_title : '';
                            break;
                        case 'content':
                            $meta_value = isset($post->post_content) ? $post->post_content : '';
                            break;
                        case 'author':
                            $meta_value = isset($post->post_author) ? $post->post_author : '';
                            break;
                        case 'thumbnail':
                            $meta_value = get_post_thumbnail_id($post->ID);
                            break;
                        default:
                            $meta_value = get_post_meta($post->ID, $field['id'], true);    
                            if( $field['type'] === 'checkbox' ):
                                $meta_value = [];
                                foreach($field['options'] as $option) :
                                    $meta_value[] = get_post_meta($post->ID, $option['id'], true);
                                    $meta_value = chekbox_children_values($post, $option, $meta_value);
                                endforeach;
                            endif;
                    }
                    $meta_value = !$meta_value && isset($field['default']) ? $field['default'] : $meta_value; ?>
                    <!-- Field box -->
                    <div class="<?= $field['type'] . ' ' . $field['id'] ?>" <?= $display ?>;">

                        <!-- Label -->
                        <?php if (isset($field['label']) && $field['label'] !== "") : ?>
                            <label for="<?= $field['id'] ?>"><?= $field['label'] ?></label>
                        <?php endif; // label ?>

                        <!-- Field -->

                        <?php switch ($field['type']) {
                            case 'select':
                                select_field($field, $meta_value, $disabled);
                                break;
                            case 'WYSIWYG':
                                wysiwyg_field($field, $meta_value);
                                break;
                            case 'media-library-uploader':
                                media_library_uploader_field($field, $meta_value);
                                break;
                            case 'map':
                                map_field($field, $meta_value);
                                break;
                            case 'taxonomy':
                                taxonomy_field($field, $post);
                                break;
                            case 'radio':
                                radio_field($field, $meta_value);
                                break;
                            case 'checkbox':
                                checkbox_field($field, $meta_value);
                                break;
                            default:
                                input_field($field, $meta_value);
                        } ?>

                    </div>

                    <!-- Field box -->

                <?php endforeach; // field ?>
            
            </div>

        </fieldset>

    <?php endforeach; // groups

} // field_generator
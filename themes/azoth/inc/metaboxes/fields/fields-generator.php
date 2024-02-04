<?php
function fields_generator($post, $fields) {
    
    foreach ($fields as $group_of_fields) : ?>

        <!-- Form groups -->

        <fieldset style="margin-top: 10px; margin-bottom: 10px;">
            <?php if ($group_of_fields['group_label']) : ?>
                <legend>
                    <h3>
                        <?= $group_of_fields['group_label'] ?>
                    </h3>
                </legend>
            <?php endif; // group_label
            array_shift($group_of_fields);

            /* Fields */

            foreach ($group_of_fields as $field) :

                if (isset($field['width'])) :
                    $width = $field['width'];
                else :
                    $width = "100%";
                endif; // width

                if (isset($field['display'])) :
                    $display = $field['display'];
                else :
                    $display = "inline-block";
                endif; // width

                if (isset($field['disabled'])) :
                    $disabled = $field['disabled'];
                else :
                    $disabled = "";
                endif;
            
                /* Registered Meta values */
                if ($field['id'] === 'title') :
                    $meta_value = $post->post_title;
                elseif ($field['id'] === 'content'):
                    $meta_value = $post->post_content;
                elseif ($field['id'] === 'author'):
                    $meta_value = $post->post_author;
                elseif ($field['id'] === 'thumbnail'):
                    $meta_value = get_post_thumbnail_id($post->ID);
                else :
                    $meta_value = get_post_meta($post->ID, $field['id'], true);
                endif;
                if (!$meta_value && isset($field['default'])) :
                    $meta_value = $field['default'];
                endif; ?>

                <!-- Label + Field box -->
                <div style="display: <?= $display ?>; width: <?= $width ?>;">

                    <!-- Label -->
                    <?php if (isset($field['label']) && $field['label'] !== "") : ?>
                        <div style="margin-left: 5px; margin-right: 5px;">
                            <label for="<?= $field['id'] ?>">
                                <strong><?= $field['label'] ?></strong>
                            </label>
                        </div>
                    <?php endif; // label 
                    ?>

                    <!-- Field box -->
                    <div style="margin-left: 5px; margin-right: 5px;">

                        <?php if ($field['type'] === "select") :
                            select_field($field, $meta_value, $disabled);

                        elseif ($field['type'] === "WYSIWYG") :
                            wysiwyg_field($field, $meta_value);

                        elseif ($field['type'] === "media-library-uploader") :
                            media_library_uploader_field($field, $meta_value);

                        elseif ($field['type'] === "map") :
                            map_field($field, $meta_value);
                        
                        elseif ($field['type'] === "taxonomy") :
                            taxonomy_field($field, $post);

                        elseif ($field['type'] === "radio") :
                            radio_field($field, $meta_value);
                        
                        else :
                            input_field($field, $meta_value);    
                        endif; // type of fields ?>

                    </div> <!-- Field box -->

                </div> <!-- Label + Field box -->

            <?php endforeach; // field ?>

        </fieldset>
        <hr>

    <?php endforeach; // groups

} // field_generator
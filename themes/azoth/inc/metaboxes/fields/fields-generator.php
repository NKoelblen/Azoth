<?php
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

                    if (isset($field['width'])) :
                        $width = $field['width'];
                    else :
                        $width = "100%";
                    endif; // width

                    if (isset($field['display'])) :
                        $display = 'style="display: ' . $field['display'] . '"';
                    else :
                        $display = "";
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

                    <!-- Field box -->
                    <div class="<?= $field['type'] . ' ' . $field['id'] ?>" <?= $display ?>;">

                        <!-- Label -->
                        <?php if (isset($field['label']) && $field['label'] !== "") : ?>
                            <label for="<?= $field['id'] ?>"><?= $field['label'] ?></label>
                        <?php endif; // label 
                        ?>

                        <!-- Field -->

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

                    </div>

                    <!-- Field box -->

                <?php endforeach; // field ?>
            
            </div>

        </fieldset>

    <?php endforeach; // groups

} // field_generator
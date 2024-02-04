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
                $meta_value = get_post_meta($post->ID, $field['id'], true);
                if(!$meta_value && isset($field['default'])) :
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
                            if(isset($field['add']) && $field['add'] === true) : ?>
                                <div>
                                    <a href="#" class="add <?= $field['id'] ?>">Ajouter</a>
                                </div>
                                <div class="modal-outer <?= $field['id'] ?>" style="display: none; position: fixed; top: 0; left: 0; right: 0; z-index: 159900; height: 100vh; background-color: rgba(0, 0, 0, 0.7);">
                                    <div class="modal-inner" style="width: calc(100% - 60px); height: calc(100% - 60px); margin: 30px; background: #FFFFFF;">
                                        <button type="button" class="media-modal-close" style="position: fixed; top: 30px; right: 30px;">
                                            <span class="media-modal-icon">
                                                <span class="screen-reader-text">Fermez la boite de dialogue</span>
                                            </span>
                                        </button>
                                        <form>
                                            <button></button>
                                        </form>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php select_field($field, $meta_value, $disabled);

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

    post_submit_meta_box($post);

} // field_generator
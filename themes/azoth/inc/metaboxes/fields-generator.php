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

            /* Registered Meta values */
            $meta_value = get_post_meta($post->ID, $field['id'], true); ?>

            <!-- Label + Field box -->
            <div style="display: inline-block; width: <?= $width ?>">

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

                    <!-- Repeatable Fields -->
                    <?php if (isset($field['repeatable']) && $field['repeatable'] === true) : ?>
                        <table class="items-table">
                            <tbody>
                                <tr>
                                    <?php foreach ($field['repeatable-fields'] as $repeatable_field) : ?>
                                        <th>
                                            <?= $repeatable_field['label']; ?>
                                        </th>
                                    <?php endforeach; // repeatable_field 
                                    ?>
                                </tr>
                                <?php if ($meta_value) :
                                    array_multisort(
                                        array_column($meta_value, 'public'), SORT_ASC, 
                                        array_column($meta_value, 'date'), SORT_ASC,
                                        array_column($meta_value, 'heure'), SORT_ASC,
                                        $meta_value
                                    );
                                    $meta_value_type = [];
                                    foreach ($field['repeatable-fields'] as $repeatable_field) :
                                        $meta_value_type[] = $repeatable_field['type'];
                                    endforeach; // repeatable_field
                                    $meta_values = [];
                                    foreach ($meta_value as $item_values) :
                                        $values = [];
                                        foreach ($item_values as $item_key => $item_value) :
                                            $values[] = [
                                                'id' => $item_key,
                                                'value' => $item_value
                                            ];
                                        endforeach; // item_value
                                        $values_and_type = [];
                                        foreach ($values as $key => $value) :
                                            $values_and_type[] = $value + ['type' => $meta_value_type[$key]];
                                        endforeach; // value
                                        $meta_values[] = $values_and_type;
                                    endforeach; // item_values ?>
                                    <?php foreach ($meta_values as $item_key => $item_values) : ?>
                                        <tr class="sub-row">
                                            <?php foreach ($item_values as $item_value) : ?>
                                                <td>
                                                    <input 
                                                        type="<?= $item_value['type'] ?>"
                                                        name="<?= $field['id'] . '[' . $item_key . ']' . '[' . $item_value['id'] . ']'; ?>"
                                                        id="<?= $field['id'] . '[' . $item_key . ']' . '[' . $item_value['id'] . ']'; ?>"
                                                        value="<?= $item_value['value'] ?>"
                                                    >
                                                </td>
                                            <?php endforeach; // item_value ?>
                                            <td>
                                                <button class="remove-item button" type="button">Supprimer</button>
                                            </td> <!-- Used in /assets/js/metaboxes.js to remove the sub-row -->
                                        </tr>
                                    <?php endforeach; // item_values ?>
                                <?php else : // !metavalue ?>
                                    <tr class="sub-row">
                                        <?php foreach ($field['repeatable-fields'] as $repeatable_field) : ?>
                                            <td>
                                                <input
                                                    type="<?= $repeatable_field['type'] ?>"
                                                    name="<?= $field['id'] . '[0]' . '[' . $repeatable_field['id'] . ']'; ?>"
                                                    id="<?= $field['id'] . '[0]' . '[' . $repeatable_field['id'] . ']'; ?>"
                                                >
                                            </td>
                                        <?php endforeach; // repeatable_field ?>
                                        <td>
                                            <button class="remove-item button" type="button">Supprimer</button>
                                        </td> <!-- Used in /assets/js/metaboxes.js to remove the sub-row -->
                                    </tr>
                                <?php endif; // meta_value ?>
                                <tr class="hide-tr"> <!-- Used in /assets/js/metaboxes.js to append a new sub-row -->
                                    <?php foreach ($field['repeatable-fields'] as $repeatable_field) : ?>
                                        <td>
                                            <input
                                                type="<?= $repeatable_field['type'] ?>"
                                                name="hide_<?= $field['id'] . '[rand_no]' . '[' . $repeatable_field['id'] . ']' ?>"
                                                id="hide_<?= $field['id'] . '[rand_no]' . '[' . $repeatable_field['id'] . ']' ?>"
                                            >
                                        </td>
                                    <?php endforeach; // repeatable_field ?>
                                    <td>
                                        <button class="remove-item button" type="button">Supprimer</button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>
                                        <button class="add-item button button-secondary" type="button">Ajouter</button>
                                    </td> <!-- Used in /assets/js/metaboxes.js to append a new sub-row -->
                                </tr>
                            </tfoot>
                        </table>
                    <!-- Repeatable Fields
                        
                    Select -->
                    <?php elseif ($field['type'] === "select") :
                        if ((isset($field['add']) && $field['add'] === true) ||
                            (isset($field['modify']) && $field['modify'] === true) ||
                            (isset($field['remove']) && $field['remove'] === true)) : ?>
                            <div style="display: flex; gap: 10px;">
                                <?php if(isset($field['add']) && $field['add'] === true) : ?>
                                    <a href="#" class="add <?= $field['id'] ?>">Ajouter</a>
                                <?php endif; ?>
                                <?php if(isset($field['modify']) && $field['modify'] === true) : ?>
                                    <a href="#" class="modify <?= $field['id'] ?>">Modifier</a>
                                <?php endif; ?>
                                <?php if(isset($field['remove']) && $field['remove'] === true) : ?>
                                    <a href="#" class="remove <?= $field['id'] ?>">Supprimer</a>
                                <?php endif; ?>
                            </div>
                            <div class="modal-outer <?= $field['id'] ?>"
                                 style="display: none;
                                        position: fixed;
                                        top: 0;
                                        left: 0;
                                        right: 0;
                                        z-index: 159900;
                                        height: 100vh;
                                        background-color: rgba(0, 0, 0, 0.7);"
                            >
                                <div class="modal-inner"
                                     style="width: calc(100% - 60px);
                                            height: calc(100% - 60px);
                                            margin: 30px;
                                            background: #FFFFFF;"
                                >
                                    <button type="button"
                                            class="media-modal-close"
                                            style="position: fixed;
                                                   top: 30px;
                                                   right: 30px;"
                                    >
                                        <span class="media-modal-icon">
                                            <span class="screen-reader-text">Fermez la boite de dialogue</span>
                                        </span>
                                    </button>
                                    <form>
                                        <button></button>
                                    </form>
                                </div>
                            </div>
                        <?php endif;
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
                            >
                                <option value="<?= $selected ?>">
                                    <?= $field['options'][$selected_key]['title']; ?>
                                </option>
                                <?php unset($field['options'][$selected_key]);
                                foreach ($field['options'] as $option) : ?>
                                    <option value="<?= $option['id'] ?>">
                                        <?= $option['title'] ?>
                                    </option>
                                <?php endforeach; // option ?>
                                <option value=""></option>
                        <?php else : // !meta_value ?>
                            <select
                                id="<?= $field['id'] ?>"
                                name="<?= $field['id'] ?>"
                                style="width: 100%;"
                            >
                                <option value=""></option>
                                <?php foreach ($field['options'] as $option) : ?>
                                    <option value="<?= $option['id'] ?>">
                                        <?= $option['title'] ?>
                                    </option>
                                <?php endforeach; // option
                        endif; // meta_value ?>
                        </select>

                    <!-- Select

                    WYSIWYG -->
                    <?php elseif ($field['type'] === "WYSIWYG") :
                        ob_start();
                        wp_editor(
                            $meta_value,
                            $field['id'],
                            [
                                'media_buttons' => false,
                                'quicktags'     => false
                            ]
                        );
                        $input = ob_get_contents();
                        ob_end_clean();
                        echo $input; ?>
                    <!-- WYSIWYG

                    Media Library Uploader -->
                    <?php elseif ($field['type'] === "media-library-uploader") : ?>
                        <div class="preview_image">
                            <?php if($meta_value) :
                                echo wp_get_attachment_image( $meta_value, 'medium' );
                            endif ?>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <a href="#" class="upload_image_button">
                                <?php if($meta_value) :
                                    echo 'Modifier l\'image';
                                else :
                                    echo 'Ajouter une image';
                                endif; ?>
                            </a>
                            <a
                                href="#"
                                class="delete_image_button"
                                style="<?= $meta_value ? 'display: inline' : 'display: none'; ?>" 
                            >
                                Supprimer l'image
                            </a>
                        </div>
                        <input
                            id="<?= $field['id'] ?>"
                            name="<?= $field['id'] ?>"
                            type="hidden"
                            value="<?= $meta_value ?>"
                        >

                    <!-- Media Library Uploader

                    Map -->
                    <?php elseif ($field['type'] === "map") : ?>
                        <div
                            id="map"
                            class="leaflet-container leaflet-touch leaflet-retina leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom"
                            style="height: 444px">
                        </div>
                        <input
                            id="<?= $field['id'] ?>"
                            name="<?= $field['id'] ?>"
                            type="hidden"
                            value="<?= $meta_value ?>"
                            style="width: 50%;"
                        >
                    <!-- Map

                    Taxonomy -->
                    <?php elseif ($field['type'] === "taxonomy") :
                        $box[ 'args' ][ 'taxonomy' ] = $field['taxonomy'];
                        post_categories_meta_box($post, $box); ?>
                    <!-- Taxonomy
                    
                    Inputs -->
                    <?php else :
                        if(!$meta_value && array_key_exists('default', $field)) :
                            $meta_value = $field['default'];
                        endif; ?>
                        <input
                            id="<?= $field['id'] ?>"
                            name="<?= $field['id'] ?>"
                            type="<?= $field['type'] ?>"
                            value="<?= $meta_value ?>"
                            style="width: 100%;"
                        >
                    <?php endif; // type of fields ?>

                </div> <!-- Field box -->

            </div> <!-- Label + Field box -->

        <?php endforeach; // field ?>

    </fieldset>
    <hr>

<?php endforeach; // groups

} // field_generator
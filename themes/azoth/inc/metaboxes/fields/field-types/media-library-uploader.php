<?php
function media_library_uploader_field($field, $meta_value)
{ ?>
    <div class="preview_image">
        <?php echo $meta_value ? wp_get_attachment_image($meta_value, 'medium') : ''; ?>
    </div>
    <div class="buttons">
        <a href="#" class="upload_image_button">
            <?php echo $meta_value ? 'Modifier l\'image' : '+ Ajouter une image'; ?>
        </a>
        <a href="#" class="delete_image_button" style="<?= $meta_value ? 'display: inline' : 'display: none'; ?>">
            Supprimer l'image
        </a>
    </div>
    <input id="<?= $field['id'] ?>" name="<?= $field['id'] ?>" type="hidden" value="<?= $meta_value ?>"
        <?= isset($field['required']) && $field['required'] ? 'required' : '' ?>>
<?php }
;
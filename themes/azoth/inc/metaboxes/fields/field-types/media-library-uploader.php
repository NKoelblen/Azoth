<?php
function media_library_uploader_field($field, $meta_value) { ?>
    <div class="preview_image">
        <?php if($meta_value) :
            echo wp_get_attachment_image( $meta_value, 'medium' );
        endif ?>
    </div>
    <div class="buttons">
        <a href="#" class="upload_image_button">
            <?php if($meta_value) :
                echo 'Modifier l\'image';
            else :
                echo '+ Ajouter une image';
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
<?php };
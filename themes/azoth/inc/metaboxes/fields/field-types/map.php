<?php
function map_field($field, $meta_value)
{ ?>
    <div id="map"
        class="leaflet-container leaflet-touch leaflet-retina leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom <?= $field['id'] ?>">
    </div>
    <input id="<?= $field['id'] ?>" name="<?= $field['id'] ?>" type="hidden" value="<?= $meta_value ?>"
        <?= isset($field['required']) && $field['required'] ? 'required' : '' ?>>
<?php }
;
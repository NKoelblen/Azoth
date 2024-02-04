<?php
function map_field($field, $meta_value) { ?>
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
<?php };
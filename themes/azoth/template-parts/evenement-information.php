<?php
$informations = get_post_meta($post->ID, 'e_informations', true);
if ($informations): ?>
    <div>
        <p>Informations complémentaires : </p>
        <?= wpautop($informations); ?>
    </div>
<?php endif;
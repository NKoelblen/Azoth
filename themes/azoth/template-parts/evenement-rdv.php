<?php
$lieu = get_post_meta($post->ID, 'lieu', true);
$date_du = get_post_meta($post->ID, 'e_date_du', true);
$heure = get_post_meta($post->ID, 'e_heure', true);
$date_au = get_post_meta($post->ID, 'e_date_au', true); ?>
<p>
    <?php echo $lieu ? '<a href="' . get_the_permalink($lieu) . '">' . get_the_title($lieu) . '</a>, ' : '';
    echo $heure ? 'le ' : 'du';
    echo $date_du ? date_i18n( get_option( 'date_format' ), strtotime($date_du)) : '';
    echo $heure ? date_i18n( get_option( 'time_format' ), strtotime($heure)) : '';
    echo $date_au ? 'au ' . date_i18n( get_option( 'date_format' ), strtotime($date_au)) : ''; ?>
</p>
<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 */

/**
 * JSON Validation
 */

if (!function_exists('json_validate')) {
    /**
     * Validates a JSON string.
     * 
     * @param string $json The JSON string to validate.
     * @param int $depth Maximum depth. Must be greater than zero.
     * @param int $flags Bitmask of JSON decode options.
     * @return bool Returns true if the string is a valid JSON, otherwise false.
     */
    function json_validate($json, $depth = 512, $flags = 0)
    {
        if (!is_string($json)) {
            return false;
        }

        try {
            json_decode($json, false, $depth, $flags | JSON_THROW_ON_ERROR);
            return true;
        } catch (\JsonException $e) {
            return false;
        }
    }
}


/**
 * Define Constants
 */

define('AZOTH_DIR', trailingslashit(get_theme_file_path()));


/**
 * Include styles and scripts
 */
require_once AZOTH_DIR . 'inc/admin/admin-style-&-scripts.php';
require_once AZOTH_DIR . 'inc/front/style-&-scripts.php';


/**
 * Add Custom Post Types
 */

require_once AZOTH_DIR . 'inc/cpt/cpt-voies.php';
require_once AZOTH_DIR . 'inc/cpt/cpt-instructeurs.php';
require_once AZOTH_DIR . 'inc/cpt/cpt-lieux.php';
require_once AZOTH_DIR . 'inc/cpt/cpt-contacts.php';
require_once AZOTH_DIR . 'inc/cpt/cpt-conferences.php';
require_once AZOTH_DIR . 'inc/cpt/cpt-formations.php';
require_once AZOTH_DIR . 'inc/cpt/cpt-stages.php';


/**
 * Include Metaboxes
 */

/* Fields Generators */

require_once AZOTH_DIR . 'inc/metaboxes/fields/field-types/inputs.php';
require_once AZOTH_DIR . 'inc/metaboxes/fields/field-types/map.php';
require_once AZOTH_DIR . 'inc/metaboxes/fields/field-types/media-library-uploader.php';
require_once AZOTH_DIR . 'inc/metaboxes/fields/field-types/radio.php';
require_once AZOTH_DIR . 'inc/metaboxes/fields/field-types/checkbox.php';
require_once AZOTH_DIR . 'inc/metaboxes/fields/field-types/select.php';
require_once AZOTH_DIR . 'inc/metaboxes/fields/field-types/taxonomy.php';
require_once AZOTH_DIR . 'inc/metaboxes/fields/field-types/wysiwyg.php';

require_once AZOTH_DIR . 'inc/metaboxes/fields/fields-generator.php';

/* Add Metaboxes */

require_once AZOTH_DIR . 'inc/metaboxes/mb-generator.php';

require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/mb-voies.php';
require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/mb-instructeurs.php';
require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/mb-lieux.php';
require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/mb-contacts.php';

require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/fields-evenements.php';

require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/mb-conferences.php';
require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/mb-formations.php';
require_once AZOTH_DIR . 'inc/metaboxes/single-metaboxes/mb-stages.php';

require_once AZOTH_DIR . 'inc/metaboxes/quick-add-post.php';


/**
 * Add taxonomies
 */
require_once AZOTH_DIR . 'inc/taxonomies.php';


/**
 * Include Newsletter
 */
require_once AZOTH_DIR . 'inc/newsletter/cpt-subscribers.php';
require_once AZOTH_DIR . 'inc/newsletter/mb-subscribers.php';
require_once AZOTH_DIR . 'inc/newsletter/SMTP.php';
require_once AZOTH_DIR . 'inc/newsletter/subscription.php';
require_once AZOTH_DIR . 'inc/newsletter/newsletter.php';


/**
 * Include admin functionalities
 */

require_once AZOTH_DIR . 'inc/admin/support.php';
require_once AZOTH_DIR . 'inc/admin/roles.php';
require_once AZOTH_DIR . 'inc/admin/dashboard.php';
require_once AZOTH_DIR . 'inc/admin/admin-menu.php';
require_once AZOTH_DIR . 'inc/admin/admin-bar.php';
require_once AZOTH_DIR . 'inc/admin/admin-columns.php';
require_once AZOTH_DIR . 'inc/admin/admin-filters.php';
require_once AZOTH_DIR . 'inc/admin/editor.php';


/**
 * Include front functionnalities
 */
require_once AZOTH_DIR . 'inc/front/menus.php';
require_once AZOTH_DIR . 'inc/front/widget-areas.php';


require_once AZOTH_DIR . 'test.php';
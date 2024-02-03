<?php
/**
 * Metabox Generator, used by :
 *  single-metaboxes/mb_contacts.php
 *  single-metaboxes/mb_evenements.php
 *  single-metaboxes/mb_instructeurs.php
 *  single-metaboxes/mb_lieux.php
 *  single-metaboxes/mb_voies.php
 */

class metaboxGenerator
{

    public function __construct() {
        add_action('add_meta_boxes', [$this, 'add']);
        add_action('save_post', [$this, 'save_fields']);
    } // End of __construct


    /* Post-types where the metabox will be generate */

    private $screens;

    /**
     *** How to use : ***
     * method set_screens($post_types) :
     *   $post_types = array of post-types
     */
    public function set_screens($new_screens) {
        $this->screens = $new_screens;
    } // End of set_screens

    /* Post-types where the metabox will be generate */

    private $labels;

    /**
     *** How to use : ***
     * method set_labels($labels) :
     *   $labels = array of 2 labels : slug && name
     */
    public function set_labels($new_labels) {
        $this->labels = $new_labels;
    } // End of set_screens


    /* Add Metabox to Post-types */

    public function add() {
        foreach ($this->screens as $screen) :
            add_meta_box(
                $this->labels['slug'],
                __($this->labels['name']),
                [$this, 'callback'],
                $screen,
                'advanced',
                'default'
            );
        endforeach; // Endforeach screen
    } // End of add

    public function callback($post) {
        wp_nonce_field('metaboxGenerator_data', 'metaboxGenerator_nonce');
        fields_generator($post, $this->fields);
    } // End of callback


    /* Form fields */

    private $fields;

    /**
     *** How tu use : ***
     * method set_fields($groups_of_fields) :
     *   $groups_of_fields = array of...
     *       each $group_of_fields = array
     *           beggin with 'group_label' => string (required, can be empty)
     *           continue with...
     *               each $field = array of $arguments used to generate the field in mb_generator
     *                   $arguments :
     *                       'label' => string
     *                       'id' => string
     *                       'type' => string (text | select | date | time | url | WYSIWYG)
     *                       'options' => array of... (required for 'type' => 'select')
     *                           $options = array of...
     *                               each $option = ['value' => string, 'label' => string]
     *                       'width' => string (width of the label and the field)
     *                       'repeatable' => bool
     *                       'repeatable-fields' => array of...
     *                           $repeatable fields = array...
     *                               each $repeatable_field = array of...
     *                                   $arguments :
     *                                       'label' => string
     *                                       'id' => string
     *                                       'type' => string (text | date | time)
     */
    public function set_fields($new_fields) {
        $this->fields = $new_fields;
    } // set_fields 

    /* Save fields */

    public function save_fields($post_id) {
        // $post_id = get_the_id();

        if (!isset($_POST['metaboxGenerator_nonce'])) :
            return $post_id;
        endif; // !isset metaboxGenerator_nonce

        $nonce = $_POST['metaboxGenerator_nonce'];
        if (!wp_verify_nonce($nonce, 'metaboxGenerator_data')) :
            return $post_id;
        endif; // nonce

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) :
            return $post_id;
        endif; // defined DOING_AUTOSAVE

        foreach ($this->fields as $group_of_fields) :

            array_shift($group_of_fields);
            foreach ($group_of_fields as $field) :

                if (isset($_POST[$field['id']])) :
                    update_post_meta($post_id, $field['id'], $_POST[$field['id']]);
                endif; // isset field id

            endforeach; // field

        endforeach; // group_of_fields

        $thumbnail = get_post_meta($post_id, 'thumbnail', true);
        if($thumbnail) :
            set_post_thumbnail($post_id, $thumbnail);
        endif;

        $title = get_post_meta($post_id, 'title', true);
        $content = get_post_meta($post_id, 'content', true);
        if(!$title && !$content) :
            return $post_id;
        endif;

	    if ($title) :
	    	$post_title = $title ;
	    	$post_name = sanitize_title($post_title );
        else :
            $post_title = get_the_title($post_id);
	    endif ;

        $post_content = "";
        if ($content) :
	    	$post_content = $content ;
        elseif (get_the_content($post_id)) :
            $post_content = get_the_content($post_id);
	    endif ;

        remove_action('save_post', [$this, 'save_fields']);
        wp_update_post(
            [ 
                'ID'            => $post_id,
                'post_title'    => $post_title,
                'post_name'     => $post_name,
                // 'post_content'  => $post_content
            ]
        );
        add_action('save_post', [$this, 'save_fields']);

    } // save_fields

} // metaboxGenerator
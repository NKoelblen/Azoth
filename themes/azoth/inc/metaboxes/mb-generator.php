<?php
/**
 * Metabox Generator, used by :
 *  single-metaboxes/mb_contacts.php
 *  single-metaboxes/mb_evenements.php
 *  single-metaboxes/mb_instructeurs.php
 *  single-metaboxes/mb_lieux.php
 *  single-metaboxes/mb_voies.php
 */

function update_chekbox_children($post_id, $option) {
    if (isset($option['children'])) :
        foreach ($option['children'] as $child) :
            if (isset($_POST[$child['id']])) :
                update_post_meta($post_id, $child['id'], $_POST[$child['id']]);
            else :
                delete_post_meta($post_id, $child['id'], $_POST[$child['id']]);
            endif;
            update_chekbox_children($post_id, $child);
        endforeach;
    endif;
}

class metaboxGenerator
{

    public function __construct() {
        add_action('add_meta_boxes', [$this, 'add']);
        add_action('save_post', [$this, 'save_fields']);
        add_action('save_post', [$this, 'save_title']);
        add_action('save_post', [$this, 'save_content']);
        add_action('save_post', [$this, 'save_author']);
    
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

    private $args;

    /**
     *** How to use : ***
     * method set_labels($labels) :
     *   $labels = array of 2 labels : slug && name
     */
    public function set_args($new_args) {
        $this->args = $new_args;
    } // End of set_screens


    /* Add Metabox to Post-types */

    public function add() {
        foreach ($this->screens as $screen) :
            add_meta_box(
                $this->args['id'],
                __($this->args['title']),
                [$this, 'callback'],
                $screen,
                $this->args['context'],
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

    public function save_title($post_id) {
        $title = get_post_meta($post_id, 'title', true);
        if(!$title) :
            return;
        else :
            $post_title = $title ;
            $post_name = sanitize_title($post_title );
        endif ;
        remove_action('save_post', [$this, 'save_title']);
        wp_update_post(
            [ 
                'ID'            => $post_id,
                'post_title'    => $post_title,
            ]
        );
    }

    public function save_content($post_id) {
        $content = get_post_meta($post_id, 'content', true);
        if(!$content) :
            return;
        else :
            $post_content = $content ;
        endif ;
        remove_action('save_post', [$this, 'save_content']);
        wp_update_post(
            [ 
                'ID'            => $post_id,
                'post_content'    => $post_content,
            ]
        );
    }

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

                if($field['type'] === 'checkbox') :
                    foreach($field['options'] as $option) :
                        if (isset($_POST[$option['id']])) :
                            update_post_meta($post_id, $option['id'], $_POST[$option['id']]);
                        else :
                            delete_post_meta($post_id, $option['id'], $_POST[$option['id']]);
                        endif;
                        update_chekbox_children($post_id, $option);
                    endforeach;
                endif;

                if (isset($_POST[$field['id']])) :
                    update_post_meta($post_id, $field['id'], $_POST[$field['id']]);
                endif; // isset field id

            endforeach; // field

        endforeach; // group_of_fields

        $thumbnail = get_post_meta($post_id, 'thumbnail', true);
        if($thumbnail) :
            set_post_thumbnail($post_id, $thumbnail);
        endif;

    } // save_fields

    public function save_author($post_id) {
        $author = get_post_meta($post_id, 'author', true);
        if(!$author) :
            return;
        else :
            $post_author = $author ;
        endif ;
        remove_action('save_post', [$this, 'save_author']);
        wp_update_post(
            [ 
                'ID'            => $post_id,
                'post_author'    => $post_author,
            ]
        );
    }

} // metaboxGenerator
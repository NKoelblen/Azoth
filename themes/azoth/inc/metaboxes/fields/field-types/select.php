<?php
function select_field($field, $meta_value) { ?>
    <select
        id="<?= $field['id'] ?>"
        name="<?= $field['id'] ?>"
        <?= isset($field['disabled']) && $field['disabled'] === 'disabled' ? 'disabled' : ''; ?>
        <?= isset($field['required']) && $field['required'] ? 'required' : '' ?>
    >
    <?php if ($meta_value) :
        $selected  = isset($meta_value) ? $meta_value : '';
        $selected_key = array_search(
            $selected,
            array_column($field['options'], 'id')
        ); ?>
            <option value="<?= $selected ?>">
                <?= $field['options'][$selected_key]['title']; ?>
            </option>
            <option value=""></option>
            <?php unset($field['options'][$selected_key]);
            foreach ($field['options'] as $option) : ?>
                <option value="<?= $option['id'] ?>">
                    <?= $option['title'] ?>
                </option>
            <?php endforeach; // option 
    else : // !meta_value ?>
            <option value=""></option>
            <?php foreach ($field['options'] as $option) : ?>
                <option value="<?= $option['id'] ?>">
                    <?= $option['title'] ?>
                </option>
            <?php endforeach; // option
    endif; // meta_value ?>
    </select>
    <?php if(isset($field['add'])) : ?>
        <a class="taxonomy-add-new add <?= $field['id'] ?>"><?= $field['add']; ?></a>
        <div class="modal-outer <?= $field['id'] ?>">
            <div class="modal-inner">
                <button type="button" class="media-modal-close">
                    <span class="media-modal-icon">
                        <span class="screen-reader-text">Fermez la boite de dialogue</span>
                    </span>
                </button>

                <?php $inner_post_type = $field['id'];
                $call = $inner_post_type . '_fields';
                $inner_fields = $call();
                $inner_post = new stdClass();
                $inner_post->ID = -99;
                $inner_post->post_type = $inner_post_type;
                $inner_post->filter = 'raw'; ?>

                <div id="titlediv">
                    <div id="titlewrap">
                        <input type="text" name="title" size="30" value="" class="title" spellcheck="true" autocomplete="off" placeholder="Intitulé">
                    </div>
                </div>

                <?php fields_generator($inner_post, $inner_fields); ?>

                <a class="quick-add-post button button-primary button-large"
                    data-ajaxurl='<?= admin_url('admin-ajax.php'); ?>'
        		    data-nonce='<?= wp_create_nonce('quick_add_post'); ?>'
        		    data-action='quick_add_post'
                    data-post-type='<?= $inner_post_type ?>'
                >
                    Publier
                </a>

            </div>
        </div>
    <?php endif;
}
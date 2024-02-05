<?php
function select_field($field, $meta_value, $disabled) {
    if ($meta_value) :
        $selected  = isset($meta_value) ? $meta_value : '';
        $selected_key = array_search(
            $selected,
            array_column($field['options'], 'id')
        ); ?>
        <select
            id="<?= $field['id'] ?>"
            name="<?= $field['id'] ?>"
            style="width: 100%;"
            <?= $disabled ?>
        >
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
        <select
            id="<?= $field['id'] ?>"
            name="<?= $field['id'] ?>"
            style="width: 100%;"
            <?= $disabled ?>
        >
            <option value=""></option>
            <?php foreach ($field['options'] as $option) : ?>
                <option value="<?= $option['id'] ?>">
                    <?= $option['title'] ?>
                </option>
            <?php endforeach; // option
    endif; // meta_value ?>
    </select>
    <?php if(isset($field['add'])) : ?>
        <div>
            <a class="taxonomy-add-new add <?= $field['id'] ?>"><?= $field['add']; ?></a>
        </div>
        <div class="modal-outer <?= $field['id'] ?>" style="display: none; position: fixed; top: 0; left: 0; right: 0; z-index: 159900; height: 100vh; background-color: rgba(0, 0, 0, 0.7);">
            <div class="modal-inner" style="width: calc(100% - 92px); max-height: calc(100% - 92px); margin: 30px; padding: 16px; background: #FFFFFF; overflow-y: auto;">
                <button type="button" class="media-modal-close" style="position: fixed; top: 30px; right: 30px;">
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
                        <label class="" id="title-prompt-text" for="title">Saisissez le titre</label>
                        <input type="text" name="title" size="30" value="" id="title" spellcheck="true" autocomplete="off">
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
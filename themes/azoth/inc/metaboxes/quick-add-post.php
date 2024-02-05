<?php
add_action('wp_ajax_quick_add_post', 'quick_add_post');
add_action('wp_ajax_nopriv_quick_add_post', 'quick_add_post');
function quick_add_post() {
  
	// Vérification de sécurité
  	if(!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'quick_add_post')) :
    	wp_send_json_error('Vous n’avez pas l’autorisation d’effectuer cette action.', 403);
        return;
    endif;

    if($_POST['title']) :
        $inner_post_title = $_POST['title'];
    else :
        $inner_post_title = "Brouillon auto";
    endif;
    if($_POST['content']) :
        $inner_post_content = $_POST['content'];
    else :
        $inner_post_content = "";
    endif;

    $inner_post = [
        'post_title'    => $inner_post_title,
        'post_content'  => $inner_post_content,
        'post_author'   => wp_get_current_user()->ID,
        'post_status'   => 'publish',
        'post_type' 	=> $_POST['post_type']
    ];

    if($_POST["tax_input"]) :
        foreach($_POST["tax_input"] as $inner_post_tax => $inner_post_terms) :
            $inner_post['tax_input'][$inner_post_tax] = $inner_post_terms;
        endforeach;
    endif;

    foreach($_POST as $key => $field) :
        if ($field !== $_POST['action'] &&
            $field !== $_POST['nonce'] && 
            $field !== $_POST['title'] &&
            $field !== $_POST['content'] &&
            $field !== $_POST['post_type'] &&
            $field !== $_POST['thumbnail'] &&
            $field !== $_POST['tax_input']) :

            $inner_post['meta_input'][$key] = $field;

        endif;
    endforeach;

    $inner_post_id = wp_insert_post($inner_post);

    if($_POST['thumbnail']) :
        set_post_thumbnail($inner_post_id, $_POST['thumbnail']);
    endif;

    ob_start() ?>
    <option value="<?= $inner_post_id ?>"><?= $inner_post_title ?></option>
    <?php wp_send_json_success(['html' => ob_get_clean(), 'value' => $inner_post_id]);
}
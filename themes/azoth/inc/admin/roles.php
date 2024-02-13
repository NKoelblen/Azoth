<?php
add_action('admin_init', 'add_azoth_caps');
function add_azoth_caps() {
	$role = get_role('administrator');
    $caps = [
        'edit_voies',
        'delete_voies',
        'publish_voies',
        'edit_published_voies',
        'delete_published_voies',
        'edit_others_voies',
        'delete_others_voies',
        'read_private_voies',
        'edit_private_voies',
        'delete_private_voies',
        'edit_instructeurs',
        'delete_instructeurs',
        'publish_instructeurs',
        'edit_published_instructeurs',
        'delete_published_instructeurs',
        'edit_others_instructeurs',
        'delete_others_instructeurs',
        'read_private_instructeurs',
        'edit_private_instructeurs',
        'delete_private_instructeurs',
        'edit_lieux',
        'delete_lieux',
        'publish_lieux',
        'edit_published_lieux',
        'delete_published_lieux',
        'edit_others_lieux',
        'delete_others_lieux',
        'read_private_lieux',
        'edit_private_lieux',
        'delete_private_lieux',
        'edit_contacts',
        'delete_contacts',
        'publish_contacts',
        'edit_published_contacts',
        'delete_published_contacts',
        'edit_others_contacts',
        'delete_others_contacts',
        'read_private_contacts',
        'edit_private_contacts',
        'delete_private_contacts',
        'edit_evenements',
        'delete_evenements', 
        'publish_evenements',
        'edit_published_evenements',
        'delete_published_evenements',
        'edit_others_evenements',
        'delete_others_evenements',
        'read_private_evenements',
        'edit_private_evenements',
        'delete_private_evenements',
    ];
    foreach ($caps as $cap) :
	    $role->add_cap($cap); 
    endforeach;
}

add_role(
	'instructeur',
	'Instructeur',
    [
        'edit_voies'                => false,
        'delete_voies'              => false,
    
        'publish_voies'             => false,
        'edit_published_voies'      => false,
        'delete_published_voies'    => false,
    
        'edit_others_voies'         => false,
        'delete_others_voies'       => false,
        'read_private_voies'        => false,
        'edit_private_voies'        => false,
        'delete_private_voies'      => false,
    
        'edit_instructeurs'         => true,
        'delete_instructeurs'       => false,
    
        'publish_instructeurs'      => false,
        'edit_published_instructeurs' => true,
        'delete_published_instructeurs' => false,
    
        'edit_others_instructeurs'  => false,
        'delete_others_instructeurs' => false,
        'read_private_instructeurs' => false,
        'edit_private_instructeurs' => false,
        'delete_private_instructeurs' => false,
    
        'edit_lieux'                => true,
        'delete_lieux'              => true,
    
        'publish_lieux'             => true,
        'edit_published_lieux'      => true,
        'delete_published_lieux'    => false,
    
        'edit_others_lieux'         => true,
        'delete_others_lieux'       => false,
        'read_private_lieux'        => false,
        'edit_private_lieux'        => false,
        'delete_private_lieux'      => false,
    
        'edit_contacts'             => true,
        'delete_contacts'           => true,
    
        'publish_contacts'          => true,
        'edit_published_contacts'   => true,
        'delete_published_contacts' => false,
    
        'edit_others_contacts'      => true,
        'delete_others_contacts'    => false,
        'read_private_contacts'     => false,
        'edit_private_contacts'     => false,
        'delete_private_contacts'   => false,
    
        'edit_evenements'          => true,
        'delete_evenements'        => true,
    
        'publish_evenements'       => true,
        'edit_published_evenements' => true,
        'delete_published_evenements' => true,
    
        'edit_others_evenements'   => false,
        'delete_others_evenements' => false,
        'read_private_evenements'  => false,
        'edit_private_evenements'  => false,
        'delete_private_evenements' => false,
    
        'update_core'               => false,
        'delete_site'               => false,
        'edit_files'                => false,
        'manage_options'            => false,
        'customize'                 => false,
        'edit_dashboard'            => false,
    
        'list_users'                => false,
        'create_users'              => false,
        'edit_users'                => false,
        'promote_users'             => false,
        'remove_users'              => false,
        'delete_users'              => false,
    
        'install_themes'            => false,
        'switch_themes'             => false,
        'edit_theme_options'        => false,
        'edit_themes'               => false,
        'update_themes'             => false,
        'delete_themes'             => false,
    
        'install_plugins'           => false,
        'activate_plugins'          => false,
        'edit_plugins'              => false,
        'update_plugins'            => false,
        'delete_plugins'            => false,
    
        'export'                    => false,
        'import'                    => false,
    
        'moderate_comments'         => false,
    
        'manage_categories'         => false,
    
        'edit_others_posts'         => false,
        'delete_others_posts'       => false,
        'read_private_posts'        => false,
        'edit_private_posts'        => false,
        'delete_private_posts'      => false,
    
        'edit_pages'                => false,
        'publish_pages'             => false,
        'delete_pages'              => false,
        'edit_published_pages'      => false,
        'delete_published_pages'    => false,
        'edit_others_pages'         => false,
        'delete_others_pages'       => false,
        'read_private_pages'        => false,
        'edit_private_pages'        => false,
        'delete_private_pages'      => false,
    
        'unfiltered_html'           => false,
    
        'upload_files'              => true,
    
        'publish_posts'             => false,
        'edit_published_posts'      => false,
        'delete_published_posts'    => false,
    
        'edit_posts'                => false,
        'delete_posts'              => false,
    
        'read'                      => true,
    ]
);

add_role(
	'gestionnaire',
	'Gestionnaire',
    [
        'edit_voies'                => true,
        'delete_voies'              => false,
        'publish_voies'             => true,
        'edit_published_voies'      => true,
        'delete_published_voies'    => false,
        'edit_others_voies'         => true,
        'delete_others_voies'       => false,
        'read_private_voies'        => false,
        'edit_private_voies'        => false,
        'delete_private_voies'      => false,
    
        'edit_instructeurs'         => true,
        'delete_instructeurs'       => true,
        'publish_instructeurs'      => true,
        'edit_published_instructeurs' => true,
        'delete_published_instructeurs' => true,
        'edit_others_instructeurs'  => true,
        'delete_others_instructeurs' => true,
        'read_private_instructeurs' => false,
        'edit_private_instructeurs' => false,
        'delete_private_instructeurs' => false,
    
        'edit_lieux'                => true,
        'delete_lieux'              => true,
        'publish_lieux'             => true,
        'edit_published_lieux'      => true,
        'delete_published_lieux'    => true,
        'edit_others_lieux'         => true,
        'delete_others_lieux'       => true,
        'read_private_lieux'        => false,
        'edit_private_lieux'        => false,
        'delete_private_lieux'      => false,
    
        'edit_contacts'             => true,
        'delete_contacts'           => true,
        'publish_contacts'          => true,
        'edit_published_contacts'   => true,
        'delete_published_contacts' => true,
        'edit_others_contacts'      => true,
        'delete_others_contacts'    => true,
        'read_private_contacts'     => false,
        'edit_private_contacts'     => false,
        'delete_private_contacts'   => false,
    
        'edit_evenements'          => true,
        'delete_evenements'        => true,
        'publish_evenements'       => true,
        'edit_published_evenements' => true,
        'delete_published_evenements' => true,
        'edit_others_evenements'   => true,
        'delete_others_evenements' => true,
        'read_private_evenements'  => false,
        'edit_private_evenements'  => false,
        'delete_private_evenements' => false,
        
        'update_core'               => false,
        'delete_site'               => false,
        'edit_files'                => false,
        'manage_options'            => false,
        'customize'                 => false,
        'edit_dashboard'            => false,
    
        'list_users'                => true,
        'create_users'              => true,
        'edit_users'                => true,
        'promote_users'             => true,
        'remove_users'              => true,
        'delete_users'              => true,
    
        'install_themes'            => false,
        'switch_themes'             => false,
        'edit_theme_options'        => false,
        'edit_themes'               => false,
        'update_themes'             => false,
        'delete_themes'             => false,
    
        'install_plugins'           => false,
        'activate_plugins'          => false,
        'edit_plugins'              => false,
        'update_plugins'            => false,
        'delete_plugins'            => false,
    
        'export'                    => false,
        'import'                    => false,
    
        'moderate_comments'         => false,
    
        'manage_categories'         => true,
    
        'edit_others_posts'         => true,
        'delete_others_posts'       => true,
        'read_private_posts'        => true,
        'edit_private_posts'        => true,
        'delete_private_posts'      => true,
    
        'edit_pages'                => true,
        'publish_pages'             => true,
        'delete_pages'              => true,
        'edit_published_pages'      => true,
        'delete_published_pages'    => false,
        'edit_others_pages'         => true,
        'delete_others_pages'       => false,
        'read_private_pages'        => true,
        'edit_private_pages'        => false,
        'delete_private_pages'      => false,
    
        'unfiltered_html'           => false,
    
        'upload_files'              => true,
    
        'publish_posts'             => true,
        'edit_published_posts'      => true,
        'delete_published_posts'    => true,
    
        'edit_posts'                => true,
        'delete_posts'              => true,
    
        'read'                      => true,
    ]
);
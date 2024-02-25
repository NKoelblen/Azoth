<?php
/* Remove dashboard widgets */
add_action('wp_dashboard_setup', 'wpdocs_remove_dashboard_widgets');
function wpdocs_remove_dashboard_widgets()
{
	$meta_boxes = [
		[
			'id' => 'dashboard_right_now', // Right Now
			'context' => 'normal'
		],
		[
			'id' => 'dashboard_recent_comments', // Recent Comments
			'context' => 'normal'
		],
		[
			'id' => 'dashboard_incoming_links', // Incoming Links
			'context' => 'normal'
		],
		[
			'id' => 'dashboard_plugins', // Plugins
			'context' => 'normal'
		],
		[
			'id' => 'dashboard_quick_press',// Quick Press
			'context' => 'side'
		],
		[
			'id' => 'dashboard_recent_drafts', // Recent Drafts
			'context' => 'side'
		],
		[
			'id' => 'dashboard_primary', // WordPress blog
			'context' => 'side'
		],
		[
			'id' => 'dashboard_secondary', // Other WordPress News
			'context' => 'side'
		],
		[
			'id' => 'dashboard_activity',
			'context' => 'normal'
		],
		[
			'id' => 'wpseo-wincher-dashboard-overview',
			'context' => 'normal'
		],
		[
			'id' => 'wpseo-dashboard-overview',
			'context' => 'normal'
		],
	];
	foreach ($meta_boxes as $meta_box):
		remove_meta_box($meta_box['id'], 'dashboard', $meta_box['context']);   // Right Now
	endforeach;
	remove_action('welcome_panel', 'wp_welcome_panel');	// use 'dashboard-network' as the second parameter to remove widgets from a network dashboard.
}
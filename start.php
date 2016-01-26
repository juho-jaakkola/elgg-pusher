<?php

/**
 * Initialize th plugin
 */
elgg_register_event_handler('init', 'system', function() {
	elgg_register_simplecache_view('pusher/settings.js');

	elgg_register_plugin_hook_handler('action', 'plugins/settings/save', function($hook, $type, $return, $params) {
		if (get_input('plugin_id') == 'pusher') {
			$link = elgg_view('output/url', array(
				'href' => 'action/admin/site/flush_cache',
				'text' => elgg_echo('pusher:settings:notice:link'),
				'is_action' => true,
			));

			elgg_add_admin_notice('pusher', elgg_echo('pusher:settings:notice', array($link)));
		}
	});
});

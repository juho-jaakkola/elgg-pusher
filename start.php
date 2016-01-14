<?php

/**
 * Initialize th plugin
 */
elgg_register_event_handler('init', 'system', function() {
	elgg_register_simplecache_view('pusher/settings.js');
});

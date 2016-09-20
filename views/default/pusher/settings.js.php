<?php
/**
 * Provides plugin settings as an AMD module
 */

$settings = elgg_get_plugin_from_id('pusher')->getAllSettings();
if (empty($settings['public_port'])) {
	$settings['public_port'] = elgg_extract('private_port', $settings);
}

$settings = array(
    'scheme' => elgg_extract('scheme', $settings),
    'port' => elgg_extract('public_port', $settings),
);
?>
define(<?php echo json_encode($settings); ?>);

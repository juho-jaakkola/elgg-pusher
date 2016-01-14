<?php
/**
 * Provides plugin settings as an AMD module
 */

$settings = elgg_get_plugin_from_id('pusher')->getAllSettings();
$settings = array(
    'scheme' => elgg_extract('scheme', $settings),
    'port' => elgg_extract('port', $settings),
);
?>
define(<?php echo json_encode($settings); ?>);
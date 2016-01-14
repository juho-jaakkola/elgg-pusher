<?php
/**
 * Plugin settings form
 */

$plugin = elgg_extract('entity', $vars);

$port_label = elgg_echo('pusher:settings:port:label');
$port_input = elgg_view('input/text', array(
	'name' => 'params[port]',
	'value' => $plugin->port,
));

$scheme_label = elgg_echo('pusher:settings:scheme:label');
$scheme_input = elgg_view('input/radio', array(
	'name' => 'params[scheme]',
	'value' => $plugin->scheme,
	'options' => array(
		elgg_echo('pusher:settings:scheme:secure') => 'wss://',
		elgg_echo('pusher:settings:scheme:insecure') => 'ws://',
	),
));
$scheme_desc = elgg_echo('pusher:settings:scheme:desc');

echo <<<FORM
	<div>
		<label>$port_label</label>
		$port_input
		<p class="elgg-help-text"></p>
	</div>
	<div>
		<label>$scheme_label</label>
		$scheme_input
		<p class="elgg-text-help">$scheme_desc</p>
	</div>
FORM;

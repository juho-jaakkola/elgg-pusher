<?php
/**
 * Plugin settings form
 */

$plugin = elgg_extract('entity', $vars);
/* @var ElggPlugin $plugin */

$private_port_label = elgg_echo('pusher:settings:private_port:label');
$private_port_input = elgg_view('input/text', array(
	'name' => 'params[private_port]',
	'value' => $plugin->getSetting('private_port', '8099'),
	'required' => true,
));
$private_port_desc = elgg_echo('pusher:settings:private_port:desc');

$public_port_label = elgg_echo('pusher:settings:public_port:label');
$public_port_input = elgg_view('input/text', array(
	'name' => 'params[public_port]',
	'value' => $plugin->getSetting('public_port'),
));
$public_port_desc = elgg_echo('pusher:settings:public_port:desc');

$scheme_label = elgg_echo('pusher:settings:scheme:label');
$scheme_input = elgg_view('input/radio', array(
	'name' => 'params[scheme]',
	'value' => $plugin->getSetting('scheme'),
	'options' => array(
		elgg_echo('pusher:settings:scheme:secure') => 'wss://',
		elgg_echo('pusher:settings:scheme:insecure') => 'ws://',
	),
));
$scheme_desc = elgg_echo('pusher:settings:scheme:desc');

echo <<<FORM
	<div>
		<label>$private_port_label</label>
		$private_port_input
		<p class="elgg-text-help">$private_port_desc</p>
	</div>
	<div>
		<label>$public_port_label</label>
		$public_port_input
		<p class="elgg-text-help">$public_port_desc</p>
	</div>
	<div>
		<label>$scheme_label</label>
		$scheme_input
		<p class="elgg-text-help">$scheme_desc</p>
	</div>
FORM;

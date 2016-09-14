<?php

return array(
	'pusher:settings:private_port:label' => 'Internal Web socket port',
	'pusher:settings:private_port:desc' => 'The port to which the push server will listen for web socket connections.',

	'pusher:settings:public_port:label' => 'Public web socket port',
	'pusher:settings:public_port:desc' => 'Leave empty if your web socket port is public. If you are using a proxy to tunnel traffic, enter the external port clients must use.',

	'pusher:settings:scheme:label' => 'URI scheme',
	'pusher:settings:scheme:insecure' => 'ws:// (insecure)',
	'pusher:settings:scheme:secure' => 'wss:// (secure)',
	'pusher:settings:scheme:desc' => 'Warning: insecure connection should be used only on development servers.',
	'pusher:settings:notice' => 'If you modified the push server settings, you need to %s and then restart the push server.',
	'pusher:settings:notice:link' => 'flush the caches',
);

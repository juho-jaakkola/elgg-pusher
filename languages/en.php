<?php

return array(
	'pusher:settings:public_port:label' => 'Public web socket port',
	'pusher:settings:public_port:desc' => 'The server port that clients will use to establish a websocket connection to the push server.',
	'pusher:settings:private_port:label' => 'Private web socket port',
	'pusher:settings:private_port:desc' => 'This allows you to define a separate port that the push server will listen to, if you are using a proxy to tunnel traffic from the public port. Enter the public web socket port, if proxy is not being used.',
	'pusher:settings:scheme:label' => 'URI scheme',
	'pusher:settings:scheme:insecure' => 'ws:// (insecure)',
	'pusher:settings:scheme:secure' => 'wss:// (secure)',
	'pusher:settings:scheme:desc' => 'Warning: insecure connection should be used only on development servers.',
);

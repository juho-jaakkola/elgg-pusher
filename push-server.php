<?php

require dirname(dirname(__DIR__)) . '/vendor/autoload.php';
require __DIR__ . '/vendor/autoload.php';

// Start Elgg engine so we can access plugin settings
$elgg = \Elgg\Application::start();

// Internal port for WS connections. Note: in case of proxy, clients will be connecting
// to the external port (specified in the "public_port" setting).
$ws_port = elgg_get_plugin_setting('private_port', 'pusher');

$loop   = React\EventLoop\Factory::create();
$pusher = new \Pusher\Server();

// Listen for the web server to make a ZeroMQ push after a request
$context = new React\ZMQ\Context($loop);
$pull = $context->getSocket(ZMQ::SOCKET_PULL);

// Binding to 127.0.0.1 means the only client that can connect is itself
$pull->bind('tcp://127.0.0.1:5555');

$pull->on('message', array($pusher, 'onZmqMessage'));

// Set up our WebSocket server for clients wanting real-time updates
$webSock = new React\Socket\Server($loop);

// Binding to 0.0.0.0 means remotes can connect
$webSock->listen($ws_port, '0.0.0.0');

$webServer = new Ratchet\Server\IoServer(
	new Ratchet\Http\HttpServer(
		new Ratchet\WebSocket\WsServer(
			$pusher
		)
	),
	$webSock
);

$loop->run();

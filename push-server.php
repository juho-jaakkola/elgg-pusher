<?php

require dirname(dirname(__DIR__)) . '/vendor/autoload.php';
require __DIR__ . '/vendor/autoload.php';

// Start Elgg engine so we can access plugin settings
$elgg = \Elgg\Application::start();

// Get the websocket port from plugin settings
$port = _elgg_services()->plugins->get('pusher')->getSetting('private_port');

$loop   = React\EventLoop\Factory::create();
$pusher = new \Pusher\Server();

// Listen for the web server to make a ZeroMQ push after a request
$context = new React\ZMQ\Context($loop);
$pull = $context->getSocket(ZMQ::SOCKET_PULL);
$pull->bind('tcp://127.0.0.1:5555'); // Binding to 127.0.0.1 means the only client that can connect is itself
$pull->on('message', array($pusher, 'onZmqMessage'));

// Set up our WebSocket server for clients wanting real-time updates
$webSock = new React\Socket\Server($loop);
$webSock->listen($port, '0.0.0.0'); // Binding to 0.0.0.0 means remotes can connect
$webServer = new Ratchet\Server\IoServer(
	new Ratchet\Http\HttpServer(
		new Ratchet\WebSocket\WsServer(
			$pusher
		)
	),
	$webSock
);

$loop->run();

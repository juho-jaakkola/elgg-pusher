<?php

require __DIR__ . '/vendor/autoload.php';

$loop   = React\EventLoop\Factory::create();
$pusher = new \Pusher\Server();

// Listen for the web server to make a ZeroMQ push after a request
$context = new React\ZMQ\Context($loop);
$pull = $context->getSocket(ZMQ::SOCKET_PULL);
$pull->bind('tcp://127.0.0.1:5555'); // Binding to 127.0.0.1 means the only client that can connect is itself
$pull->on('message', array($pusher, 'onZmqMessage'));

// Set up our WebSocket server for clients wanting real-time updates
$webSock = new React\Socket\Server($loop);
$webSock->listen(1234, '0.0.0.0'); // Binding to 0.0.0.0 means remotes can connect
$webServer = new Ratchet\Server\IoServer(
	new Ratchet\Http\HttpServer(
		new Ratchet\WebSocket\WsServer(
			$pusher
		)
	),
	$webSock
);

$loop->run();

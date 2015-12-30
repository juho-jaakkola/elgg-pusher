<?php

namespace Pusher;

use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\WsServerInterface;
use Ratchet\MessageComponentInterface;

class Server implements MessageComponentInterface {
	/**
	 * @var $subscribers A lookup of all the topics clients have subscribed to
	 */
	protected $subscribers;

	/**
	 * @var $clients
	 */
	protected $clients;

	/**
	 *
	 */
	public function __construct() {
		$this->clients = new \SplObjectStorage;
		$this->subscribers = array();
	}

	/**
	 *
	 */
	public function getSubProtocols() {

	}

	/**
	 *
	 *
	 * @param ConnectionInterface $conn
	 */
	public function onOpen(ConnectionInterface $conn) {
		// Store the connection for sending messages later
		$this->clients->attach($conn);

		echo "New connection from a client! ({$conn->resourceId})\n";
	}

	/**
	 *
	 *
	 * @param ConnectionInterface $from
	 * @param string @msg
	 */
	public function onMessage(ConnectionInterface $from, $msg) {
		$data = json_decode($msg);

		echo "Connection {$from->resourceId} is subscribing for notifications\n";

		var_export($msg) . "\n";

		// TODO Authenticate the user
		// TODO Should the storage be injected?
		// TODO Remove users from the storage when they log out.
		$this->subscribers[$data->guid] = $from;
	}

	/**
	 *
	 *
	 * @param ConnectionInterface $conn
	 * @param string              $topic
	 */
	public function onSubscribe(ConnectionInterface $conn, $topic) {
		echo "Subscribing to a topic\n";
		$this->subscribedTopics[$topic->getId()] = $topic;
	}

	/**
	 *
	 *
	 * @param string JSON'ified string we'll receive from ZeroMQ
	 */
	public function onZmqMessage($entry) {
		$data = json_decode($entry);

		echo "Sending data to user GUID {$data->recipient_guid}\n";

		var_dump($data);

		if (isset($this->subscribers[$data->recipient_guid])) {
			$connection = $this->subscribers[$data->recipient_guid];
			$connection->send($entry);
		}
	}

	/**
	 *
	 * @param ConnectionInterface $conn
	 * @param string              $topic
	 */
	public function onUnSubscribe(ConnectionInterface $conn, $topic) {

	}

	/**
	 *
	 *
	 * @param ConnectionInterface $conn
	 */
	public function onClose(ConnectionInterface $conn) {
		// The connection is closed, remove it, as we can no longer send it messages
		$this->clients->detach($conn);

		echo "Connection {$conn->resourceId} has disconnected\n";
	}

	/**
	 *
	 */
	public function onCall(ConnectionInterface $conn, $id, $topic, array $params) {
		// In this application if clients send data it's because the user hacked around in console
		$conn->callError($id, $topic, 'You are not allowed to make calls')->close();
	}

	/**
	 *
	 */
	public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible) {
		// In this application if clients send data it's because the user hacked around in console
		$conn->close();
	}

	/**
	 *
	 */
	public function onError(ConnectionInterface $conn, \Exception $e) {
		echo "An error has occurred: {$e->getMessage()}\n";

		$conn->close();
	}
}
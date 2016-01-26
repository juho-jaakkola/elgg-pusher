/**
 * Javascript for the plugin
 */
define(function(require) {
	var elgg = require('elgg');
	var settings = require('pusher/settings');

	if (!elgg.is_logged_in()) {
		return;
	}

	var url_segments = elgg.parse_url(elgg.get_site_url());
	var url = settings.scheme + url_segments.host + ':' + settings.port;

	// TODO Check whether the client supports WebSockets
	var conn = new WebSocket(url);

	// Callbacks for plugin specific messages
	var consumers = {};

	// Callbacks for site-wide messages
	var listeners = {};

	/**
	 * Registers a callback for plugin specific messages
	 */
	function registerConsumer(consumer, callback) {
		console.log('Registering consumer ' + consumer);
		consumers[consumer] = callback;
	}

	/**
	 * Registers a listener for generic site-wide messages
	 */
	function registerListener(listener, callback) {
		console.log('Registering listener ' + listener);
		listeners[listener] = callback;
	}

	// TODO How to verify all plugins have registered as
	// consumers before opening the connection?

	/**
	 *
	 * @param {Object} e
	 */
	conn.onopen = function(e) {
		console.log("Establishing connection");

		// Tell the server who we are and what we want
		var msg = {
			guid: elgg.get_logged_in_user_guid()
		};

		conn.send(JSON.stringify(msg));
	};

	/**
	 * Route server originated messages to correct consumers
	 *
	 * @param {Object} e
	 */
	conn.onmessage = function(e) {
		var data = JSON.parse(e.data);

		console.log('Received a message from server');
		console.log(data);

		if (consumers[data.consumer] == undefined) {
			// There was no plugin defined, so broadcast
			// the message to all listeners
			$.each(listeners, function(name, callback) {
				callback(data);
			});

			return;
		}

		consumers[data.consumer](data);
	};

	return {
		'registerConsumer': registerConsumer,
		'registerListener': registerListener
	};
});

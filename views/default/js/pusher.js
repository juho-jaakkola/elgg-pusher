/**
 * Javascript for the plugin
 */
define(function(require) {
	var elgg = require('elgg');

	var url_segments = elgg.parse_url(elgg.get_site_url());
	var url = 'ws://' + url_segments.host + ':1234';

	// TODO Check whether the client supports WebSockets
	var conn = new WebSocket(url);

	var consumers = {};

	/**
	 * Register a plugin as a push server consumer
	 */
	function registerConsumer(consumer, callback) {
		console.log('Registering consumer ' + consumer);
		consumers[consumer] = callback;
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
	 *
	 * @param {Object} e
	 */
	conn.onmessage = function(e) {
		var data = JSON.parse(e.data);

		console.log('Received a message from server');
		console.log(data);
		console.log(data.consumer);
		console.log(consumers[data.consumer]);

		consumers[data.consumer](data);
	};

	return {
		'registerConsumer': registerConsumer
	};
});

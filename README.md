# Pusher

Plugin that enables real-time communications, such as instant notifications
and real-time chats, for the social networking engine [Elgg](https://elgg.org/).

Actual user-facing features are not included in this plugin. Additional plugins
need to be installed in order to make use of the communication features.

## Prerequisites

 - [ZeroMQ library](http://zeromq.org/) for your server
 - PHP bindings for the ZeroMQ library

You may need to tunnel the traffic through a proxy e.g. in order to encrypt it.
You can use software such as [stunnel](https://www.stunnel.org/) to achieve this.

## Installation

 1. Place the plugin source code to Elgg's `mod/` directory
 2. Enable the plugin form Elgg admin panel
 3. Enter plugin settings
 4. Flush Elgg caches
 5. Enable the push server
     - Example command on a Unix-like OS using the `nohub` command:

		```
		nohub /usr/bin/php5 -f /var/www/elgg/mod/pusher/push-server.php
		```

 6. Logged in users should now receive real-time updates from plugins that have support for the push server

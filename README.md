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

 1. Place the plugin (it must be named `pusher`) in Elgg's `mod/` directory
 2. Enable the plugin form Elgg admin panel
 3. Enter plugin settings
 4. Flush Elgg caches
 5. Start the push server. E.g. `php -f /var/www/elgg/mod/pusher/push-server.php`
 6. Verify that logged in users receive real-time updates from plugins that have support
    for the push server
 7. Stop and install the push server as a service (TODO)

## Notes

`push-server.php` may run with different PHP settings. Make sure your Elgg `settings.php`
file specifies the default timezone, and that Elgg does not emit warnings, notices, errors,
or fatal exceptions on start up.

If using PHP installed via Homebrew for Mac, you may need to install ZeroMQ and the PHP
module from source:

```
brew install php56-zmq --universal --build-from-source
```

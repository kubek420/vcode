<?php

namespace WebWork\Features;

use Pusher\Pusher;

$pusher = null;

if (config('WEBSOCKET_KEY') && config('WEBSOCKET_SECRET_KEY') && config('WEBSOCKET_APP_ID')) {
    $pusher = new Pusher(config('WEBSOCKET_KEY'), config('WEBSOCKET_SECRET_KEY'), config('WEBSOCKET_APP_ID'), [
        'cluster' => 'eu',
        'useTLS' => true
    ]);
}

class WebSocket {
    public static function sendMessage($event, $msg) {
        global $pusher;

        if ($pusher === null) {
            error('Provide your WebSocket credentials in config.json');
        }

        $pusher->trigger(config('WEBSOCKET_CHANNEL'), $event, $msg);
    }
}
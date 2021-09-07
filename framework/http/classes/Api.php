<?php

namespace WebWork\Features;

class Api {
    public static function get($url, $json = false, array $headers = []) {
        $data = null;

        $opts = [
            'http' => array_merge(['method' => 'GET'], $headers)
        ];

        $data = @file_get_contents($url, false, stream_context_create($opts));

        return json_decode($data, $json);
    }
}

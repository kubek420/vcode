<?php

function config($rule) {
    if (!file_exists(__DIR__.'/../../../config.json')) {
        error('Configuration file not found');
    }

    $configFile = file_get_contents(__DIR__.'/../../../config.json');

    $config = json_decode($configFile, true);

    // Check whether rule exists
    if (!array_key_exists($rule, $config)) {
        error('Configuration rule "'.$rule.'" does not exist');
    }

    return $config[$rule];
}

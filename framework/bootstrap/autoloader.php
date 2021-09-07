<?php

require_once __DIR__.'/../login/utils/User.php';
require_once __DIR__.'/../vendor/autoload.php';

session_start();

// Framework dependencies
$frameworkFolders = [
    'config',
    'errors',
    'captcha',
    'database',
    'helpers',
    'login',
    'http',
    'routing',
    'mail',
    'validation',
    'views',
    'websocket'
];

foreach ($frameworkFolders as $folder) {
    foreach (glob(__DIR__.'/../'.$folder.'/classes/*.php', GLOB_BRACE) as $filename) {
        require_once $filename;
    }

    foreach (glob(__DIR__.'/../'.$folder.'/functions/*.php', GLOB_BRACE) as $filename) {
        require_once $filename;
    }
}

// App files
$appFolders = [
    'routes',
    'models',
    'controllers'
];

foreach ($appFolders as $folder) {
    foreach (glob(__DIR__.'/../../app/'.$folder.'/*.php', GLOB_BRACE) as $filename) {
        require_once $filename;
    }
}

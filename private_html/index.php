<?php

use WebWork\Features\Route;

/**
 * WebWork | The PHP framework
 *
 * @package  WebWork
 * @author   Dominik Rajkowski <dom.rajkowski@gmail.com>
 */

require_once __DIR__.'/../framework/bootstrap/autoloader.php';

try {
    Route::evaluate();
} catch (\Error $e) {
    error($e);
}

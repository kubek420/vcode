<?php

use WebWork\Features\Response;

function abort($status = 404, $text = false) {
    http_response_code($status);

    ob_end_clean();

    $text = Response::$statusDescriptions[$status];

    include __DIR__.'/../utils/html/http-status.php';

    exit;
}

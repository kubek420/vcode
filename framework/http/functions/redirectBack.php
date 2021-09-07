<?php

function redirectBack($data = []) {
    foreach ($data as $k => $v) {
        $_SESSION['WEBWORK_FLASH_'.$k] = $v;
    }

    if (isset($_SERVER['HTTP_REFERER'])) {
        header('Location: '.$_SERVER['HTTP_REFERER']);

        exit;
    }

    abort(500);
}

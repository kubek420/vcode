<?php

function redirect($url, $data = []) {
    foreach ($data as $k => $v) {
        $_SESSION['WEBWORK_FLASH_'.$k] = $v;
    }

    header('Location: '.$url);

    exit;
}

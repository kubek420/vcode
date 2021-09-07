<?php

function redirectData($name) {
    if (isset($_SESSION['WEBWORK_FLASH_'.$name])) {
        $value = $_SESSION['WEBWORK_FLASH_'.$name];

        unset($_SESSION['WEBWORK_FLASH_'.$name]);

        return $value;
    }

    return '';
}

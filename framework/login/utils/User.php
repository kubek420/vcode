<?php

namespace WebWork\Features;

class User {
    public function __construct($user) {
        foreach ($user as $property => $value) {
            $this->{$property} = $value;
        }
    }

    public function __get($var) {
        if (!property_exists($this, $var)) {
            error('Logged user hasn\'t property "'.$var.'"');
        }
    }
}

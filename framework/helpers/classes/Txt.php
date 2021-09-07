<?php

namespace WebWork\Features;

class Txt {
    public static function uppercase(string $str) {
        return strtoupper($str);
    }

    public static function lowercase(string $str) {
        return strtolower($str);
    }

    public static function contains(string $search, string $str) {
        if ($search !== '' && mb_strpos($str, $search) !== false) {
            return true;
        }

        return false;
    }

    public static function replace(string $from, string $to, string $str) {
        return str_replace($from, $to, $str);
    }

    public static function pascalCase(string $str, $replaceDashes = true) {
        if ($replaceDashes) {
            $str = str_replace('-', ' ', $str);
            $str = str_replace('_', ' ', $str);
        }

        $str = ucwords(strtolower($str));

        return str_replace(' ', '', $str);
    }
}

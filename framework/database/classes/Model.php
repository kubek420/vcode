<?php

namespace WebWork\Features;

abstract class Model {
    public static function all() {
        $className = explode('\\', static::class);

        return DB::query('SELECT * FROM '.strtolower(array_pop($className)).'s');
    }
}

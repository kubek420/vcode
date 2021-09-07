<?php

namespace WebWork\Features;

use PDO;
use PDOException;

class DB {
    public static function query($sql) {
        $credentials = [
            'host' => config('DB_HOST'),
            'user' => config('DB_USERNAME'),
            'password' => config('DB_PASSWORD'),
            'database' => config('DB_DATABASE')
        ];

        try {
            $database = new PDO("mysql:host={$credentials['host']};dbname={$credentials['database']};charset=utf8", $credentials['user'], $credentials['password'], [
                PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            $database->query('SET NAMES UTF8');
            $database->query('SET CHARACTER SET UTF8');

            $query = $database->prepare($sql);
            $query->execute();

            $result = $query->fetchAll();

            if (count($result) == 1)
                return $result[0];
            
            return $result;
        } catch (PDOException $e) {
            error($e->getCode().' '.$e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    public static function find(int $id, $table) {
        return self::query('SELECT * FROM '.$table.' WHERE id = '.$id.' OR Id = '.$id.' OR ID = '. $id);
    }
}

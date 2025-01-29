<?php

namespace Core;

use PDO;
use PDOException;
use const Config\DSN, Config\USER, Config\PASSWORD;

class Model
{
    protected static function connection(): PDO
    {
        try {
            $pdo = new PDO(DSN, USER, PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die("Falló la conexión: " . $e->getMessage());
        }
        return $pdo;
    }
}

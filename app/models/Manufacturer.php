<?php

namespace App\models;

use Core\Model;

#[\AllowDynamicProperties]

class Manufacturer extends Model
{
    public static function all()
    {
        try {
            $db = self::connection();

            $sql = "select * from manufacturer";

            $stm = $db->prepare($sql);

            if ($stm->execute()) {
                $result = $stm->fetchAll(\PDO::FETCH_OBJ);
                return $result;
            } else {
                return null;
            }

        } catch (\PDOException $e) {
            http_response_code(500);
            error_log("Error en Manufacturer::all - " . $e->getMessage());
            return null;
        }
    }

    public static function findByName($name) {
        try {
            $db = self::connection();

            $sql = "SELECT * FROM manufacturer WHERE name = :name";

            $stm = $db->prepare($sql);
            $stm->bindParam(':name', $name);

            if ($stm->execute()) {
                return  $stm->fetch(\PDO::FETCH_OBJ);
            } else {
                return null;
            }

        } catch (\PDOException $e) {
            http_response_code(500);
            error_log("Error en Manufacturer::findByName - " . $e->getMessage());
            return null;
        }
    }
}
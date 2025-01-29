<?php

namespace App\models;

use Core\Model;

#[\AllowDynamicProperties]

class  Product extends Model
{

    public string $name;
    public int $price;
    public int $manufactureId;

    public static function all()
    {
        try {

            $db = self::connection();

            $sql = "SELECT p.id, p.name AS product, p.price, m.name AS manufacturer_name
                    FROM product p 
                    INNER JOIN manufacturer m ON p.manufacturerId = m.id;
                   ";

            $stm = $db->prepare($sql);

            if ($stm->execute()) {
                $result = $stm->fetchAll(\PDO::FETCH_OBJ);
                return $result;
            } else {
                return null;
            }

        } catch (\PDOException $e) {
            http_response_code(500);
            error_log("Error en Product::all - " . $e->getMessage());
            return null;
        }
    }

    public static function find($id)
    {
        try {

            $db = self::connection();

            $sql = "SELECT p.id, p.name AS name, p.price, m.name AS manufacturer_name
                    FROM product p  
                    INNER JOIN manufacturer m ON p.manufacturerId = m.id
                    WHERE p.id = :id;
                   ";

            $stm = $db->prepare($sql);
            $stm->bindParam(':id', $id, \PDO::PARAM_INT);

            if ($stm->execute()) {
                $result = $stm->fetchAll(\PDO::FETCH_OBJ);
                return $result;
            } else {
                return null;
            }

        } catch (\PDOException $e) {
            http_response_code(500);
            error_log("Error en Product::all - " . $e->getMessage());
            return null;
        }
    }

    public function createProduct()
    {
        try {

            $db = self::connection();
            $sql = "insert into product (name, price, manufacturerId) values (:name, :price, :manufactureId)";

            $stm = $db->prepare($sql);
            $stm->bindParam(":name", $this->name);
            $stm->bindParam(":price", $this->price, \PDO::PARAM_INT);
            $stm->bindParam(":manufactureId", $this->manufactureId, \PDO::PARAM_INT);

            return $stm->execute();

        } catch (\PDOException $e){
            error_log("Error en CreateCustomer() - " . $e->getMessage());
            return false;
        }

    }

    public function update($id)
    {
        try {

            $db = self::connection();
            $sql = "update product set name = :name, price = :price, manufacturerId = :manufacturerId where id = :id";

            $stm = $db->prepare($sql);
            $stm->bindParam(":id", $id);
            $stm->bindParam(":name", $this->name);
            $stm->bindParam(":price", $this->price, \PDO::PARAM_INT);
            $stm->bindParam(":manufacturerId", $this->manufactureId, \PDO::PARAM_INT);

            return $stm->execute();

        } catch (\PDOException $e){
            error_log("Error en Update() - " . $e->getMessage());
            return false;
        }
    }

    public static function delete($id)
    {
        try {

            $db = self::connection();
            $sql = "delete from product where id = :id";

            $stm = $db->prepare($sql);
            $stm->bindParam(":id", $id);

            return $stm->execute();

        } catch (\PDOException $e){
            error_log("Error en Delete() - " . $e->getMessage());
            return false;
        }
    }

}
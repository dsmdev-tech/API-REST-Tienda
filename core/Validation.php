<?php

namespace Core;

use App\Models\Customer;
use App\Models\Manufacturer;

class Validation
{
    private static array $errors = [];

    private static function sanitizeInput($data): string
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    public function validate($name, $price, $manufacturerId): array
    {
        $name = self::sanitizeInput($name);
        if (empty($name)) {
            self::$errors["name"] = "* Nombre requerido";
        } elseif (!preg_match("/^[a-zA-Z0-9' -]+$/", $name)) {
            self::$errors["name"] = "* Solo se admiten letras, números y espacios";
        }

        $price = self::sanitizeInput($price);
        if (empty($price)) {
            self::$errors["price"] = "* Precio requerido";
        }

        $manufacturerId = self::sanitizeInput($manufacturerId);
        if (empty($manufacturerId)) {
            self::$errors["manufacturerId"] = "* id requerido";
        }
        if (!is_numeric($manufacturerId)) {
            self::$errors["manufacturerId"] = "* Solo se admiten números";
        }
        $manufacturer = new Manufacturer();
        if(!$manufacturer->findById($manufacturerId)){
            self::$errors["manufacturerId"] = "* No existe el fabricante";
        }

        return self::$errors;
    }

}
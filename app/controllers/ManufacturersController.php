<?php

namespace App\Controllers;
use App\Models\Manufacturer;
use Core\ResponseHelper;

class ManufacturersController
{
    public function all()
    {
        $products = Manufacturer::all();

        if ($products) {
            ResponseHelper::json($products, 200);
            return;
        } else {
            ResponseHelper::json(['status' => 404, 'message' => 'No se encontraron manufacturadores'], 404);
            return;
        }
    }

}
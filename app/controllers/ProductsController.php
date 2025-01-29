<?php

namespace App\Controllers;

use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\User;
use Core\ResponseHelper;
use Core\Token;

class ProductsController
{
    public function all()
    {
        $products = Product::all();

        if ($products) {
            ResponseHelper::json($products, 200);
            return;

        } else {
            ResponseHelper::json(['status' => 404, "error" => "No se encontraron productos"], 404);
            return;
        }
    }

    public function show($id)
    {
        $product = Product::find($id);

        if ($product) {
            ResponseHelper::json($product, 200);
            return;
        } else {
            ResponseHelper::json(['status' => 204, "error" => "Producto no encontrado"], 204);
            return;
        }
    }

    public function store()
    {
        self::validateToken();

        $data = json_decode(file_get_contents('php://input'), true);

        //encontrar el id del manufacturer
        $manufacturer = Manufacturer::findByName($data['manufacturer_name']);

        if (!$manufacturer) {
            ResponseHelper::json(['status' => 404, 'error' => "Fabricante no encontrado"], 404);
            return;
        }

        $product = new Product();
        $product->name = $data['product'];
        $product->price = $data['price'];
        $product->manufactureId = $manufacturer->id;

        if ($product->createProduct()) {

            ResponseHelper::json(['status' => 201, 'message' => "Producto creado correctamente"], 201);
            return;

        } else {
            ResponseHelper::json(['status' => 500, 'error' => "No se pudo crear el producto"], 500);
            return;
        }
    }

    public function update($id)
    {
        self::validateToken();

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data){
            parse_str(file_get_contents('php://input'), $data);
        }

        //Validacion de datos

        $product = new Product();
        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->manufactureId = $data['manufacturerId'];

        if ($product->update($id)) {
            ResponseHelper::json(["status"=> "200", "message" => "Producto actualizado correctamente"], 200);
            return;
        } else {
            ResponseHelper::json(["status"=> "500", "error" => "No se pudo actualizar el producto"], 500);
            return;
        }
    }

    public function destroy($id)
    {
        self::validateToken();

        if (Product::delete($id)) {
            ResponseHelper::json(["status" => 200, "message" => "Producto eliminado correctamente"], 200);
            return;
        } else {
            ResponseHelper::json(["status" => 404, "error" => "Producto no encontrado"], 404);
            return;
        }
    }

    public function validateToken()
    {
        if (is_array(Token::ValidateToken())){

            $res = Token::ValidateToken();

            // Comprobar si el token es el mismo que el que tienes en la base de datos

            if (isset( $res['token'])){

                $token = $res['token'];

                $user = User::findByToken($token);

                if (!$user){
                    ResponseHelper::json(['status' => 401, 'message' => "Token no válido"], 401);
                    return;
                }
            }

        }
    }
}
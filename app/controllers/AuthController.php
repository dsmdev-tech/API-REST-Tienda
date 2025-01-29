<?php

namespace App\Controllers;

use App\Models\User;
use Core\ResponseHelper;
use Firebase\JWT\JWT;
use const Config\KEY;

class AuthController
{
    public function signup()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data){
            $data = $_POST;
        }

        if (!isset($data["email"]) || !isset($data["password"])){

            ResponseHelper::json(['status' => 400, 'message' => "Solicitud incorrecta, faltan datos"], 400);
            return;

        } else {
            $user = new User();
            $user->email = $data["email"];
            $user->password = password_hash($data["password"], PASSWORD_DEFAULT);

            $user->insert();

            ResponseHelper::json(['status' => 201, 'message' => "Usuario creado con exito"], 201);
            return;

        }
    }

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data){
            $data = $_POST;
        }

        if (!isset($data["email"]) || !isset($data["password"])) {

            ResponseHelper::json(['status' => 400, 'message' => "Solicitud incorrecta, faltan datos"], 400);
            return;
        }

        $user = User::findByEmail($data["email"]);


        if ($user && password_verify($data["password"], $user->password)){

            $payload = [
                'exp' => time() + 3600,
                'id' => $user->id,
                'email' => $user->email
            ];

            $jwt = JWT::encode($payload, KEY, 'HS256');

            $user->update($jwt);

            ResponseHelper::json(['status' => 200, 'message' => 'Usuario autenticado con éxito', 'token' => $jwt], 200);
            return;

        } else {
            ResponseHelper::json(['status' => 401, 'message' => "Usuario o contraseña incorrectos"], 401);
            return;
        }
    }

    public function logout($jwt)
    {
        $token = explode(' ', getallheaders()['Authorization'])[1];
        $user = User::findByToken($token);

        if ($user){
            $user->update(null);

            ResponseHelper::json(['status' => 200, 'message' => 'Sesión cerrada con éxito'], 200);
            return;

        } else {
            ResponseHelper::json(['status' => 401, 'message' => 'No autorizado'], 401);
            return;
        }
    }
}
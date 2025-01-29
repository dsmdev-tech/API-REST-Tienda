<?php

namespace Core;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use const Config\KEY;

class Token
{
    public static function ValidateToken()
    {
        if (!isset(getallheaders()['Authorization'])){
            $res = [
              'status' => 401,
              'message' => 'No autorizado'
            ];

            http_response_code(401);
            header('Content-Type: application/json');
            return $res;
        }

        $token = explode(' ', getallheaders()['Authorization'])[1];

        try {

            JWT::decode($token, new Key(KEY, 'HS256'));

        } catch (\Exception $e){
            $res = [
                'status' => 401,
                'message' => "Token no valido " . $e->getMessage()
            ];

            http_response_code(401);
            header('Content-Type: application/json');

            return $res;
        }

        $res = [
            'token' => $token,
        ];
        return $res;
    }
}
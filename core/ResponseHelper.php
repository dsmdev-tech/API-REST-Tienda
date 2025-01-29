<?php

namespace Core;

class ResponseHelper
{
    public static function json($data, $status)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

}
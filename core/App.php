<?php

namespace Core;

class App
{
    public function __construct()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : 'products';

        $arguments = explode('/', trim($url, '/'));

        $controllerName = ucwords(array_shift($arguments)) . "Controller";

        $file = "../app/controllers/$controllerName.php";

        if (!file_exists($file)) {
            http_response_code(404);
            die(json_encode(["error" => "Controlador no encontrado: $controllerName"]));
        }
        require_once $file;


        $namespace = "App\\Controllers\\";
        $controllerClass = $namespace . $controllerName;

        if (!class_exists($controllerClass)) {
            http_response_code(404);
            die(json_encode(["error" => "Clase de controlador no encontrada: $controllerClass"]));
        }

        $controllerObject = new $controllerClass();

        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {

            case 'GET':

                if (!empty($arguments)&& is_numeric($arguments[0])) {
                    $method = "show";
                    $arguments = [$arguments[0]];

                } else {

                    $method = "all";

                }
                break;

            case 'POST':

                if (!empty($arguments) && $arguments[0] === "signup") {

                    $method = "signup";

                } elseif (!empty($arguments) && $arguments[0] === "login") {

                    $method = "login";

                } elseif (!empty($arguments)){
                    $res = [
                        'status' => 400,
                        'message' => 'Solicitud incorrecta, no se puede realizar esta peticion por POST'
                    ];
                    http_response_code(400);
                    echo json_encode($res);

                } else {

                    $method = "store";
                }
                break;

            case 'PUT':
                if (is_numeric($arguments[0])) {
                    $method = "update";
                    $arguments = [$arguments[0]];

                } elseif (!empty($arguments) && $arguments[0] === "logout") {

                    $method = "logout";

                } else {
                    $res = [
                        'status' => 400,
                        'message' => 'Solicitud incorrecta, no se puede realizar esta petición por PUT'
                    ];
                    http_response_code(400);
                    echo json_encode($res);
                }
                break;

            case 'DELETE':
                if ($arguments[0] !== null) {
                    $method = "destroy";
                    $arguments = [$arguments[0]];
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "ID del cliente requerido para eliminar"]);
                }
                break;



            default:
                http_response_code(405);
                echo json_encode(["error" => "Método HTTP no permitido"]);
                break;
        }

        if (method_exists($controllerClass, $method)) {
            call_user_func_array([$controllerObject, $method], $arguments);
        } else {
            echo "No encontrado el método";
            die();
        }
    }
}
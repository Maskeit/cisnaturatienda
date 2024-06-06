<?php

namespace app;
//catalogo.route.php
require_once "../../autoloader.php";

use Controllers\CarritoController;
use Controllers\Middleware;
use Controllers\PostController as PostController;

//use app\PasswordHash;
require('../../libraries/phpass-master/PasswordHash.php');

try {
    $pwdHasher = new PasswordHash(8, FALSE);
    $autorization = new Middleware();
    $api = new Middleware();
    $_HEADERS = apache_request_headers();
    $route = $_SERVER['REQUEST_URI'];
    $contentCatalogo = $api->autorization($_HEADERS, $pwdHasher);

    if (!$contentCatalogo) {
        $json["response"] = "No hay contenido que mostrarte";
        echo json_encode($json, JSON_PRETTY_PRINT);
        return;
    }

    //metodo para agregar un producto al carrito del cliente
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_ap'])) {
        //print_r('recibido');
        $productId = $_POST['pid'];
        $cantidad = $_POST['cantidad'];
        $verificar = $api->autorization($_HEADERS, $pwdHasher);
        if ($verificar['success']) {
            $userId = $verificar['userId'];
            $carrito = new CarritoController();
            $productoExistente = $carrito->agregarProducto($productId, $userId, $cantidad);
            $cantidadPr = $carrito->cantProductos($userId);
            //print_r("Llego aqui la peticion de anadir");
            $json["response"] = 1;
            echo json_encode($json, JSON_PRETTY_PRINT);
            return;
        }
        $json["response"] = "failed";
        echo json_encode($json, JSON_PRETTY_PRINT);
        return;
    }

    //metodo para traer los productos al catalogo 
    $tp = in_array('_tp', array_keys(filter_input_array(INPUT_GET)));
    if ($tp) {
        $postController = new PostController();
        $type = filter_input(INPUT_GET, '_tp');
        $result = $postController->getProductsToClient($type);
        if (!$result) {
            $json["response"] = "internal server error or auth denied";
            echo json_encode($json, JSON_PRETTY_PRINT);
            return;
        }
        print_r($result);
    }

    //metodo para mostrar la cantidad de productos en el carrito
    $np = in_array('_np', array_keys(filter_input_array(INPUT_GET)));
    if ($np) {
        $verificar = $api->autorization($_HEADERS, $pwdHasher);
        if ($verificar['success']) {
            $userId = $verificar['userId'];

            $carrito = new CarritoController();
            $cantidadPr = $carrito->cantProductos($userId);
            $json["response"] = $cantidadPr; // donde $cantidadPr es el retorno de cantProductos()
            echo json_encode($json);            
            return;
        } else {
            echo json_encode(["response" => "Unauthorized"]);
            return;
        }
    }
} catch (Exception $e) {
    $json["response"] = "internal server error";
    echo json_encode($json, JSON_PRETTY_PRINT);
}

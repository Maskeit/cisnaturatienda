<?php

namespace app;
require_once "../../autoloader.php";

use Controllers\CarritoController;
use Controllers\Middleware;
use Controllers\PostController as PostController;

require('../../libraries/phpass-master/PasswordHash.php');

try {
    $pwdHasher = new PasswordHash(8, FALSE);
    $api = new Middleware();
    $_HEADERS = apache_request_headers();
    $contentCatalogo = $api->autorization($_HEADERS, $pwdHasher);

    if (!$contentCatalogo) {
        $json["response"] = "No hay contenido que mostrarte";
        echo json_encode($json, JSON_PRETTY_PRINT);
        return;
    }
    $userId = $contentCatalogo['userId'];

    //metodo para agregar un producto al carrito del cliente
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_ap'])) {
        $productId = $_POST['pid'];
        $cantidad = $_POST['cantidad'];
        $carrito = new CarritoController();
        $productoExistente = $carrito->agregarProducto($productId, $userId, $cantidad);
        $cantidadPr = $carrito->cantProductos($userId);
        $json["response"] = 1;
        echo json_encode($json, JSON_PRETTY_PRINT);
        return;
    }

    // //metodo para traer los productos al catalogo 
    $tp = in_array('_tp', array_keys(filter_input_array(INPUT_GET)));
    if ($tp) {
        $productos = new PostController();
        $type = filter_input(INPUT_GET, '_tp');
        $result = $productos->getProductsToClient($type);
        if (!$result) {
            $json["response"] = "internal server error or auth denied";
            echo json_encode($json, JSON_PRETTY_PRINT);
            return;
        }
        print_r($result);
        return;
    }

    //metodo para mostrar la cantidad de productos en el carrito
    $np = in_array('_np', array_keys(filter_input_array(INPUT_GET)));
    if ($np) {
        $carrito = new CarritoController();
        $result = $carrito->cantProductos($userId);
        if (!$result) {
            $json["response"] = "internal server error or auth denied";
            echo json_encode($json, JSON_PRETTY_PRINT);
            return;
        }
        print_r($result);
        return;
    }
} catch (Exception $e) {
    $json["response"] = "internal server error";
    echo json_encode($json, JSON_PRETTY_PRINT);
}

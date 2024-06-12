<?php

namespace app;
//catalogo.route.php
require_once "../../autoloader.php";

use Controllers\CarritoController;
use Controllers\Middleware;

//use app\PasswordHash;
require('../../libraries/phpass-master/PasswordHash.php');

try {
    $pwdHasher = new PasswordHash(8, FALSE);
    $api = new Middleware();
    $_HEADERS = apache_request_headers();
    $contentCarrito = $api->autorization($_HEADERS, $pwdHasher);

    if (!$contentCarrito['success']) {
        // Ahora 'message' contiene el mensaje específico del error
        echo json_encode(['response' => $contentCarrito['message']], JSON_PRETTY_PRINT);
        return;
    }
    header('Content-Type: application/json');
    $userId = $contentCarrito['data']['userId'];
    
    //metodo para ver productos en carrito
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['_tc'])) {
        $carrito = new CarritoController();
        $productosCarrito = $carrito->allCar($userId);
        echo json_encode(["response" => $productosCarrito]);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_dpc'])) {
        $productId = $_POST['pid'];
        $carrito = new CarritoController();
        $carrito->deleteProductCar($productId);
        echo json_encode(["response" => "Ok"]); //producto eliminado
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_update'])) {
        $pid = $_POST['pid'];
        $cantidad = $_POST['cantidad'];
        $carrito = new CarritoController();
        $result = $carrito->updateProductQuantity($pid, $userId, $cantidad);
        echo json_encode(["response" => $result]);
    } else {
        echo json_encode(["response" => "no"]); //accion no reconocida
    }
} catch (\Throwable $th) {
    //throw $th;
}
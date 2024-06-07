<?php
namespace app;

require_once "../../autoloader.php";

use Controllers\CarritoController;
use Controllers\Middleware;
use Controllers\PostController as PostController;

//use app\PasswordHash;
require('../../libraries/phpass-master/PasswordHash.php');

try {
    $pwdHasher = new PasswordHash(8, FALSE);
    $api = new Middleware();
    $_HEADERS = apache_request_headers();
    $contentHome = $api->autorization($_HEADERS, $pwdHasher);

    if(!$contentHome){
        $json["response"] = "No hay contenido que mostrarte";
        echo json_encode($json, JSON_PRETTY_PRINT);
        return;
    }
    $userId = $contentHome['userId'];
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

    //metodo para traer los productos al catalogo de muestra en home
    $lp = in_array('_lp', array_keys(filter_input_array(INPUT_GET)));
    if($lp){
        $productos = new PostController();
        $result = $productos->getProductsToHome(4);
        if(!$result){
            $json["response"] = "internal server error or auth denied";
            echo json_encode($json, JSON_PRETTY_PRINT);
            return;
        }
        print_r($result);
    }


} catch(Exception $e) {
    $json["response"] = "internal server error";
    echo json_encode($json, JSON_PRETTY_PRINT);
}
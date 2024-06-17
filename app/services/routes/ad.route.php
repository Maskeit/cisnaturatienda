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
    $contentDashboard = $api->adminAuthorization($_HEADERS, $pwdHasher);

    if (!$contentDashboard['success']) {
        // Ahora 'message' contiene el mensaje específico del error
        echo json_encode(['response' => $contentDashboard['message']], JSON_PRETTY_PRINT);
        return;
    }
    $userId = $contentDashboard['data']['userId'];

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['_posts'])) {
        $posts = new PostController();
        $result = $posts->getProductsToAdmin();
        if (!$result) {
            $json["response"] = "internal server error or auth denied";
            echo json_encode($json, JSON_PRETTY_PRINT);
            return;
        }
        print_r($result);
        return;
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_editproduct'])){
        echo $_SERVER['REQUEST_URI'];
        $posts = new PostController();
        // Aquí podrías necesitar acceder al cuerpo de la petición de otra manera debido a FormData
        $data = $_FILES; // Si enviaste algún archivo
        echo json_encode($data); // Ver qué archivos se han recibido
        echo json_encode($_POST); // Ver otros campos enviados
        return;
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_dp'])){
        $posts = new PostController();
        $pid = $posts['data']['pid'];
        print_r($pid);
        //$result = $posts->deleteProduct()
    }
     else {
        echo json_encode(["response" => false]);
    }
} catch (\Throwable $th) {
    //throw $th;
}
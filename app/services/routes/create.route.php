<?php

namespace app;
require_once "../../autoloader.php";

use Controllers\CarritoController;
use Controllers\Middleware;
use Controllers\PostController as PostController;

require('../../libraries/phpass-master/PasswordHash.php');


try{
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_create'])) {
        // Validar que todos los campos necesarios están presentes
        if (isset($_POST['type'], $_POST['product_name'], 
            $_POST['description'], $_POST['price']) 
            && isset($_FILES['thumb']) && $_FILES['thumb']['error'] == 0
            ) {
            $postController = new PostController();
            $result = $postController->createProduct($_POST);                
            if (!$result['success']) {
                echo json_encode(['response'=> $result['success']], JSON_PRETTY_PRINT);
                return;
            }
            echo json_encode(['response'=> $result['success']], JSON_PRETTY_PRINT);
        } else {
            $json["response"] = "Campos inccorrectos o faltantes";
            echo json_encode($json, JSON_PRETTY_PRINT);
            return;
        }
    } else {
        $json["response"] = false;
        echo json_encode($json, JSON_PRETTY_PRINT);
        return;
    }

} catch (\Throwable $th) {
    //throw $th;
}
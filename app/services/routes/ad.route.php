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
        if (!$result['success']) {
            $json["response"] = "internal server error or auth denied";
            echo json_encode($json, JSON_PRETTY_PRINT);
            return;
        }
        print_r($result['data']);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_editproduct'])){
        $posts = new PostController();
        $result = $posts->updateProduct($_POST);
        if (!$result['success']) {
            http_response_code(500); // Cambia el código de respuesta a 500 si hay un error
            echo json_encode(['response'=> $result['message']]);
            return;
        }
        echo json_encode(['response'=> $result['success']], JSON_PRETTY_PRINT);
    }
     elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_dp'])){
        $pid = $_POST['pid'];
        $posts = new PostController();
        $result = $posts->deleteProduct($pid);
        if ($result == false) {
            $json["response"] = false;
            $json["message"] = "Failed to delete the product.";
            echo json_encode($json, JSON_PRETTY_PRINT);
            return;
        }
        $json["response"] = true;
        $json["message"] = "Product deleted successfully.";
        echo json_encode($json, JSON_PRETTY_PRINT);
        return;
    } elseif($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_active'])){
        $pid = $_POST['pid'];
        $state = $_POST['state'];
        $posts = new PostController();
        $result = $posts->toggleProdActive($pid,$state);
        if ($result == false) {
            $json["response"] = false;
            $json["message"] = "Failed to toggle the product.";
            echo json_encode($json, JSON_PRETTY_PRINT);
            return;
        }
        $json["response"] = true;
        $json["message"] = "Product toggled successfully.";
        echo json_encode($json, JSON_PRETTY_PRINT);
    } else {
        $json["response"] = false;
        echo json_encode($json, JSON_PRETTY_PRINT);
        return;
    }
} catch (\Throwable $th) {
    //throw $th;
}
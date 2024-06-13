<?php
namespace app;

require_once "../../autoloader.php";

use Controllers\auth\LoginController;
use Controllers\Middleware;

require('../../libraries/phpass-master/PasswordHash.php');

try {
    $pwdHasher = new PasswordHash(8, FALSE);
    $api = new Middleware();
    $_HEADERS = apache_request_headers();
    $contentUser = $api->autorization($_HEADERS, $pwdHasher);
    if (!$contentUser['success']) {
        // Ahora 'message' contiene el mensaje específico del error
        echo json_encode(['response' => $contentUser['message']], JSON_PRETTY_PRINT);
        return;
    }
    $userId = $contentUser['data']['userId'];
    $name = $contentUser['data']['name'];
    $jsonName = $contentUser['data']['json'];
    //print_r($userId);
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_aname'])) {        
        $json['response'] = $name;
        echo json_encode($json, JSON_PRETTY_PRINT);
        return;
    }elseif($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_closeSession'])) {
        $loginController = new LoginController();
        if ($loginController->sessionDestroy($jsonName, $userId)) {
            echo json_encode(['response' => "Session closed successfully"]);
        } else {
            echo json_encode(['response' => "Failed to close session"]);
        }
    }
} catch (Exception $e) {
    $json["response"] = "internal server error";
    echo json_encode($json, JSON_PRETTY_PRINT);
}

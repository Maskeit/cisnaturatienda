<?php
namespace app;

require_once "../../autoloader.php";

use Controllers\auth\LoginController;
use Controllers\Middleware;

require('../../libraries/phpass-master/PasswordHash.php');

try {
    $pwdHasher = new PasswordHash(8, FALSE);
    $autorization = new Middleware();
    $api = new Middleware();
    $_HEADERS = apache_request_headers();    

    $logout = in_array('_logout',array_keys(filter_input_array(INPUT_GET)));
    $sessionExists = $api->logout($_HEADERS, $pwdHasher, $logout);
    if(!$sessionExists){
        $json["response"] = "No session para cerrar";
        echo json_encode($json, JSON_PRETTY_PRINT);
        return;
    }

    
} catch (\Throwable $th) {
    //throw $th;
}
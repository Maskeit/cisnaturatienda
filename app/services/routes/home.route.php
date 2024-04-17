<?php
namespace app;

require_once "../../autoloader.php";

use Controllers\Middleware;
use Controllers\PostController as PostController;

//use app\PasswordHash;
require('../../libraries/phpass-master/PasswordHash.php');

try {
    $pwdHasher = new PasswordHash(8, FALSE);
    $autorization = new Middleware();
    $api = new Middleware();
    $_HEADERS = apache_request_headers();
    $contentHome = $api->autorization($_HEADERS, $pwdHasher);
    if(!$contentHome){
        $json["response"] = "No hay contenido que mostrarte";
        echo json_encode($json, JSON_PRETTY_PRINT);
        return;
    }

    $lp = in_array('_lp', array_keys(filter_input_array(INPUT_GET)));
    $productos = new PostController();
    $result = $productos->getProductsToHome(4);
    if(!$result){
        $json["response"] = "internal server error or auth denied";
        echo json_encode($json, JSON_PRETTY_PRINT);
        return;
    }
    print_r($result);


} catch(Exception $e) {
    $json["response"] = "internal server error";
    echo json_encode($json, JSON_PRETTY_PRINT);
}
<?php
namespace app;

require_once "../../autoloader.php";

use Controllers\Middleware;
use Controllers\PostController as PostController;
//use app\PasswordHash;
require('../../libraries/phpass-master/PasswordHash.php');

try{
    $pwdHasher = new PasswordHash(8, FALSE);
    $autorization = new Middleware();
    $api = new Middleware();
    $_HEADERS = apache_request_headers();
    $contentCatalogo = $api->autorization($_HEADERS, $pwdHasher);
    if(!$contentCatalogo){
        $json["response"] = "No hay contenido que mostrarte";
        echo json_encode($json, JSON_PRETTY_PRINT);
        return;
    }

    $tp = in_array('_tp', array_keys(filter_input_array(INPUT_GET)));
    if($tp){
        $productos = new PostController();
        $type = filter_input(INPUT_GET, '_tp');
        $result = $productos->getProductsToClient($type);
        if(!$result){
            $json["response"] = "internal server error or auth denied";
            echo json_encode($json, JSON_PRETTY_PRINT);
            return;
        }
        print_r($result);
    }

}catch(Exception $e){
    $json["response"] = "internal server error";
    echo json_encode($json, JSON_PRETTY_PRINT);
}
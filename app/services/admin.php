<?php
namespace app;

require_once "../autoloader.php";
use Controllers\auth\LoginController as LoginController;
require_once "../../vendor/autoload.php";

try{
    if(!isset($_POST['_login'])){
        $json["response"] = "form params incomplete";
        echo json_encode($json, JSON_PRETTY_PRINT);
        return;
    } elseif(isset($_POST['_login'])){
        $login = in_array('_login',array_keys(filter_input_array(INPUT_POST)));
        $datos = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
        $userLogin = new LoginController();
        //Guardar Token
        $session = $userLogin->AdminAuth($datos);
        print_r($session);
        return;
    } 
} catch(Exception $e) {
    $json["response"] = "internal server error";
    echo json_encode($json, JSON_PRETTY_PRINT);
}
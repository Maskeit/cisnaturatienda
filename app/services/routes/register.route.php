<?php
namespace app;

require_once "../../autoloader.php";
use Controllers\auth\LoginController as LoginController;
require_once "../../../vendor/autoload.php";

try{
    if(!isset($_POST['_register'])){
        $json["response"] = "form params incomplete";
        echo json_encode($json, JSON_PRETTY_PRINT);
        return;
    }else if(isset($_POST['_register'])){
        //print_r("recibido");
        $register = in_array('_register',array_keys(filter_input_array(INPUT_POST)));
        $datos = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
        $userRegister = new LoginController();
        //Guardar Token
        $session = $userRegister->userRegister($datos); //Guardar Tokenthis method comins from 'LoginController.php'
        print_r($session); //esto imprime los datos de la sesion creada como el ssk, el token y el nnombre del archivo .json        
        return;
    }
}catch(Exception $e) {
    $json["response"] = "internal server error";
    echo json_encode($json, JSON_PRETTY_PRINT);
}
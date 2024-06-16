<?php

namespace Controllers\auth;

use Models\user;
use Models\address;
use Models\product_order;
use Model\api;
use Model\binnacle;
use Controllers\Middleware;
use Controllers\auth\Session;

class LoginController
{
    public $sv; //Sesión válida
    public $name;
    public $email;
    public $id;
    public $tipo;
    public function __construct()
    {
        $this->sv = false;
    }

    public function userRegister($datos)
    {
        $user = new user();
        //verificamos si ya existe un usuario con el mismo correo electronico
        $result = $user->where([["email", $datos["email"]]])->get();
        if (count(json_decode($result)) > 0) {
            //No se registra la sesión porque ya existe alguno
            return json_encode(["r" => false]);
        } else {
            $pass = $datos['passwd'];
            $encpass = password_hash($pass, PASSWORD_BCRYPT);
            $user->valores = [
                $datos['name'],
                $datos['email'],
                $encpass
            ];            
            $result = $user->create();
            return json_encode(["r" => true]);
            die;
        }
    }


    public function userAuth($datos)
    {
        $user = new user();
        $MW = new Middleware();
        $Session = new Session();
        $passbtoa = $datos['passwd'];
        
        $pass = $MW->atob($passbtoa);//descifrate password by atob Method
        $email = $datos['email'];
        $result = $user->where([["email", $email]])->get();
        if (count(json_decode($result)) > 0) {
            $data = json_decode($result, true);
            $userId = $data[0]['id'];
            $encpass = $data[0]['passwd'];
            $role = $data[0]['tipo'];
            $active = $data[0]['active'];
            $name = $data[0]['name'];

            if (
                (password_verify($pass, $encpass)) && 
                ($role === '2') && ($active === '1')
            ) {
                $_HEADERS = apache_request_headers();
                $HTTP_USER_AGENT = $_HEADERS['User-Agent'];
                $session = $Session->createSession($email,$userId,$role,$name,$HTTP_USER_AGENT);                    
                return $session;
            }
            if(
                !(password_verify($pass, $encpass)) || 
                (!(password_verify($pass, $encpass)) && 
                !($role === '2')) || !$active !== '1') 
            {                
                echo json_encode(["error" => 'Failed auth']);
                return null;
            }
        } else {            
            echo json_encode(["r" => false]);
            return null;
        }
    }

    public function AdminAuth($datos){
        $user = new user();
        $MW = new Middleware();
        $Session = new Session();
        $passbtoa = $datos['passwd'];
        
        $pass = $MW->atob($passbtoa);//descifrate password by atob Method
        $email = $datos['email'];
        $result = $user->where([["email", $email]])->get();        
        if (count(json_decode($result)) > 0) {
            $data = json_decode($result, true);
            $userId = $data[0]['id'];
            $encpass = $data[0]['passwd'];
            $role = $data[0]['tipo'];
            $active = $data[0]['active'];
            $name = $data[0]['name'];
            if(
                (password_verify($pass, $encpass)) && 
                ($role === '1') && ($active === '1')
            ){                    
                $_HEADERS = apache_request_headers();
                $HTTP_USER_AGENT = $_HEADERS['User-Agent'];
                $session = $Session->createSession($email,$userId,$role,$name,$HTTP_USER_AGENT);
                return $session;
            }
            if(
                !(password_verify($pass, $encpass)) || 
                (!(password_verify($pass, $encpass)) && 
                !($role === '1')) || !$active !== '1') 
            {                
                echo json_encode(["error" => 'Failed auth']);
                return;
            }
        } else {
            echo json_encode(["r" => false]);
            return;
        }
    }
    public function sessionDestroy($jsonName, $userId) {
        $Session = new Session();        
        $result = $Session->deleteSession($jsonName, $userId);
        if(!$result){
            return false;
        }
        return true;
    }
        
    /*******DOMICILIO DEL CLIENTE GUARDADO  *********/
    //Crea una instancia para el domicilio del cliente
    public function saveAddress($datos)
    {
        $address = new address();
        $address->valores = [
            $datos['userId'],
            $datos['fullName'],
            $datos['telefono'],
            $datos['colonia'],
            $datos['calle'],
            $datos['estado'],
            $datos['ciudad'],
            $datos['postalcode']
        ];
        $result = $address->create();
        return $result;
    }

    //busca si el usuario ya tiene un domicilio registrado
    public function findAddressByUserId($uid)
    {
        $address = new address();
        $result = $address->where([["userId", $uid]])
            ->get();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    //busca si el usuario ya tiene un domicilio registrado
    public function findAddressByid($id)
    {
        $address = new address();
        $result = $address->where([["id", $id]])
            ->get();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }


    public function deleteAddress($aid)
    {
        $address = new address();
        $result = $address->delete($aid);
        return $result;
    }

    public function getData($pdi)
    { // "personal data id"
        $datos = new user();
        $result = $datos->select(['*'])
            ->where([['id', $pdi]])
            ->get();
        return $result;
    }
}

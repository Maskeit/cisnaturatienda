<?php

namespace Controllers;

use Controllers\auth\LoginController;
use Controllers\auth\Session;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Models\api;
use Models\user;
use Models\binnacle;
use Models\privileges;
use ReturnTypeWillChange;

// use Dotenv\Dotenv;
// //traemos la llave creada
// $dotenv = Dotenv::createImmutable(__DIR__);
// $dotenv->load();

class Middleware
{
	private $key;

	public function __construct()
	{
		$this->key = 'agko+PA3jjWdmZJcXmloAlOUNMLJLcKv+g0+NkDahCI=';
	}

	public function V_Global()
	{
		return 'http://localhost/cisnaturatienda/';
	}
		//METODO PARA AUTORIZAR UN USUARIO A ACCEDER A RUTAS Y MANTENER SU SESION
	// este es para autorizar al usuario a toda la pagina, incluso ver si mantiene iniciada la sesion en el navegador
	public function apiEnabled($_HEADERS, $pwdHasher){
		if(!$_HEADERS) return false;
		try {
			// Checking if the API is enabled to receive petitions
			$api = new api();
			$apiStatus = $api->select()
							 ->where([['name', 'api status']])
							 ->get();
			$apiRes = json_decode($apiStatus, true);
			// print_r($apiRes[0]['value']);
			if ( $apiRes[0]['value'] === 'enabled' ) return true;
			return false;
		} catch (\Throwable $th) {
			// Manejar la excepción como sea apropiado
			error_log('Error checking API status: ' . $th->getMessage());
			return false;
		}
	}
	public function logout($_HEADERS,$pwdHasher,$userId) //debe ser con el id pero sacado de larchivo .json
	{
		$checkApi = $this->apiEnabled($_HEADERS,$pwdHasher);
		if(!$checkApi) return false;

		$session = new Session();
		$terminarSession = $session->deleteSession($userId); 
		return;
	}

	//Method to generate token
	public function createToken($email, $userId, $role)
	{
		$payload = [
			'userId' => $userId,
			'email' => $email,
			'role' => $role
		];

		$jwt = JWT::encode($payload, $this->key, 'HS256');
		$jwtDecoded = JWT::decode($jwt, new Key($this->key, 'HS256'));
		return $jwt;
	}
	//Method to generate a token
	public function token($bytes)
	{
		if (!$bytes) $bytes = 128; //Default token bytes
		return base64_encode(
			random_bytes($bytes)
		);
	}
	//Method to generate the json names
	public function json($byte)
	{
		$bytes = random_bytes(20);
		return bin2hex($bytes);
	}

	//Method to get the server time
	public function getTime()
	{
		date_default_timezone_set("America/Mexico_City");
		$year = date('Y-m-d', time());
		$hour = date('H:i:s', time());
		return $year . ' ' . $hour; //example -> 2021-01-20 21:01:33
	}
	//method to desifrate codes
	public function atob($string)
	{
		try {
			if (!$string) return 'params incomplete';
			return base64_decode($string);
		} catch (Exception $e) {
			return 'internal server error';
		}
	}

	//method to cifrate text
	public function btoa($string)
	{
		try {
			if (!$string) return 'params incomplete';
			return base64_encode($string);
		} catch (Exception $e) {
			return 'internal server error';
		}
	}
	// Default method for bring default data or general products
	public function defaultAutorization($_HEADERS)
	{
		if (!$_HEADERS) return false;
		try {
			//Checkin if the api is enabled to receive petitions
			$api = new api();
			$apiStatus = $api->select()
				->where([['name', 'api status'], ['value', 'enabled']])
				->get();
			if (!$apiStatus) return;

			if ($apiStatus) return true;
		} catch (\Throwable $th) {
			echo 'error: ' . $th;
		}
	}

	public function autorization($_HEADERS, $pwdHasher)
	{
		//making the main validations
		if (!$_HEADERS) return false;
		try {
			$checkApi = $this->apiEnabled($_HEADERS,$pwdHasher);
			if(!$checkApi) return false;
			// Hasta aqui la api deberia aceptar peticiones
			if (
				(!isset($_HEADERS['Authorization'])) ||
				(!isset($_HEADERS['User-Agent']))
			) return false;

			//Autorization validations
			$autorization = json_decode(
				base64_decode($_HEADERS['Authorization']),
				true
			);
			if (
				(!isset($autorization['APISS__NME'])) || //session file name
				(!isset($autorization['SSK'])) || //session key
				(!isset($autorization['SSID'])) //session id
			) return false;
			$APISS__NME = $autorization['APISS__NME'];
			//looking for the session json file -> APISS
			// $sessionFile = __DIR__ . '/../secure/sessions/' . $APISS__NME . '.json';
			$sessionFile = __DIR__ . '/../secure/sessions/'. $APISS__NME . '.json';
			//print_r($sessionFile);
			$time = $this->getTime();

			if (!file_exists($sessionFile)) {
				//print_r("No existe el archivo json.");
				$binnacle = new binnacle();				
				$binnacle->valores = [
					'autorization middleware',
					'session file not found: ' . $autorization['APISS__NME'],
					'premature',
					'system',
					$time
				];
				$binnacle->create();				
				return false;
			}
			//print_r($sessionFile);
			//we have to extract the information to make a validation if the user has the privileges
			$file = fopen($sessionFile, "r");
			$line = json_decode(fgets($file), true);
			$SSID = $line['session']['token'];
			$SSK = $line['sessionkey'];
			$userAgent = $line['session']['userAgent'];//chorme v9.5 vu221
			$id = $line['session']['id'];
			fclose($file);

			$SSKBrowser = $autorization['SSK'];
			$SSIDBrowser = $autorization['SSID'];
			// print_r('<h5>SSKbrowser:</h5>' . $SSKBrowser . '<br>');
			// print_r('<h5>SSKfile: '.$SSK . '</h5><br>');

			// print_r('<h5>SSIDfile: '.$SSID . '</h5><br>');
			// print_r('<h5>SSIDBrowser: '.$SSIDBrowser. '</h5><br>');
			//validation of the property SSID -> session ID
			if($SSID != $autorization['SSID']){
				$binnacle = new binnacle();	
				print_r("Propiedad SSID denied");							
				$binnacle->valores = [					
					'autorization middleware',
					'the property SSID has been denied, json: ' . $SSID . ', headers: ' . $autorization['SSID'], 
					'auth SSID id:'. $id,
					'system',
					$time
				];
				$binnacle->create();
				return false;
			}
			
			//print_r($userAgent . '<br>');
			//print_r($_HEADERS['User-Agent'] . '<br>');
			//validation of the proeprty APISS__NME -> data of the user's browser
			if($userAgent != $_HEADERS['User-Agent']){
				print_r("El navegador no cumple los requisitos" . "<br>");
				$binnacle = new binnacle();				
				$binnacle->valores = [			
					'autorization middleware', 
					'the property User-Agent has been denied, json: ' . $APISS__NME . ', headers: ' . $_HEADERS['User-Agent'], 
					'user agent id:' . $id,
					'system',
					$time
				];
				$binnacle->create();
				return false;
				//user agent validation
			}
		
			//cheking if the key encripted in the frontent is the key that we keep in the bakend....
			// $verification = $pwdHasher->CheckPassword($SSK, $autorization['SSK']);
			// print_r($verification);
			if($SSK !== $autorization['SSK']){
				$binnacle = new binnacle();				
				$binnacle->valores = [					
					'autorization middleware', 
					'the property SSK has been denied, json: ' . $APISS__NME . ', headers: ' . $autorization['SSK'], 
					'auth SSK',
					'system',
					$time
				];
				$binnacle->create();
				return false;//token assigned
			}

			//user acces validation from the database active
			$user = new user();
			$result = $user->select(['active','tipo'])->where([['id',$id]])->get();
			if(!$result){
				return false;			
			}else{
				$resArr = json_decode($result,true);
				if(!empty($resArr)){
					$active = $resArr[0]['active'];
					$tipo = $resArr[0]['tipo'];
				}
			}
			if($active != 1){
				print_r("Estado de cuenta 0");
				$binnacle = new binnacle();				
				$binnacle->valores = [
					'autorization middleware',
					'request denied, status account: 0', 
					'URGENT idUser:' . $id,
					'system',
					$time
				];
				$binnacle->create();
				return false;
			}

			//now we are going to validate if the user has the privileges to execute the actually route...
			$request_uri = $_SERVER["REQUEST_URI"];
			$privileges = new privileges();
			$result_uri = $privileges->where([['route', $request_uri]])->get();
			if(!$result_uri) return false;
			$resPrivileges = json_decode($result_uri, true);
			$access = $resPrivileges[0]['access'];
			$user_type = $resPrivileges[0]['user_type'];

			if($user_type !== $tipo || $access !== '1'){
				print_r("No tienes permisos para ejecutar ruta");
				$binnacle = new binnacle();
				$binnacle->valores = [
					'autorization middleware',
					'Urgent request denied, this user doesn´t have permissions to execute the next request: ' . $request_uri,
					'URGENT id: '. $id,
					'system',
					$time
				];
				$binnacle->create();				
				return false;
			}

			return true;
		} catch (\Throwable $th) {
			//throw $th;
			echo 'error: ' . $th;
		}
	}

}

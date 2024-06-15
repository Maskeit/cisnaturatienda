<?php
namespace Controllers\auth;

use Controllers\Middleware;
require('session-register.php');

	/*
		Method to generate a unic token formed by other internal tokens, it's necessary to use "Middleware.php" to work with this file...
	*/
	class Session{

	public function createSession(
		$email,
		$userId,
		$role,
		$name,
		$HTTP_USER_AGENT
	){
		try{
            $MW = new Middleware();
			//esta se crea con JWT
			$token = $MW->createToken($email,$userId,$role);//SSID -> token saved in the session file

			$sessionKey = $MW->token(128);//SSK -> key to keep in the sesion file
			$jsonFile = $MW->json(24);//FSS__NAME -> file session's name
			
			$sessionTree = __DIR__ . '/../../secure/structure/empty-session-file.json';
			$sessionPath = __DIR__ . '/../../secure/sessions/';

			if(!
				copy(
					$sessionTree, 
					$sessionPath . $jsonFile . '.json'
				)
			) return false;

			/*
			this will be the structure that we will keep in a new session file
			*/
			$createdAt = $MW->getTime();//20240212 100300
			$structure = array(
				"sessionkey" => $sessionKey,
				"at" => $createdAt,
				"session" => array(
					"token" => $token,
					"userAgent" => $HTTP_USER_AGENT,
					"id" => $userId,
					"name" => $name,
					"email" => $email,
					"json" => $jsonFile . '.json'
				)
			);
			$file = fopen(
				$sessionPath . $jsonFile . '.json', 
				'w'
			);
			fwrite(
				$file, 
				json_encode($structure)
			);
			fclose($file);

			//now, we register the session in the database -> session.table
			$register = sessionRegisterDB(
				$userId,
				$jsonFile, 
				$createdAt
			);

			if(!$register) return false;
			
			$array = array(
				"SSID" => $token,
				"SSK" => $sessionKey,
				"APISS__NME" => $jsonFile
			);
			//si todo sale bien entonces regresa un array con los 3 datos a userAuth en LoginController
			return json_encode($array);

		}catch(Exception $e) {
		    return false;
		}
	}

	//falta mejorar este metodo porque no elimina el registro en el codigo fuente
	public function deleteSession($json, $userId) {
		$filename = sessionDeleteDB($json, $userId);
		if (!$filename) return false;
		
		$sessionPath = __DIR__ . '/../../secure/sessions/' . $filename . '.json';
		if (file_exists($sessionPath) && unlink($sessionPath)) {
			return true;
		} else {
			echo ("Failed to delete session file: $sessionPath");
			return false;
		}
	}
		
}

?>
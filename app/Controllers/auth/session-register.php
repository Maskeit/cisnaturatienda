<?php
namespace Controllers\auth;
use Models\sessions;

use function PHPSTORM_META\type;

	//Method to register a new session in the database
	function sessionRegisterDB($userId,$json, $date){
		if(
			(!$userId) || 
			(!$json) || 
			(!$date)
		) return 'error: params incomplete';
		
		$nsession = new sessions();
		$nsession -> valores = [
			$userId,
			$json . '.json', 
			$date
		];

		$res = $nsession->create();
		if(!$res){
			return false;
		}
		return true;
	}

	//Method to delete a session from the database
	function sessionDeleteDB($json, $userId) {
		$nsession = new sessions();
		$result = $nsession->where([['user', $userId]])->get();
		$id = "";
		$data = json_decode($result, true);			
		if (!empty($data)) {
			foreach ($data as $session) {
				if ($session['json'] == $json . '.json') {
					$id = $session['id'];					
					break;
				}
			}
			if ($nsession->delete($id)) {
                return true;
            } else {
                return false;
            }
		} else {
			echo "No sessions found for user ID: " . $userId;
		}	
	}

?>
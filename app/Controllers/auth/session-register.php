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
	function deleteSessionDB($json, $userId) {
		$nsession = new sessions();
		$result = $nsession->where([['user', $userId], ['json', $json]])->get();
		if (!$result) return false;
	
		$data = json_decode($result, true);
		if (empty($data)) return false;
	
		$jsonFilename = $data[0]['json'];
		if ($nsession->delete(['_id' => $data[0]['_id']])) {
			return $jsonFilename;
		} else {
			return false;
		}
	}
	
	

?>
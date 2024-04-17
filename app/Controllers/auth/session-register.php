<?php
namespace Controllers\auth;
use Models\sessions; 
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
		return "done";
	}

	//Method to delete a session from the database
	function deleteSessionDB($userId){
		if((!$userId)) return 'error: params incomplete';
		
		$nsession = new sessions();
		$result = $nsession->deleteMore([['userId', $userId]]);
		return $result;
	}

?>
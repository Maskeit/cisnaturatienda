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
		if(!$userId) {
			error_log("deleteSessionDB: User ID is incomplete or null.");
			return 'error: params incomplete';
		}
	
		$nsession = new sessions();
		$result = $nsession->where([['user', $userId]])->get();
	
		if(!$result) {
			error_log("deleteSessionDB: No session found for user ID: $userId");
			return false;
		}
	
		$data = json_decode($result, true);
		if (empty($data)) {
			error_log("deleteSessionDB: No data found for user ID: $userId in session table.");
			return false;
		}
	
		$json = $data[0]['json'];
		print_r("Session JSON filename: " . $json); // Just for debugging; consider removing or changing to error_log in production.
	
		// Attempt to delete the session record from the database
		$result = $nsession->deleteMore([['_id', $data[0]['_id']]]);
		if(!$result) {
			error_log("deleteSessionDB: Failed to delete session for user ID: $userId");
			return false;
		}
	
		return $json; // Return the JSON filename for deletion
	}
	

?>
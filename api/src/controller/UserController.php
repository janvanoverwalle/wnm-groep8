<?php

require_once(dirname(__FILE__) . "/../config/Database.php");
include(dirname(__FILE__) . "/../model/User.php");

class UserController {
	
	public static function findUserById($id) {
		// SELECT user
		$sth = Database::get()->prepare("SELECT * FROM user WHERE id = :id ");
		$sth->bindParam(':id', $id);
		$sth->execute();
		$user = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		return $user;
	}
	
	public static function findUserByIdJSON($id) {
		// SELECT user
		$user = findUserById($id);

		if ($user != null) {
			// prepare json object ('user' = User)
			$json_array = array("user" => $user);
		
			return $json_array;
		}
		
		return null;// Or throw exception
	}
	
}

?>
<?php

require_once(dirname(__FILE__) . "/../config/Database.php");
include_once(dirname(__FILE__) . "/../model/User.php");
include_once(dirname(__FILE__) . "/HabitController.php");

class UserController {
	
	public static function findUserById($id) {
		// SELECT user
		$sth = Database::get()->prepare("SELECT * FROM user WHERE id = :id");
		$sth->bindParam(':id', $id);
		$sth->execute();
		$user_arr = $sth->fetch(PDO::FETCH_ASSOC);
		
		$user = new User($id, $user_arr['name']);
		
		$habits = HabitController::findHabitsByUserId($id);
		
		$user->setHabits($habits);
		
		return $user->expose();
	}
	
	public static function findAllUsers() {
		// SELECT users
		$sth = Database::get()->prepare("SELECT * FROM user");
		$sth->execute();	
		$user_arr = $sth->fetchAll(PDO::FETCH_ASSOC);

		$users = [];
		
		foreach ($user_arr as $user) {
			$u = new User($user['id'], $user['name']);
			$habits = HabitController::findHabitsByUserId($u->getId());
			$u->setHabits($habits);
			
			$users[] = $u->expose();
		}
		
		return $users;
	}
	
	public static function insertUser($name) {
		//Insert into
		$sth = Database::get()->prepare("INSERT INTO user(name) VALUES (:name)");
		$sth->bindParam(':name', $name);
		$sth->execute();

		if ($sth) {
			$stmt = Database::get()->query("SELECT LAST_INSERT_ID()");
			$lastId = $stmt->fetch(PDO::FETCH_NUM);
			$lastId = $lastId[0];

			$user = new User($lastId, $name);

			return $user->expose();
		}
		
		return null;
	}
	
}

?>
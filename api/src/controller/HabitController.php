<?php

require_once(dirname(__FILE__) . "/../config/Database.php");
include(dirname(__FILE__) . "/../model/Habit.php");

class HabitController {
	
	public static function findHabitsByUserId($uid) {
		// SELECT habit
		$sth = Database::get()->prepare("SELECT * FROM user_habits uh JOIN habit h ON uh.habit_id = h.id WHERE user_id = :id ");
		$sth->bindParam(':id', $uid);
		$sth->execute();
		$habits = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		foreach ($user_habits as $habit) {
			$h = new Habit($habit['id'], $habit['description']);
			$habits[] = $h->expose();
		}
		
		return $habits;
	}
	
	public static function findHabitsByUserIdJSON($uid) {
		// SELECT habit
		$habits = findHabitByUserId($uid);

		if ($habits != null) {
			// prepare json object ('habit' = Habit)
			$json_array = array("habits" => $habits);
		
			return $json_array;
		}
		
		return null;// Or throw exception
	}
	
}

?>
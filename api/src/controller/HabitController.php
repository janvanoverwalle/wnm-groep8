<?php

require_once(dirname(__FILE__) . "/../config/Database.php");
include_once(dirname(__FILE__) . "/../model/Habit.php");

class HabitController {
	
	public static function findAllHabits() {
		// SELECT all habits
		$sth = Database::get()->prepare("SELECT * FROM habit");
		$sth->bindParam(':id', $uid);
		$sth->execute();
		$habits_arr = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		// variable declaration
		$habits = [];

		foreach ($habits_arr as $habit) {
			$habits[] = (new Habit($habit['id'], $habit['description']))->expose();
		}
		
		return $habits;
	}
	
	public static function findHabitsByUserId($uid) {
		// SELECT user habits
		$sth = Database::get()->prepare("SELECT h.* FROM user_habits uh JOIN habit h ON uh.habit_id = h.id WHERE user_id = :id");
		$sth->bindParam(':id', $uid);
		$sth->execute();
		$habits_arr = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		$habits = [];
		
		foreach ($habits_arr as $habit) {
			$habits[] = (new Habit($habit['id'], $habit['description']))->expose();
		}
		
		return $habits;
	}
	
	public static function findHabitsReachedByUserId($uid) {
		// SELECT user habits reached
		$sth = Database::get()->prepare("SELECT hr.*, h.description FROM habit_reached hr JOIN habit h ON hr.habit_id_id = h.id WHERE user_id_id = :id");
		$sth->bindParam(':id', $uid);
		$sth->execute();
		$habits_reached = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		return $habits_reached;
	}	
}

?>
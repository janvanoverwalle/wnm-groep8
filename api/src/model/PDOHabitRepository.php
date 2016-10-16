<?php

namespace model;

class PDOHabitRepository implements HabitRepository {
    private $connection = null;

    public function __construct(\PDO $connection) {
        $this->connection = $connection;
    }

	public function findHabitById($id) {
		try {
			// SELECT habit
			$stmt = $this->connection->prepare("SELECT * FROM habit WHERE id = :id");
			$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
			$stmt->execute();
			$results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			
			if (count($results) <= 0) {
				return null;
			}
			
			return new Habit($results[0]['id'], $results[0]['description']);
		}
		catch (\Exception $e) {
			return null;
		}
    }
	
    public function findAllHabits() {		
		try {
			// SELECT user
			$stmt = $this->connection->prepare("SELECT * FROM habit");
			$stmt->execute();
			$results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			
			if (count($results) <= 0) {
				return null;
			}
			
			$habits = [];
			foreach ($results as $habit) {
				$habits[] = new Habit($habit['id'], $habit['description']);
			}
			
			return $habits;
		}
		catch (\Exception $e) {
			return null;
		}
    }
	
	public function findHabitsByUserId($uid) {
		try {
			// SELECT user habits
			$stmt = $this->connection->prepare("SELECT h.* FROM user_habits uh JOIN habit h ON uh.habit_id = h.id WHERE user_id = :id");
			$stmt->bindParam(':id', $uid);
			$stmt->execute();
			$results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			
			if (count($results) <= 0) {
				return null;
			}
			
			$habits = [];			
			foreach ($results as $habit) {
				$habits[] = new Habit($habit['id'], $habit['description']);
			}
			
			return $habits;
		}
		catch (\Exception $e) {
			return null;
		}
	}
	
	public function findHabitByIdAndUserId($hid, $uid) {
		try {
			// SELECT user habits
			$stmt = $this->connection->prepare("SELECT h.* FROM user_habits uh JOIN habit h ON uh.habit_id = h.id WHERE user_id = :uid AND habit_id = :hid");
			$stmt->bindParam(':hid', $hid);
			$stmt->bindParam(':uid', $uid);
			$stmt->execute();
			$results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			
			if (count($results) <= 0) {
				return null;
			}
			
			return new Habit($results[0]['id'], $results[0]['description']);
		}
		catch (\Exception $e) {
			return null;
		}
	}
	
	public function findHabitsReachedByUserId($uid) {
		try {
			// SELECT user habits reached
			$stmt = $this->connection->prepare("SELECT hr.*, h.description FROM habit_reached hr JOIN habit h ON hr.habit_id_id = h.id WHERE user_id_id = :id");
			$stmt->bindParam(':id', $uid);
			$stmt->execute();
			$results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			
			if (count($results) <= 0) {
				return null;
			}
			
			return $results;
		}
		catch (\Exception $e) {
			return null;
		}
	}	
}

?>
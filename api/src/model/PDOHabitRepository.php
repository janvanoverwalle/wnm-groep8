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
			// SELECT all habits
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
	
	public function insertHabit($habit) {
		if (is_string($habit)) {
			$habit = new Habit(-1, $habit);
		}
		
		try {
			//INSERT new habit
			$stmt = $this->connection->prepare("INSERT INTO habit(description) VALUES (:description)");
			$stmt->bindParam(':description', $habit->getDescription());
			$stmt->execute();

			if ($stmt) {
				$stmt = $this->connection->query("SELECT LAST_INSERT_ID()");
				$lastId = $stmt->fetch(\PDO::FETCH_NUM);
				$lastId = $lastId[0];

				return new Habit($lastId, $habit->getDescription());
			}
			
			return null;
		}
		catch (\Exception $e) {
			return null;
		}
	}
	
	public function insertUserHabit($uid, $hid) {		
		$userHabit = $this->findHabitByIdAndUserId($hid, $uid);
		if ($userHabit != null) {
			return null;
		}
		
		try {
			//INSERT new user habit
			$stmt = $this->connection->prepare("INSERT INTO user_habits(user_id, habit_id) VALUES (:uid, :hid)");
			$stmt->bindParam(':uid', $uid);
			$stmt->bindParam(':hid', $hid);
			$stmt->execute();

			if ($stmt) {
				$userHabit = $this->findHabitByIdAndUserId($hid, $uid);

				return $userHabit;
			}
			
			return null;
		}
		catch (\Exception $e) {
			return null;
		}
	}
	
	public function deleteHabitById($id) {
		$habit = $this->findHabitById($id);
		if ($habit == null) {
			return null;
		}
		
		try {
			// DELETE habit
			$stmt = $this->connection->prepare("DELETE FROM habit WHERE id = :id");
			$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
			$stmt->execute();
			
			if ($stmt) {
				return $habit;
			}
			
			return null;
		}
		catch (\Exception $e) {
			return null;
		}
    }
	
	public function deleteHabitByIdAndUserId($hid, $uid) {
		$userHabit = $this->findHabitByIdAndUserId($hid, $uid);
		if ($userHabit == null) {
			return null;
		}
		
		try {
			// DELETE habit
			$stmt = $this->connection->prepare("DELETE FROM user_habits WHERE habit_id = :hid AND user_id = :uid");
			$stmt->bindParam(':hid', $hid, \PDO::PARAM_INT);
			$stmt->bindParam(':uid', $uid, \PDO::PARAM_INT);
			$stmt->execute();
			
			if ($stmt) {
				return $userHabit;
			}
			
			return null;
		}
		catch (\Exception $e) {
			return null;
		}
    }

	public function updateHabitById($habit) {
		$habit = new Habit($habit->id, $habit->description);
		
		try {
			//UPDATE habit
			$stmt = $this->connection->prepare("UPDATE habit SET description=:description WHERE id=:id");
			$stmt->bindParam(':id', $habit->getId());
			$stmt->bindParam(':description', $habit->getDescription());
			$stmt->execute();

			if ($stmt) {
				return $habit;
			}
			
			return null;
		}
		catch (\Exception $e) {
			return null;
		}
	}
	
	public function updateHabitByIdAndUserId($uid, $oldHId, $newHId) {		
		try {
			//UPDATE user habit
			$stmt = $this->connection->prepare("UPDATE user_habits SET user_id=:uid, habit_id=:newHId WHERE user_id=:uid AND habit_id=:oldHId");
			$stmt->bindParam(':uid', $uid);
			$stmt->bindParam(':oldHId', $oldHId);
			$stmt->bindParam(':newHId', $newHId);
			$stmt->execute();

			if ($stmt) {
				$userHabit = $this->findHabitByIdAndUserId($newHId, $uid);
				return $userHabit;
			}
			
			return null;
		}
		catch (\Exception $e) {
			return null;
		}
	}
}

?>
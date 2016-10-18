<?php

namespace model;

class PDOUserRepository implements UserRepository
{
    private $connection = null;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findUserById($id) {
		try {
			// SELECT user
			$stmt = $this->connection->prepare("SELECT * FROM user WHERE id = :id");
			$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
			$stmt->execute();
			$results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			
			if (count($results) <= 0) {
				return null;
			}
			
			return new User($results[0]['id'], $results[0]['name']);
		}
		catch (\Exception $e) {
			return null;
		}
    }
	
	public function findAllUsers() {
		try {
			// SELECT all users
			$stmt = $this->connection->prepare("SELECT * FROM user");
			$stmt->execute();	
			$results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

			if (count($results) <= 0) {
				return null;
			}
			
			$users = [];
			
			foreach ($results as $user) {
				$users[] = new User($user['id'], $user['name']);
				// $habits = HabitController::findHabitsByUserId($u->getId());
				// $u->setHabits($habits);
			}
			
			return $users;
		}
		catch (\Exception $e) {
			return null;
		}
	}
	
	public function insertUser($user) {
		if (is_string($user)) {
			$user = new User(-1, $user);
		}
		
		try {
			//INSERT new user
			$stmt = $this->connection->prepare("INSERT INTO user(name) VALUES (:name)");
			$stmt->bindParam(':name', $user->getName());
			$stmt->execute();

			if ($stmt) {
				$stmt = $this->connection->query("SELECT LAST_INSERT_ID()");
				$lastId = $stmt->fetch(\PDO::FETCH_NUM);
				$lastId = $lastId[0];

				return new User($lastId, $user->getName());
			}
			
			return null;
		}
		catch (\Exception $e) {
			return null;
		}
	}
	
	public function deleteUserById($id) {
		$user = $this->findUserById($id);
		if ($user == null) {
			return null;
		}
		
		try {
			// DELETE user
			$stmt = $this->connection->prepare("DELETE FROM user WHERE id = :id");
			$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
			$stmt->execute();
			
			if ($stmt) {
				return $user;
			}
			
			return null;
		}
		catch (\Exception $e) {
			return null;
		}
    }

	public function updateUserById($user) {
		$user = new User($user->id, $user->name);
		
		try {
			//UPDATE user
			$stmt = $this->connection->prepare("UPDATE user SET name=:name WHERE id=:id");
			$stmt->bindParam(':id', $user->getId());
			$stmt->bindParam(':name', $user->getName());
			$stmt->execute();

			if ($stmt) {
				return $user;
			}
			
			return null;
		}
		catch (\Exception $e) {
			return null;
		}
	}
}

?>
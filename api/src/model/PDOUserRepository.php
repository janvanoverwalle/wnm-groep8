<?php

namespace model;

class PDOUserRepository implements UserRepository
{
    private $connection = null;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

	private function createNewUserFromResults($results) {
		$user = new User();
		$user->setId($results['id']);
		$user->setName($results['name']);
		$user->setSurname($results['surname']);
		$user->setUsername($results['username']);
		$user->setUsernameCanonical($results['username_canonical']);
		$user->setEmail($results['email']);
		$user->setEmailCanonical($results['email_canonical']);
		$user->setEnabled($results['enabled']);
		$user->setSalt($results['salt']);
		$user->setPassword($results['password']);
		$user->setLastLogin(new \DateTime($results['last_login']));
		$user->setLocked($results['locked']);
		$user->setExpired($results['expired']);
		$user->setExpiresAt(new \DateTime($results['expires_at']));
		$user->setConfirmationToken($results['confirmation_token']);
		$user->setPasswordRequestedAt($results['password_requested_at']);
		$user->setRoles($results['roles']);
		$user->setCredentialsExpired($results['credentials_expired']);
		$user->setCredentialsExpireAt(new \DateTime($results['credentials_expire_at']));
		return $user;
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
			
			//return new User($results[0]['id'], $results[0]['name'], $results[0]['roles']);

			return $this->createNewUserFromResults($results[0]);
		}
		catch (\Exception $e) {
			return null;
		}
    }
	
	public function findUserByUsername($username) {
		try {
			// SELECT user
			$stmt = $this->connection->prepare("SELECT * FROM user WHERE username = :username");
			$stmt->bindParam(':username', $username, \PDO::PARAM_STR);
			$stmt->execute();
			$results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			
			if (count($results) <= 0) {
				return null;
			}
			
			return $this->createNewUserFromResults($results[0]);
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
				$users[] = $this->createNewUserFromResults($user);
				// $habits = HabitController::findHabitsByUserId($u->getId());
				// $u->setHabits($habits);
			}
			
			return $users;
		}
		catch (\Exception $e) {
			return null;
		}
	}
	
	public function insertUser(User $user) {
        try {
			//INSERT new user
			$stmt = $this->connection->prepare(
				"INSERT INTO user(name, surname, username, username_canonical, email, email_canonical, enabled, salt, password, locked, expired, roles, credentials_expired)
				VALUES (:name, :surname, :username, :username_canonical, :email, :email_canonical, :enabled, :salt, :password, :locked, :expired, :roles, :credentials_expired)");
            $stmt->bindParam(':name', $user->getName(), \PDO::PARAM_STR);
			$stmt->bindParam(':surname', $user->getSurname(), \PDO::PARAM_STR);
			$stmt->bindParam(':username', $user->getUsername(), \PDO::PARAM_STR);
			$stmt->bindParam(':username_canonical', $user->getUsernameCanonical(), \PDO::PARAM_STR);
			$stmt->bindParam(':email', $user->getEmail(), \PDO::PARAM_STR);
			$stmt->bindParam(':email_canonical', $user->getEmailCanonical(), \PDO::PARAM_STR);
			$stmt->bindParam(':enabled', $user->isEnabled() ? 1 : 0, \PDO::PARAM_INT);
			$stmt->bindParam(':salt', $user->getSalt(), \PDO::PARAM_STR);
			$stmt->bindParam(':password', $user->getPassword(), \PDO::PARAM_STR);
			$stmt->bindParam(':locked', $user->isLocked() ? 1 : 0, \PDO::PARAM_INT);
			$stmt->bindParam(':expired', $user->isExpired() ? 1 : 0, \PDO::PARAM_INT);
			$stmt->bindParam(':roles', $user->getRoles(), \PDO::PARAM_STR);
			$stmt->bindParam(':credentials_expired', $user->isCredentialsExpired() ? 1 : 0, \PDO::PARAM_INT);
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

	public function updateUserById(User $user) {
		try {
			//UPDATE user
			$stmt = $this->connection->prepare(
				"UPDATE user 
				SET name=:name, 
					surname=:surname, 
					username=:username, 
					username_canonical=:username_canonical, 
					email=:email, 
					email_canonical=:email_canonical, 
					enabled=:enabled, 
					salt=:salt, 
					password=:password, 
					last_login=:last_login, 
					locked=:locked, 
					expired=:expired, 
					expires_at=:expires_at,
					confirmation_token=:confirmation_token, 
					password_requested_at=:password_requested_at,  
					roles=:roles, 
					credentials_expired=:credentials_expired, 
					credentials_expire_at=:credentials_expire_at
				WHERE id=:id");
			$stmt->bindParam(':id', $user->getId(), \PDO::PARAM_INT);
			$stmt->bindParam(':name', $user->getName(), \PDO::PARAM_STR);
			$stmt->bindParam(':surname', $user->getSurname(), \PDO::PARAM_STR);
			$stmt->bindParam(':username', $user->getUsername(), \PDO::PARAM_STR);
			$stmt->bindParam(':username_canonical', $user->getUsernameCanonical(), \PDO::PARAM_STR);
			$stmt->bindParam(':email', $user->getEmail(), \PDO::PARAM_STR);
			$stmt->bindParam(':email_canonical', $user->getEmailCanonical(), \PDO::PARAM_STR);
			$stmt->bindParam(':enabled', $user->isEnabled() ? 1 : 0, \PDO::PARAM_INT);
			$stmt->bindParam(':salt', $user->getSalt(), \PDO::PARAM_STR);
			$stmt->bindParam(':password', $user->getPassword(), \PDO::PARAM_STR);
			$stmt->bindParam(':last_login', $user->getLastLogin(), \PDO::PARAM_STR);
			$stmt->bindParam(':locked', $user->isLocked() ? 1 : 0, \PDO::PARAM_INT);
			$stmt->bindParam(':expired', $user->isExpired() ? 1 : 0, \PDO::PARAM_INT);
			$stmt->bindParam(':expires_at', $user->getExpireDate(), \PDO::PARAM_STR);
			$stmt->bindParam(':confirmation_token', $user->getConfirmationToken(), \PDO::PARAM_STR);
			$stmt->bindParam(':password_requested_at', $user->getPasswordRequestDate(), \PDO::PARAM_STR);
			$stmt->bindParam(':roles', $user->getRoles(), \PDO::PARAM_STR);
			$stmt->bindParam(':credentials_expired', $user->isCredentialsExpired() ? 1 : 0, \PDO::PARAM_INT);
			$stmt->bindParam(':credentials_expire_at', $user->getCredentialsExpireDate(), \PDO::PARAM_STR);
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
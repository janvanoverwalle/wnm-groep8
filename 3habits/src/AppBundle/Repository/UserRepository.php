<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{	
	public function findById($id) {
		if (!is_numeric($id)) {
			return null;
		}
		
		return $this->find($id);
	}

	public function findByUsername($username) {
		if (!is_string($username)) {
			return null;
		}
		
		$result = $this->findBy(array('username' => $username));

		if ($result == null) {
			return null;
		}

		if (is_array($result)) {
			return $result[0];
		}

		return null;
	}

	public function findByRole($role) {
		if ($role == null || empty($role)) {
			return null;
		}

		$all_users = $this->findAll();

		$users = array();
		foreach ($all_users as $user) {
            if ($user->hasRole($role)) {
                $users[] = $user;
            }
        }

		return $users;
	}
	
	public function findAllHabitsById($id) {
		if (!is_numeric($id)) {
			return null;
		}
		
		$userHabits = $this->getEntityManager()
			->createQuery(
				'SELECT uh FROM AppBundle:UserHabits uh WHERE uh.user = :id'
			)
			->setParameter('id', $id)
			->getResult();
			
		if ($userHabits == null) {
			return null;
		}
		
		$habits = array();
		if (is_array($userHabits)) {
			foreach ($userHabits as $uh) {
				$habits[] = $uh->getHabit();
			}
		}
		
		return $habits;
	}

	public function findAllHabitsReachedById($id) {
		if (!is_numeric($id)) {
			return null;
		}
		
		$userHabitsReached = $this->getEntityManager()
			->createQuery(
				'SELECT hr FROM AppBundle:HabitReached hr WHERE hr.user_id = :id'
			)
			->setParameter('id', $id)
			->getResult();

		return $userHabitsReached;
	}

	public function findAllWeightsById($id) {
		if (!is_numeric($id)) {
			return null;
		}
		
		$weights = $this->getEntityManager()
			->createQuery(
				'SELECT w FROM AppBundle:Weight w WHERE w.user_id = :id'
			)
			->setParameter('id', $id)
			->getResult();

		return $weights;
	}

	public function findAllCaloriesById($id) {
		if (!is_numeric($id)) {
			return null;
		}
		
		$calories = $this->getEntityManager()
			->createQuery(
				'SELECT c FROM AppBundle:Calorie c WHERE c.user_id = :id'
			)
			->setParameter('id', $id)
			->getResult();

		return $calories;
	}
}

?>
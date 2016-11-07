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
}

?>
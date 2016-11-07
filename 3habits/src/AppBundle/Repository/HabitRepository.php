<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class HabitRepository extends EntityRepository
{	
	public function findById($id) {
		if (!is_numeric($id)) {
			return null;
		}
		
		return $this->getEntityManager()
			->createQuery(
				'SELECT h FROM AppBundle:Habit h WHERE h.id = :id'
			)
			->setParameter('id', $id)
			->getResult();
	}
}

?>
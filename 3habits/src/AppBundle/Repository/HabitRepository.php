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
				'SELECT u FROM AppBundle:User u WHERE u.id = :id'
			)
			->setParameter('id', $id)
			->getResult();
	}
}

?>
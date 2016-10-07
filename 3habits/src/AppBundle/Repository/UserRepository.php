<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM AppBundle:User u ORDER BY u.name ASC'
            )
            ->getResult();
    }
	
	public function findById($id) {
		if (!is_numeric($id)) {
			return null;
		}
	}
}

?>
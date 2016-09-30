<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Entity\User;
use AppBundle\Entity\Habit;
use AppBundle\Entity\Weight;
use AppBundle\Entity\Calorie;

class UserController extends Controller
{
    /**
     * @Route("/habits/{user_id}", requirements={"user_id": "\d+"}, defaults={"user_id"=0}))
     */
    public function showHabitsAction($user_id)
    {
		$twig = 'AppBundle:UserController:show_habits.html.twig';
		$success = false;
		
		if ($user_id == 0) {
			return $this->render($twig, array(
				"success" => $success
			));
		}
		
		
		
        return $this->render($twig, array(
            "success" => $success
        ));
    }

    /**
     * @Route("/overview/{user_id}", requirements={"user_id": "\d+"})
     */
    public function userOverviewAction($user_id)
    {
		
		
        return $this->render('AppBundle:UserController:user_overview.html.twig', array(
            // ...
        ));
    }

}

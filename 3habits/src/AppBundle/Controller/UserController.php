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
	 * @Method("GET")
     */
    public function showHabitsAction($user_id)
    {
		$twig = 'AppBundle:UserController:show_habits.html.twig';
		$user = new User();
		$habits = new Habit();
		
		if ($user_id == 0) {
			return $this->render($twig, array(
				"success" => False
			));
		}
		
		
		
        return $this->render($twig, array(
            "success" => True,
			"user" => $user,
			"habits" => $habits
        ));
    }
	
	/**
     * @Route("/habits/{user_id}", requirements={"user_id": "\d+"}, defaults={"user_id"=0}))
	 * @Method("POST")
     */
    public function showHabitsAction($user_id) {
		
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

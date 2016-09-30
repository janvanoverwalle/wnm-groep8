<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserControllerController extends Controller
{
    /**
     * @Route("/habits/{user_id}", requirements={"user_id": "\d+"})
     */
    public function showHabitsAction($user_id)
    {
		
		
        return $this->render('AppBundle:UserController:show_habits.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/overview")
     */
    public function overviewHabitsAction()
    {
        return $this->render('AppBundle:UserController:overview_habits.html.twig', array(
            // ...
        ));
    }

}

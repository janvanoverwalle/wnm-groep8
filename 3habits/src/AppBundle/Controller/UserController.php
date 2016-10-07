<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\User;
use AppBundle\Entity\Habit;
use AppBundle\Entity\Weight;
use AppBundle\Entity\Calorie;

use AppBundle\Repository\UserRepository;

class UserController extends Controller
{
    /**
     * @Route("/habits/{user_id}", requirements={"user_id": "\d+"}, defaults={"user_id"=0}))
	 * @Method("GET")
     */
    public function getHabitsAction($user_id)
    {
		$twig = 'AppBundle:UserController:show_habits.html.twig';
		
		if ($user_id == 0) {
			return $this->render($twig, array(
				"success" => False
			));
		}
		
		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository('AppBundle:User')->find($user_id);
		
		if ($user == null) {
			return $this->render($twig, array(
				"success" => False
			));
		}
		
		$habits = $em->getRepository('AppBundle:User')->findAllHabitsById($user_id);
		
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
	public function postHabitsAction(Request $request) {
		$id = $request->request->get('habit_id');
		
		return new Response(
            '<html><body>id: '.$id.'</body></html>'
        );
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

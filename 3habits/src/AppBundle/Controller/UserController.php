<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Utils\User;
use AppBundle\Utils\RestClient;

class UserController extends Controller
{
    /**
     * @Route("/users/{user_id}", requirements={"user_id": "\d+"}, defaults={"user_id"=0}))
	 * @Method("GET")
     */
    public function getUserById($user_id)
    {
		$twig = 'AppBundle:UserController:show_users.html.twig';
		
		if ($user_id == 0) {
			return $this->render($twig, array(
				"success" => False
			));
		}
		
		
		
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

<?php
// src/AppBundle/Controller/SecurityController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Session\Session;

class SecurityController extends Controller {
	/**
	 * @Route("/home", name="home")
	 */
	public function homeAction(Request $request) {
		$twig = 'AppBundle:SecurityController:home.html.twig';
		
		return $this->render($twig);
	}
	
	/**
	 * @Route("/login", name="login")
	 */
	public function getLoginAction(Request $request) {
		$twig = 'AppBundle:SecurityController:login.html.twig';
		
		$username = null;
		$error = null;
		
		echo $request->getMethod();
		
		if ($request->isMethod('POST')) {
			$username = $request->request->get('_username');
			$password = $request->request->get('_password');

			$error = "yuy";
		}
		
		return $this->render($twig, array(
            'last_username' => $username,
			'error' => $error
        ));
	}
}

?>
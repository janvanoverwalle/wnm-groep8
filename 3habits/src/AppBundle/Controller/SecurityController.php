<?php
// src/AppBundle/Controller/SecurityController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller {
	/**
	 * @Route("/login", name="login")
	 */
	public function loginAction(Request $request) {
		$twig = 'AppBundle:SecurityController:login.html.twig';
		
		$authenticationUtils = $this->get('security.authentication_utils');

		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();

		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();
		
		if ($error != null) {
			echo "Key: " . $error->getMessageKey();
			echo "</br>Data: " . json_encode($error->getMessageData());
		}

		return $this->render($twig, array(
			'last_username' => $lastUsername,
			'error'         => $error,
		));
	}
}

?>
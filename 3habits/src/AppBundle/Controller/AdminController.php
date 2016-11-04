<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Form\UserType;
use AppBundle\Form\ChangePasswordType;
use AppBundle\Entity\User;

/**
 * Admin controller.
 *
 * @Route("admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $twig = 'AppBundle:Admin:index.html.twig';

        return $this->render($twig, array(
            // ...
        ));
    }

    /**
     * @Route("/users")
     */
    public function listUsersAction()
    {
        $twig = 'AppBundle:Admin:users.html.twig';

        $em = $this->getDoctrine()->getManager();
        $all_users = $em->getRepository('AppBundle:User')->findAll();

        $users = array();
        foreach ($all_users as $user) {
            if (!$user->hasRole("ROLE_COACH")) {
                $users[] = $user;
            }
        }

        return $this->render($twig, array(
            'users' => $users,
        ));
    }

    /**
     * @Route("/users/{uid}")
     */
    public function displayUserAction(Request $request, $uid)
    {
        $twig = 'AppBundle:Admin:user.html.twig';
        $msg = null;

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findById($uid);

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            $user = $form->getData();

            // Save user to the database
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $msg = "Gebruiker is opgeslaan.";

            // TODO: moet doorverwijzen naar index ofzo en steek deze msg in een flashbag (ofoz) zodat die ij index kan worden uitgelezen
            //return $this->redirectToRoute('task_success');
        }

        return $this->render($twig, array(
            'msg' => $msg,
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/users/{uid}/pw")
     */
    public function changeUserPasswordAction(Request $request, $uid)
    {
        $twig = 'AppBundle:Admin:change_password.html.twig';
        $msg = null;

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findById($uid);

        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $encoder_service = $this->get('security.encoder_factory');
            $encoder = $encoder_service->getEncoder($user);
            $encoded_pass = $encoder->encodePassword($user->getPlainPassword(), $user->getSalt());

            $user->setPassword($encoded_pass);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // TODO: moet doorverwijzen naar index ofzo en steek deze msg in een flashbag (ofoz) zodat die ij index kan worden uitgelezen
            $msg = "Paswoord succesvol gewijzigd.";
        }

        return $this->render($twig, array(
            'msg' => $msg,
            'name' => $user->getName(),
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/coaches")
     */
    public function listCoachesAction()
    {
        $twig = 'AppBundle:Admin:coaches.html.twig';

        $em = $this->getDoctrine()->getManager();
        $coaches = $em->getRepository('AppBundle:User')->findByRole("ROLE_COACH");

        return $this->render($twig, array(
            'coaches' => $coaches,
        ));
    }
}

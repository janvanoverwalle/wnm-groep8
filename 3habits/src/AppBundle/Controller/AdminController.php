<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Form\UserType;
use AppBundle\Form\ChangePasswordType;
use AppBundle\Entity\User;
use FOS\UserBundle\Util\Canonicalizer;

/**
 * Admin controller.
 *
 * @Route("admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin")
     */
    public function indexAction()
    {
        $twig = 'AppBundle:Admin:index.html.twig';

        return $this->render($twig, array(
            'notices' => $this->get('session')->getFlashBag()->get('notice'),
        ));
    }

    /**
     * @Route("/users", name = "user-list")
     */
    public function listUsersAction()
    {
        $twig = 'AppBundle:Admin:users.html.twig';

        $em = $this->getDoctrine()->getManager();
        $all_users = $em->getRepository('AppBundle:User')->findAll();

        $users = array();
        foreach ($all_users as $user) {
            if ($user->getUsername() !== $this->getUser()->getUsername()) {
                $users[] = $user;
            }
        }

        return $this->render($twig, array(
            'users' => $users,
        ));
    }

    /**
     * @Route("/coaches", name="coach-list")
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

    /**
     * @Route("/users/{uid}", name="user")
     */
    public function displayUserAction(Request $request, $uid)
    {
        $twig = 'AppBundle:Admin:user.html.twig';
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id' => $uid));
        return $this->render($twig, array(
            'user' => $user,
            'form' => null,
        ));
    }

    /**
     * @Route("/users/new")
     */
    public function newUserAction(Request $request)
    {
        $twig = 'AppBundle:Admin:user.html.twig';
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            $user = $form->getData();

            $canon = new Canonicalizer();
            $user->setEmailCanonical($canon->canonicalize($user->getEmail()));

            // Save user to the database
            //$em = $this->getDoctrine()->getManager();
            //$em->persist($user);
            //$em->flush();
            $userManager->updateUser($user);

            $user = $userManager->findUserByUsername($user->getUsername());

            $this->get('session')->add('notice', "Gebruiker " . $user->getUsername() . "is aangemaakt");

            $this->redirect($this->generateUrl('user', array('uid' => $user->getId())));
            //return $this->redirectToRoute('admin');
        }

        return $this->render($twig, array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/users/{uid}/edit")
     */
    public function editUserAction(Request $request, $uid)
    {
        $twig = 'AppBundle:Admin:user.html.twig';
        $userManager = $this->get('fos_user.user_manager');

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findById($uid);

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            $user = $form->getData();

            $canon = new Canonicalizer();
            $user->setEmailCanonical($canon->canonicalize($user->getEmail()));

            // Save user to the database
            //$em = $this->getDoctrine()->getManager();
            //$em->persist($user);
            //$em->flush();
            $userManager->updateUser($user);

            $this->get('session')->add('notice', "Gebruiker is opgeslaan");

            $this->redirect($this->generateUrl('user', array('uid' => $uid)));
            //$this->redirectToRoute('user-list');
        }

        return $this->render($twig, array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/users/{uid}/change-password")
     */
    public function changeUserPasswordAction(Request $request, $uid)
    {
        $twig = 'AppBundle:Admin:change_password.html.twig';
        $userManager = $this->get('fos_user.user_manager');

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

            //$em = $this->getDoctrine()->getManager();
            //$em->persist($user);
            //$em->flush();
            $userManager->updateUser($user);

            $this->get('session')->add('notice', "Paswoord succesvol gewijzigd");

            $this->redirect($this->generateUrl('user', array('uid' => $uid)));
            //$this->redirectToRoute('admin');
        }

        return $this->render($twig, array(
            'name' => $user->getName(),
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/users/{uid}/delete")
     */
    public function deleteUserAction(Request $request, $uid)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findById($uid);

        if (!empty($user)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();

            $this->get('session')->add('notice', 'Gebruiker verwijdert');
        }
        else {
            $this->get('session')->add('notice', 'Gebruiker bestaat niet');
        }

        $this->redirectToRoute('admin');
    }
}

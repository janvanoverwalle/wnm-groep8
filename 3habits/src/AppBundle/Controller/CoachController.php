<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Form\UserType;
use AppBundle\Form\RegistrationType;
use AppBundle\Form\ChangePasswordType;
use AppBundle\Entity\User;
use AppBundle\Entity\UserHabits;

/**
 * Coach controller.
 *
 * @Route("coach")
 */
class CoachController extends Controller
{
    /**
     * @Route("/", name="coach")
     */
    public function indexAction()
    {
        $twig = 'AppBundle:Coach:index.html.twig';

        return $this->render($twig, array(
            'notices' => $this->get('session')->getFlashBag()->get('notice'),
        ));
    }

    /**
     * @Route("/users", name = "coach-user-list")
     */
    public function listUsersAction()
    {
        $twig = 'AppBundle:Coach:users.html.twig';

        $em = $this->getDoctrine()->getManager();
        $all_users = $em->getRepository('AppBundle:User')->findAll();

        $users = array();
        foreach ($all_users as $user) {
            if ($user->getUsername() !== $this->getUser()->getUsername()) {
                if (!$user->hasRole('ROLE_COACH') && !$user->hasRole('ROLE_ADMIN'))
                $users[] = $user;
            }
        }

        return $this->render($twig, array(
            'users' => $users,
        ));
    }

    /**
     * @Route("/users/{uid}", name="coach-user", requirements={"uid": "\d+"})
     */
    public function displayUserAction(Request $request, $uid)
    {
        $twig = 'AppBundle:Coach:user.html.twig';
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:User');
        $userHabits = $repo->findAllHabitsById($uid);
        
        if (count($userHabits) !== 3) {
            return $this->redirect($this->generateUrl('coach-new-user', array('uid' => $uid)));
        }

        $habitsReached = $repo->findAllHabitsReachedById($uid);

        return $this->render($twig, array(
            'habits_reached' => $habitsReached,
        ));
    }

    /**
     * @Route("/users/{uid}/new", name="coach-new-user", requirements={"uid": "\d+"})
     */
    public function newUserAction(Request $request, $uid)
    {
        $twig = 'AppBundle:Coach:new-user.html.twig';
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id' => $uid));

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            $user = $form->getData();
            $role = $form->get('role')->getData();
            $user->clearRoles();
            $user->addRole($role);

            // Save user to the database
            //$em = $this->getDoctrine()->getManager();
            //$em->persist($user);
            //$em->flush();
            $userManager->updateUser($user);

            $this->get('session')->getFlashBag()->add('notice', "Gebruiker is opgeslaan");

            return $this->redirect($this->generateUrl('user', array('uid' => $uid)));
            //$this->redirectToRoute('user-list');
        }

        return $this->render($twig, array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }
}

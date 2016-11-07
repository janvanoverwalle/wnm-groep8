<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Form\UserType;
use AppBundle\Form\RegistrationType;
use AppBundle\Form\ChooseHabitsType;
use AppBundle\Form\ChangePasswordType;
use AppBundle\Form\SearchUserType;
use AppBundle\Entity\User;
use AppBundle\Entity\Habit;
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
        $userRepo = $em->getRepository('AppBundle:User');
        $user = $userRepo->findById($uid);
        $userHabits = $userRepo->findAllHabitsById($uid);
        $userWeights = $userRepo->findAllWeightsById($uid);
        $userCalories = $userRepo->findAllCaloriesById($uid);
        
        if (count($userHabits) !== 3) {
            return $this->redirect($this->generateUrl('coach-new-user', array('uid' => $uid)));
        }

        $habitsReached = $userRepo->findAllHabitsReachedById($uid);

        return $this->render($twig, array(
            'habits_reached' => $habitsReached,
            'weights' => $userWeights,
            'calories' => $userCalories,
            'user' => $user,
        ));
    }

    /**
     * @Route("/users/search", name="coach-user-search")
     */
    public function searchUserAction(Request $request)
    {
        $twig = 'AppBundle:Coach:search-user.html.twig';

        $form = $this->createForm(SearchUserType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $username = trim($form->get('username')->getData());

            $em = $this->getDoctrine()->getManager();
            $userRepo = $em->getRepository('AppBundle:User');
            $user = $userRepo->findByUsername($username);

            if ($user !== null) {
                return $this->redirect($this->generateUrl('coach-user', array('uid' => $user->getId())));
            }
            else {
                $this->get('session')->getFlashBag()->add('error', "Geen gebruiker met de gebruikersnaam '".$username."' gevonden");
            }
        }

        return $this->render($twig, array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/users/{uid}/new", name="coach-new-user", requirements={"uid": "\d+"})
     */
    public function newUserAction(Request $request, $uid)
    {
        $twig = 'AppBundle:Coach:new-user.html.twig';
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository('AppBundle:User');

        $user = $userRepo->findById($uid);
        $userHabits = $userRepo->findAllHabitsById($uid);

        if (count($userHabits) == 3) {
            return $this->redirect($this->generateUrl('coach-user', array('uid' => $uid)));
        }

        $form = $this->createForm(ChooseHabitsType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            $user = $form->getData();
            $h1 = $form->get('habit1')->getData();
            $h2 = $form->get('habit2')->getData();
            $h3 = $form->get('habit3')->getData();

            $uh1 = new UserHabits();
            $uh1->setUser($user);
            $uh1->setHabit($h1);

            $uh2 = new UserHabits();
            $uh2->setUser($user);
            $uh2->setHabit($h2);

            $uh3 = new UserHabits();
            $uh3->setUser($user);
            $uh3->setHabit($h3);

            $em->persist($uh1);
            $em->persist($uh2);
            $em->persist($uh3);

            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', "Habits toegekend");

            return $this->redirect($this->generateUrl('coach-user', array('uid' => $uid)));
            //$this->redirectToRoute('user-list');
        }

        return $this->render($twig, array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Alessio Marzo
 * Date: 17/10/2016
 * Time: 12:43
 */

require_once 'src/model/User.php';
require_once 'src/model/UserRepository.php';
require_once 'src/model/PDOUserRepository.php';
require_once 'src/view/View.php';
require_once 'src/view/UserJsonView.php';
require_once 'src/controller/UserController.php';

use \model\User;
use \model\UserRepository;
use \model\PDOUserRepository;
use \controller\UserController;
use \view\View;
use \view\UserJsonView;


class TestUserController extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockUserRepository = $this->getMockBuilder('\model\UserRepository')->getMock();
        $this->mockView = $this->getMockBuilder('\view\View')->getMock();
        $this->user = new User(231, 'testusername', 'admin');
    }

    public function tearDown()
    {
        $this->mockUserRepository = null;
        $this->mockView = null;
        $this->user = null;
    }

    public function testHandleFindUserByIdFound()
    {
        $this->mockUserRepository->expects($this->once())
            ->method('findUserById')
            ->with($this->equalTo($this->user->getId()))
            ->will($this->returnValue($this->user));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['user' => $this->user]))
            ->will($this->returnCallback(function ($object) {
                $u = $object['user'];
                echo $u->getId().' '.$u->getName();
            }));

        $userController = new userController($this->mockUserRepository, $this->mockView);
        $userController->handleFindUserById($this->user->getId());

        $this->expectOutputString($this->user->getId().' '.$this->user->getName());
    }

    public function testHandleFindUserByIdNotFound()
    {
        $wrongId = 222;
        $this->mockUserRepository->expects($this->once())
            ->method('findUserById')
            ->with($this->equalTo($wrongId))
            ->will($this->returnValue(null));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['user' => null]))
            ->will($this->returnCallback(function ($object) {
                echo '';
            }));

        $userController = new UserController($this->mockUserRepository, $this->mockView);
        $userController->handleFindUserById($wrongId);

        $this->expectOutputString('');
    }

    public function testHandleFindAllUsersFound()
    {
        $this->mockUserRepository->expects($this->once())
            ->method('findAllUsers')
            ->will($this->returnValue($this->user));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['users' => $this->user]))
            ->will($this->returnCallback(function ($object) {
                $u = $object['users'];
                echo $u->getId().' '.$u->getName();
            }));

        $userController = new UserController($this->mockUserRepository, $this->mockView);
        $userController->handleFindAllUsers();
    }

    public function testHandleInsertUserCompleted()
    {
        /*
        $newInsertUser = new User(1, 'TestName');
        $this->mockUserRepository->expects($this->once())
            ->method('insertUser')
            ->with($this->equalTo($newInsertUser->getName()))
            ->will($this->returnValue($newInsertUser));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['user' => $newInsertUser]))
            ->will($this->returnCallback(function ($object) {
                $u = $object['user'];
                echo $u->getId().' '.$u->getName().' '.$u->getRoles();
            }));

        $userController = new UserController($this->mockUserRepository, $this->mockView);
        $userController->handleInsertUser($newInsertUser->getName());
        */
    }

    public function testHandleDeleteUserByIdCompleted()
    {
        $this->mockUserRepository->expects($this->once())
            ->method('deleteUserById')
            ->with($this->equalTo($this->user->getId()))
            ->will($this->returnValue(null));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['user' => null]))
            ->will($this->returnCallback(function ($object) {
                echo '';
            }));

        $userController = new UserController($this->mockUserRepository, $this->mockView);
        $userController->handleDeleteUserById($this->user->getId());
    }

    public function testHandleUpdateUserByIdCompleted()
    {
        $this->mockUserRepository->expects($this->once())
            ->method('updateUserById')
            ->with($this->equalTo($this->user->getId()))
            ->will($this->returnValue($this->user));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['user' => $this->user]))
            ->will($this->returnCallback(function ($object) {
                $u = $object['user'];
                echo $u->getId().' '.$u->getName();
            }));

        $userController = new UserController($this->mockUserRepository, $this->mockView);
        $userController->handleUpdateUserById($this->user->getId());
    }
}
<?php
<<<<<<< HEAD
/**
 * Created by PhpStorm.
 * User: Alessio Marzo
 * Date: 17/10/2016
 * Time: 12:43
 */

require '../../src/model/User.php';
require '../../src/model/UserRepository.php';
require '../../src/model/PDOUserRepository.php';
require '../../src/view/View.php';
require '../../src/view/UserJsonView.php';

use \model\User;
use \model\UserRepository;
use \model\PDOUserRepository;
use \controller\UserController;
use \view\View;
use \view\UserJsonView;
=======

/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 14/10/16
 * Time: 16:04
 */

require '../../src/model/User.php';
require '../../src/controller/UserController.php';

>>>>>>> e3eaf18a4d7b0eeb71f983f8561a92c9987d076f

class TestUserController extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
<<<<<<< HEAD
        $this->mockUserRepository = $this->getMockBuilder('\model\UserRepository')->getMock();
        $this->mockView = $this->getMockBuilder('\view\View')->getMock();
        $this->user = new User(231, 'testusername', 'testhabit');
=======
        $this->mockUser = $this->getMockBuilder('')
            ->getMock();
        $this->user = new User(231, 'testperson');
>>>>>>> e3eaf18a4d7b0eeb71f983f8561a92c9987d076f
    }

    public function tearDown()
    {
<<<<<<< HEAD
        $this->mockPersonRepository = null;
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
                echo $u->getId().' '.$u->getName().' '.$u->getHabits();
            }));

        $userController = new userController($this->mockUserRepository, $this->mockview);
        $userController->handleFindUserById($this->user->getId());

        $this->expectOutputString($this->user->getId().' '.$this->user->getName().' '.$this->user->getHabits());
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

    public function testHandleFindAllUsersFound() {

    }


=======
        $this->mockUser = null;
        $this->user = null;
    }

    public function testFindUserById() {

    }
>>>>>>> e3eaf18a4d7b0eeb71f983f8561a92c9987d076f
}
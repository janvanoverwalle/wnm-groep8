<?php
/**
 * Created by PhpStorm.
 * User: Alessio Marzo
 * Date: 17/10/2016
 * Time: 13:26
 */

require_once 'src/model/User.php';
require_once 'src/model/UserRepository.php';
require_once 'src/model/PDOUserRepository.php';
require_once 'src/view/View.php';
require_once 'src/view/UserJsonView.php';

use \model\User;
use \model\UserRepository;
use \model\PDOUserRepository;
use \controller\UserController;
use \view\View;
use \view\UserJsonView;

class PDOMock extends PDO
{
    public function __construct()
    {
    }
}

class TestPDOUserRepository extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockPDO = $this->getMockBuilder('PDOMock')
            ->getMock();

        $this->mockPDOStatement = $this->getMockBuilder('PDOStatement')
            ->getMock();

        $this->user = new User(231, 'testuserName');
    }

    public function tearDown()
    {
        $this->mockPDO = null;
        $this->mockPDOStatement = null;
        $this->user = null;
    }

    public function testFindUserByUserIdUserFound()
    {
        $this->mockPDOStatement->expects($this->once())
            ->method('bindParam')
            ->with($this->equalTo(':id'), $this->equalTo($this->user->getId()), $this->equalTo(PDO::PARAM_INT));

        $this->mockPDOStatement->expects($this->once())
            ->method('execute');

        $this->mockPDOStatement->expects($this->once())
            ->method('fetchAll')
            ->with($this->equalTo(PDO::FETCH_ASSOC))
            ->will($this->returnValue([['id' => $this->user->getId(), 'name' => $this->user->getName()]]));

        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo('SELECT * FROM user WHERE id = :id'))
            ->will($this->returnValue($this->mockPDOStatement));

        $pdoRepo = new PDOuserRepository($this->mockPDO);
        $u = $pdoRepo->findUserById($this->user->getId());

        $this->assertEquals($u, $this->user);
    }

    public function testFindUserByIdUserNotFound()
    {
        $wrongId = 222;
        $this->mockPDOStatement->expects($this->once())
            ->method('bindParam')
            ->with($this->equalTo(':id'), $this->equalTo($wrongId), $this->equalTo(PDO::PARAM_INT));

        $this->mockPDOStatement->expects($this->once())
            ->method('execute');

        $this->mockPDOStatement->expects($this->once())
            ->method('fetchAll')
            ->with($this->equalTo(PDO::FETCH_ASSOC))
            ->will($this->returnValue([]));

        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo('SELECT * FROM user WHERE id = :id'))
            ->will($this->returnValue($this->mockPDOStatement));

        $pdoRepo = new PDOUserRepository($this->mockPDO);
        $u = $pdoRepo->findUserById($wrongId);

        $this->assertEquals($u, null);
    }

    public function testFindAllUsersFound()
    {
        $this->mockPDOStatement->expects($this->once())
            ->method('execute');

        $this->mockPDOStatement->expects($this->once())
            ->method('fetchAll')
            ->with($this->equalTo(PDO::FETCH_ASSOC))
            ->will($this->returnValue([]));

        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo('SELECT * FROM user'))
            ->will($this->returnValue($this->mockPDOStatement));

        $pdoRepo = new PDOUserRepository($this->mockPDO);
        $u = $pdoRepo->findAllUsers();

        $this->assertNull($u);
    }

    public function testInsertUserCompleted()
    {
        $newUser = new User(1, "Test");

        $this->mockPDOStatement->expects($this->once())
            ->method('bindParam');
        //  ->with($this->equalTo(':name'), $this->equalTo($newUser->getName()));
        $this->mockPDOStatement->expects($this->once())
            ->method('fetch')
            ->will($this->returnValue([0 => 1]));

        $this->mockPDOStatement->expects($this->once())
            ->method('execute');

        $this->mockPDO->expects($this->once())
            ->method('prepare')
            // ->with($this->equalTo('INSERT INTO user(name) VALUES (:name)'))
            ->will($this->returnValue($this->mockPDOStatement));

        $this->mockPDO->expects($this->once())
            ->method('query')
            ->will($this->returnValue($this->mockPDOStatement));

        $pdoRepo = new PDOuserRepository($this->mockPDO);
        $u = $pdoRepo->insertUser($newUser);

        $this->assertEquals($u->getName(), $newUser->getName());

    }

    public function testDeleteUserByIdCompleted()
    {
        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->will($this->returnValue($this->mockPDOStatement));

        $this->mockPDOStatement->expects($this->once())
            ->method('bindParam');

        $this->mockPDOStatement->expects($this->once())
            ->method('execute');

        $pdoRepo = new PDOuserRepository($this->mockPDO);
        $u = $pdoRepo->deleteUserById(1);
    }

    public function testUpdateUserByIdCompleted()
    {
        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo('UPDATE user SET name=:name WHERE id=:id'))
            ->will($this->returnValue($this->mockPDOStatement));

        $this->mockPDOStatement->expects($this->once())
            ->method('bindParam')
            ->with($this->equalTo(':id'), $this->equalTo(231), $this->equalTo(PDO::PARAM_INT))
            ->with($this->equalTo(':name'), $this->equalTo("Test2"), $this->equalTo(PDO::PARAM_STR))
            ->will($this->returnValue($this->mockPDOStatement));

        $this->mockPDOStatement->expects($this->once())
            ->method('execute');

        $pdoRepo = new PDOuserRepository($this->mockPDO);
        $updateUser = new User(231, "Test2");
        $u = $pdoRepo->updateUserById($updateUser);

        $this->assertEquals($u->getName(), "Test2");
    }
}
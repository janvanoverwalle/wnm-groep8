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

class PDOMock extends PDO {
    public function __construct() {}
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
        $this->mockPDOStatement->expects($this->once())
            ->method('bindParam')
            ->with($this->equalTo(':name'), $this->equalTo($this->user->getName()));

        $this->mockPDOStatement->expects($this->once())
            ->method('execute');

        $this->mockPDOStatement->expects($this->once())
            ->method('fetchAll')
            ->with($this->equalTo(PDO::FETCH_ASSOC))
            ->will($this->returnValue([['id' => $this->user->getId(), 'name' => $this->user->getName()]]));

        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo('INSERT INTO user(name) VALUES (:name)'))
            ->will($this->returnValue($this->mockPDOStatement));

        $pdoRepo = new PDOuserRepository($this->mockPDO);
        $u = $pdoRepo->insertUser("test2");

        $this->assertEquals($u->getName(), "test2");

    }

    public function testDeleteUserByIdCompleted()
    {

    }

    public function testUpdateUserByIdCompleted()
    {

    }
}
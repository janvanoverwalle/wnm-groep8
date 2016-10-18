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



    public function testFindUserByIdNotFound()
    {
        $wrongId = 222;
        $this->mockPDOStatement->expects($this->once())
            ->method('bindParam')
            ->with($this->equalTo(1), $this->equalTo($wrongId), $this->equalTo(PDO::PARAM_INT));

        $this->mockPDOStatement->expects($this->once())
            ->method('execute');

        $this->mockPDOStatement->expects($this->once())
            ->method('fetchAll')
            ->with($this->equalTo(PDO::FETCH_ASSOC))
            ->will($this->returnValue([]));

        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo('SELECT * FROM user WHERE id=?'))
            ->will($this->returnValue($this->mockPDOStatement));

        $pdoRepo = new PDOUserRepository($this->mockPDO);
        $u = $pdoRepo->findUserById($wrongId);

        $this->assertEquals($u, null);
    }
}
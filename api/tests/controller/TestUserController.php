<?php

/**
 * Created by PhpStorm.
 * User: timothy
 * Date: 14/10/16
 * Time: 16:04
 */

require '../../src/model/User.php';
require '../../src/controller/UserController.php';


class TestUserController extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockUser = $this->getMockBuilder('')
            ->getMock();
        $this->user = new User(231, 'testperson');
    }

    public function tearDown()
    {
        $this->mockUser = null;
        $this->user = null;
    }

    public function testFindUserById() {

    }
}
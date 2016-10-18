<?php
/**
 * Created by PhpStorm.
 * User: Alessio Marzo
 * Date: 14/10/2016
 * Time: 16:09
 */

require '../../src/controller/HabitController.php';
require '../../src/model/Habit.php';

class TestHabitController extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockHabit = $this->getMockBuilder()
            ->getMock();
        $this->habit = new habit(231, 'testhabit');
    }

    public function tearDown()
    {
        $this->mockHabit = null;
        $this->habit = null;
    }

    public function testFindHabitByUserId() {

    }

}
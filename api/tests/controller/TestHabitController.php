<?php
/**
 * Created by PhpStorm.
 * User: Alessio Marzo
 * Date: 17/10/2016
 * Time: 12:43
 */

require '../../src/model/Habit.php';
require '../../src/model/HabitRepository.php';
require '../../src/model/PDOHabitRepository.php';
require '../../src/view/View.php';
require '../../src/view/HabitJsonView.php';

use \model\Habit;
use \model\HabitRepository;
use \model\PDOHabitRepository;
use \controller\HabitController;
use \view\View;
use \view\HabitJsonView;

class TestHabitController extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockHabitRepository = $this->getMockBuilder('\model\HabitRepository')->getMock();
        $this->mockView = $this->getMockBuilder('\view\View')->getMock();
        $this->habit = new Habit(231, 'testhabit');
    }

    public function tearDown()
    {
        $this->mockPersonRepository = null;
        $this->mockView = null;
        $this->person = null;
    }

    public function testHandleFindHabitByIdFound()
    {
        $this->mockHabitRepository->expects($this->once())
            ->method('findHabitById')
            ->with($this->equalTo($this->habit->getId()))
            ->will($this->returnValue($this->habit));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['habit' => $this->habit]))
            ->will($this->returnCallback(function ($object) {
                $h = $object['habit'];
                echo $h->getId().' '.$h->getDescription();
            }));

        $habitController = new HabitController($this->mockHabitRepository, $this->mockview);
        $habitController->handleFindHabitById($this->habit->getId());

        $this->expectOutputString($this->habit->getId().' '.$this->habit->getDescription());

    }

    public function testHandleFindHabitByIdNotFound()
    {
        $wrongId = 222;
        $this->mockHabitRepository->expects($this->once())
            ->method('findHabitById')
            ->with($this->equalTo($wrongId))
            ->will($this->returnValue(null));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['habit' => null]))
            ->will($this->returnCallback(function ($object) {
                echo '';
            }));

        $habitController = new HabitController($this->mockHabitRepository, $this->mockView);
        $habitController->handleFindHabitById($wrongId);

        $this->expectOutputString('');
    }

    public function testHandleFindAllHabitsFound()
    {

    }

    public function testHandleFindAllHabitsNotFound()
    {

    }

    public function testHandleFindHabitsByUserIdFound()
    {

    }

    public function testHandleFindHabitsByUserIdNotFound()
    {

    }

    public function testHandleFindHabitByIdAndUserId()
    {

    }

    public function testHandleFindHabitsReachedByUserIdFound()
    {

    }

    public function testHandleFindHabitsReachedByUserIdNotFound()
    {

    }
}
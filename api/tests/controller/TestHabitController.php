<?php
/**
 * Created by PhpStorm.
 * User: Alessio Marzo
 * Date: 17/10/2016
 * Time: 12:43
 */


require_once 'src/model/Habit.php';
require_once 'src/model/HabitRepository.php';
require_once 'src/model/PDOHabitRepository.php';
require_once 'src/view/View.php';
require_once 'src/view/HabitJsonView.php';
require_once 'src/controller/HabitController.php';


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
        $this->mockHabitRepository = null;
        $this->mockView = null;
        $this->habit = null;
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

        $habitController = new HabitController($this->mockHabitRepository, $this->mockView);
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

    public function testHandleFindHabitsByUserIdFound()
    {

    }

    public function testHandleFindHabitByIdAndUserIdFound()
    {

    }

    public function testHandleFindHabitsReachedByUserIdFound()
    {

    }
}
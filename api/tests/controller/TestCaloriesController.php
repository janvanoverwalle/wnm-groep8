<?php
/**
 * Created by PhpStorm.
 * User: Alessio Marzo
 * Date: 27/10/2016
 * Time: 11:44
 */

require_once 'src/model/Calories.php';
require_once 'src/model/CaloriesRepository.php';
require_once 'src/model/PDOCaloriesRepository.php';
require_once 'src/view/View.php';
require_once 'src/view/CaloriesJsonView.php';
require_once 'src/controller/CaloriesController.php';

use \model\Calories;
use \model\CaloriesRepository;
use \model\PDOCaloriesRepository;
use \controller\CaloriesController;
use \view\View;
use \view\CaloriesJsonView;

class TestCaloriesController extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockCaloriesRepository = $this->getMockBuilder('\model\CaloriesRepository')->getMock();
        $this->mockView = $this->getMockBuilder('\view\View')->getMock();
        $this->calories = new calories(231, 'testCalories', 'testDate');
    }

    public function tearDown()
    {
        $this->mockCaloriesRepository = null;
        $this->mockView = null;
        $this->calories = null;
    }

    public function testHandleFindCaloriesByIdFound()
    {
        $this->mockCaloriesRepository->expects($this->once())
            ->method('findCaloriesById')
            ->with($this->equalTo($this->calories->getId()))
            ->will($this->returnValue($this->calories));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['calorie' => $this->calories]))
            ->will($this->returnCallback(function ($object) {
                $c = $object['calorie'];
                echo $c->getId().' '.$c->getCalories().' '.$c->getDate();
            }));

        $caloriesController = new CaloriesController($this->mockCaloriesRepository, $this->mockView);
        $caloriesController->handleFindCaloriesById($this->calories->getId());

        $this->expectOutputString($this->calories->getId().' '.$this->calories->getCalories().' '.$this->calories->getDate());
    }

    public function testHandleFindCaloriesByIdNotFound()
    {
        $wrongId = 222;
        $this->mockCaloriesRepository->expects($this->once())
            ->method('findCaloriesById')
            ->with($this->equalTo($wrongId))
            ->will($this->returnValue(null));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['calorie' => null]))
            ->will($this->returnCallback(function ($object) {
                echo '';
            }));

        $caloriesController = new CaloriesController($this->mockCaloriesRepository, $this->mockView);
        $caloriesController->handleFindCaloriesById($wrongId);

        $this->expectOutputString('');
    }

    public function testHandleFindAllCaloriesFound()
    {
        $this->mockCaloriesRepository->expects($this->once())
            ->method('findAllCalories')
            ->will($this->returnValue($this->calories));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['calories' => $this->calories]))
            ->will($this->returnCallback(function ($object) {
                $c = $object['calories'];
                echo $c->getId().' '.$c->getCalories().' '.$c->getDate();
            }));

        $caloriesController = new CaloriesController($this->mockCaloriesRepository, $this->mockView);
        $caloriesController->handleFindAllCalories();
    }

    public function testHandleFindCaloriesByUserIdFound()
    {
        $uid = 1;
        $this->mockCaloriesRepository->expects($this->once())
            ->method('findCaloriesByUserId')
            ->with($this->equalTo($uid))
            ->will($this->returnValue($this->calories));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['calories' => $this->calories]))
            ->will($this->returnCallback(function ($object) {
                $c = $object['calories'];
                echo $c->getId().' '.$c->getCalories().' '.$c->getDate();
            }));

        $caloriesController = new CaloriesController($this->mockCaloriesRepository, $this->mockView);
        $caloriesController->handleFindCaloriesByUserId($uid);

        $this->expectOutputString($this->calories->getId().' '.$this->calories->getCalories().' '.$this->calories->getDate());
    }

    public function testHandleFindCaloriesByIdAndUserIdFound()
    {
        $uid = 1;
        $this->mockCaloriesRepository->expects($this->once())
            ->method('findCaloriesByIdAndUserId')
            ->with($this->equalTo($this->calories->getId(),$uid))
            ->will($this->returnValue($this->calories));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['calorie' => $this->calories]))
            ->will($this->returnCallback(function ($object) {
                $c = $object['calorie'];
                echo $c->getId().' '.$c->getCalories().' '.$c->getDate();
            }));

        $caloriesController = new CaloriesController($this->mockCaloriesRepository, $this->mockView);
        $caloriesController->handleFindCaloriesByIdAndUserId($this->calories->getId(),$uid);

        $this->expectOutputString($this->calories->getId().' '.$this->calories->getCalories().' '.$this->calories->getDate());
    }

    public function testHandleInsertCaloriesCompleted()
    {

    }

    public function testHandleDeleteCaloriesByIdCompleted()
    {
        $this->mockCaloriesRepository->expects($this->once())
            ->method('deleteCaloriesById')
            ->with($this->equalTo($this->calories->getId()))
            ->will($this->returnValue(null));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['calorie' => null]))
            ->will($this->returnCallback(function ($object) {
                echo '';
            }));

        $caloriesController = new caloriesController($this->mockCaloriesRepository, $this->mockView);
        $caloriesController->handleDeleteCaloriesById($this->calories->getId());
    }

    public function testHandleUpdateCaloriesByIdCompleted()
    {

    }
}
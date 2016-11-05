<?php
/**
 * Created by PhpStorm.
 * User: Alessio Marzo
 * Date: 27/10/2016
 * Time: 11:12
 */

require_once 'src/model/Weight.php';
require_once 'src/model/WeightRepository.php';
require_once 'src/model/PDOWeightRepository.php';
require_once 'src/view/View.php';
require_once 'src/view/WeightJsonView.php';
require_once 'src/controller/WeightController.php';

use \model\Weight;
use \model\WeightRepository;
use \model\PDOWeightRepository;
use \controller\WeightController;
use \view\View;
use \view\WeightJsonView;

class TestUserController extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockWeightRepository = $this->getMockBuilder('\model\WeightRepository')->getMock();
        $this->mockView = $this->getMockBuilder('\view\View')->getMock();
        $this->weight = new Weight(231, 'testWeight', 'testDate');
    }

    public function tearDown()
    {
        $this->mockWeightRepository = null;
        $this->mockView = null;
        $this->weight = null;
    }

    public function testHandleFindWeightByIdFound()
    {
        $this->mockWeightRepository->expects($this->once())
            ->method('findWeightById')
            ->with($this->equalTo($this->weight->getId()))
            ->will($this->returnValue($this->weight));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['weight' => $this->weight]))
            ->will($this->returnCallback(function ($object) {
                $w = $object['weight'];
                echo $w->getId().' '.$w->getWeight().' '.$w->getDate();
            }));

        $weightController = new WeightController($this->mockWeightRepository, $this->mockView);
        $weightController->handleFindWeightById($this->weight->getId());

        $this->expectOutputString($this->weight->getId().' '.$this->weight->getWeight().' '.$this->weight->getDate());
    }

    public function testHandleFindWeightByIdNotFound()
    {
        $wrongId = 222;
        $this->mockWeightRepository->expects($this->once())
            ->method('findWeightById')
            ->with($this->equalTo($wrongId))
            ->will($this->returnValue(null));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['weight' => null]))
            ->will($this->returnCallback(function ($object) {
                echo '';
            }));

        $weightController = new WeightController($this->mockWeightRepository, $this->mockView);
        $weightController->handleFindWeightById($wrongId);

        $this->expectOutputString('');
    }

    public function testHandleFindAllWeightsFound()
    {
        $this->mockWeightRepository->expects($this->once())
            ->method('findAllWeights')
            ->will($this->returnValue($this->weight));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['weights' => $this->weight]))
            ->will($this->returnCallback(function ($object) {
                $w = $object['weights'];
                echo $w->getId().' '.$w->getWeight().' '.$w->getDate();
            }));

        $weightController = new WeightController($this->mockWeightRepository, $this->mockView);
        $weightController->handleFindAllWeights();
    }

    public function testHandleFindWeightsByUserIdFound()
    {
        $uid = 1;
        $this->mockWeightRepository->expects($this->once())
            ->method('findWeightsByUserId')
            ->with($this->equalTo($uid))
            ->will($this->returnValue($this->weight));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['weights' => $this->weight]))
            ->will($this->returnCallback(function ($object) {
                $w = $object['weights'];
                echo $w->getId().' '.$w->getWeight().' '.$w->getDate();
            }));

        $weightController = new WeightController($this->mockWeightRepository, $this->mockView);
        $weightController->handleFindWeightsByUserId($uid);

        $this->expectOutputString($this->weight->getId().' '.$this->weight->getWeight().' '.$this->weight->getDate());
    }

    public function testHandleFindWeightsByIdAndUserIdFound()
    {
        $uid = 1;
        $this->mockWeightRepository->expects($this->once())
            ->method('findWeightByIdAndUserId')
            ->with($this->equalTo($this->weight->getId(),$uid))
            ->will($this->returnValue($this->weight));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['weight' => $this->weight]))
            ->will($this->returnCallback(function ($object) {
                $w = $object['weight'];
                echo $w->getId().' '.$w->getWeight().' '.$w->getDate();
            }));

        $weightController = new WeightController($this->mockWeightRepository, $this->mockView);
        $weightController->handleFindWeightByIdAndUserId($this->weight->getId(),$uid);

        $this->expectOutputString($this->weight->getId().' '.$this->weight->getWeight().' '.$this->weight->getDate());
    }

    public function testHandleInsertWeightCompleted()
    {

    }

    public function testHandleDeleteWeightByIdCompleted()
    {
        $this->mockWeightRepository->expects($this->once())
            ->method('deleteWeightById')
            ->with($this->equalTo($this->weight->getId()))
            ->will($this->returnValue(null));

        $this->mockView->expects($this->once())
            ->method('show')
            ->with($this->equalTo(['weight' => null]))
            ->will($this->returnCallback(function ($object) {
                echo '';
            }));

        $weightController = new weightController($this->mockWeightRepository, $this->mockView);
        $weightController->handleDeleteWeightById($this->weight->getId());
    }

    public function testHandleUpdateWeightsByIdCompleted()
    {

    }

}
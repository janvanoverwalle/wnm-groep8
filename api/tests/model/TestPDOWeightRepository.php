<?php
/**
 * Created by PhpStorm.
 * User: Alessio Marzo
 * Date: 21/10/2016
 * Time: 14:27
 */

require_once 'src/model/Weight.php';
require_once 'src/model/WeightRepository.php';
require_once 'src/model/PDOWeightRepository.php';
require_once 'src/view/View.php';
require_once 'src/view/WeightJsonView.php';

use \model\Weight;
use \model\WeightRepository;
use \model\PDOWeightRepository;
use \controller\WeightController;
use \view\View;
use \view\WeightJsonView;

class PDOMock extends PDO
{
    public function __construct()
    {
    }
}

class TestPDOWeightRepository extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockPDO = $this->getMockBuilder('PDOMock')
            ->getMock();

        $this->mockPDOStatement = $this->getMockBuilder('PDOStatement')
            ->getMock();

        $this->weight = new Weight(231, 88, "2016-10-22");
    }

    public function tearDown()
    {
        $this->mockPDO = null;
        $this->mockPDOStatement = null;
        $this->weight = null;
    }

    public function testFindWeightByIdFound()
    {
        $this->mockPDOStatement->expects($this->once())
            ->method('bindParam')
            ->with($this->equalTo(':id'), $this->equalTo($this->weight->getId()), $this->equalTo(PDO::PARAM_INT));

        $this->mockPDOStatement->expects($this->once())
            ->method('execute');

        $this->mockPDOStatement->expects($this->once())
            ->method('fetchAll')
            ->with($this->equalTo(PDO::FETCH_ASSOC))
            ->will($this->returnValue([['id' => $this->weight->getId(), 'weight' => $this->weight->getWeight(),
                'date' => $this->weight->getDate()]]));

        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo('SELECT * FROM weights WHERE id = :id'))
            ->will($this->returnValue($this->mockPDOStatement));

        $pdoRepo = new PDOWeightRepository($this->mockPDO);
        $w = $pdoRepo->findWeightById($this->weight->getId());

        $this->assertEquals($w, $this->weight);
    }

    public function testFindWeightByIdNotFound()
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
            ->with($this->equalTo('SELECT * FROM weights WHERE id = :id'))
            ->will($this->returnValue($this->mockPDOStatement));

        $pdoRepo = new PDOWeightRepository($this->mockPDO);
        $w = $pdoRepo->findWeightById($wrongId);

        $this->assertEquals($w, null);
    }

    public function testFindAllWeightsFound()
    {
        $this->mockPDOStatement->expects($this->once())
            ->method('execute');

        $this->mockPDOStatement->expects($this->once())
            ->method('fetchAll')
            ->with($this->equalTo(PDO::FETCH_ASSOC))
            ->will($this->returnValue([]));

        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo('SELECT * FROM weights'))
            ->will($this->returnValue($this->mockPDOStatement));

        $pdoRepo = new PDOWeightRepository($this->mockPDO);
        $w = $pdoRepo->findAllWeights();

        $this->assertNull($w);
    }

    public function testInsertWeightCompleted()
    {

    }

    public function testFindAllWeightsByUserIdFound()
    {

    }
    public function testFindWeightByIdAndUserIdFound()
    {

    }

    public function testDeleteWeightByIdCompleted()
    {
        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->will($this->returnValue($this->mockPDOStatement));

        $this->mockPDOStatement->expects($this->once())
            ->method('bindParam');

        $this->mockPDOStatement->expects($this->once())
            ->method('execute');

        $pdoRepo = new PDOuserRepository($this->mockPDO);
        $w = $pdoRepo->deleteWeightById(1);

        $this->assertNull($w);
    }

    public function testUpdateWeightByIdCompleted()
    {

    }
}
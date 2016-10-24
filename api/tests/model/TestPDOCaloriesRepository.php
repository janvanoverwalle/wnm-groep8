<?php
/**
 * Created by PhpStorm.
 * User: Alessio Marzo
 * Date: 21/10/2016
 * Time: 14:27
 */

require_once 'src/model/Calories.php';
require_once 'src/model/CaloriesRepository.php';
require_once 'src/model/PDOCaloriesRepository.php';
require_once 'src/view/View.php';
require_once 'src/view/CaloriesJsonView.php';

use \model\Calories;
use \model\CaloriesRepository;
use \model\PDOCaloriesRepository;
use \controller\CaloriesController;
use \view\View;
use \view\CaloriesJsonView;

class PDOMock extends PDO {
    public function __construct() {}
}

class TestPDOCaloriesRepository extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockPDO = $this->getMockBuilder('PDOMock')
            ->getMock();

        $this->mockPDOStatement = $this->getMockBuilder('PDOStatement')
            ->getMock();

        $this->calories = new Calories(231, 2300, '2016-10-21');
    }

    public function tearDown()
    {
        $this->mockPDO = null;
        $this->mockPDOStatement = null;
        $this->calories = null;
    }

    public function testFindCaloriesByIdFound()
    {
        $this->mockPDOStatement->expects($this->once())
            ->method('bindParam')
            ->with($this->equalTo(':id'), $this->equalTo($this->calories->getId()), $this->equalTo(PDO::PARAM_INT));

        $this->mockPDOStatement->expects($this->once())
            ->method('execute');

        $this->mockPDOStatement->expects($this->once())
            ->method('fetchAll')
            ->with($this->equalTo(PDO::FETCH_ASSOC))
            ->will($this->returnValue([['id' => $this->calories->getId(), 'calories' => $this->calories->getCalories(),
                'date' => $this->calories->getDate()]]));

        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo('SELECT * FROM calories WHERE id = :id'))
            ->will($this->returnValue($this->mockPDOStatement));

        $pdoRepo = new PDOcaloriesRepository($this->mockPDO);
        $c = $pdoRepo->findCaloriesById($this->calories->getId());

        $this->assertEquals($c, $this->calories);
    }

    public function testFindCaloriesByIdNotFound()
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
            ->with($this->equalTo('SELECT * FROM calories WHERE id = :id'))
            ->will($this->returnValue($this->mockPDOStatement));

        $pdoRepo = new PDOCaloriesRepository($this->mockPDO);
        $c = $pdoRepo->findCaloriesById($wrongId);

        $this->assertEquals($c, null);
    }

    public function testFindAllCaloriesFound()
    {
        $this->mockPDOStatement->expects($this->once())
            ->method('execute');

        $this->mockPDOStatement->expects($this->once())
            ->method('fetchAll')
            ->with($this->equalTo(PDO::FETCH_ASSOC))
            ->will($this->returnValue([]));

        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo('SELECT * FROM calories'))
            ->will($this->returnValue($this->mockPDOStatement));

        $pdoRepo = new PDOCaloriesRepository($this->mockPDO);
        $c = $pdoRepo->findAllCalories();

        $this->assertNull($c);
    }

    public function testFindAllCaloriesByUserIdFound()
    {

    }

    public function testFindCaloriesByIdAndUserIdFound()
    {

    }

    public function testInsertCaloriesCompleted()
    {
        $newCalories = new Calories(1, "1000", "2016-10-10");

        $this->mockPDOStatement->expects($this->once())
            ->method('bindParam');

        $this->mockPDOStatement->expects($this->once())
            ->method('fetch')
            ->will($this->returnValue([0 => 1]));

        $this->mockPDOStatement->expects($this->once())
            ->method('execute');

        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->will($this->returnValue($this->mockPDOStatement));

        $this->mockPDO->expects($this->once())
            ->method('query')
            ->will($this->returnValue($this->mockPDOStatement));

        $pdoRepo = new PDOCaloriesRepository($this->mockPDO);
        $c = $pdoRepo->insertCalories($newCalories, 1);

        $this->assertEquals($c->getCalories(), $newCalories->getCalories());
    }

    public function testDeleteCaloriesByIdCompleted()
    {
        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->will($this->returnValue($this->mockPDOStatement));

        $this->mockPDOStatement->expects($this->once())
            ->method('bindParam');

        $this->mockPDOStatement->expects($this->once())
            ->method('execute');

        $pdoRepo = new PDOCaloriesRepository($this->mockPDO);
        $c = $pdoRepo->deleteUserById(1);
    }

    public function testUpdateCalorieByIdCompleted()
    {

    }
}
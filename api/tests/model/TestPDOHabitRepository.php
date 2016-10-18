<?php
/**
 * Created by PhpStorm.
 * User: Alessio Marzo
 * Date: 17/10/2016
 * Time: 13:26
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

class TestPDOHabitRepository extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mockPDO = $this->getMockBuilder('PDO')
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockPDOStatement = $this->getMockBuilder('PDOStatement')
            ->disableOriginalConstructor()
            ->getMock();

        $this->habit = new Habit(231, 'testdescription');
    }

    public function tearDown()
    {
        $this->mockPDO = null;
        $this->mockPDOStatement = null;
        $this->habit = null;
    }

    public function testFindHabitByUserIdHabitFound()
    {
        $this->mockPDOStatement->expects($this->once())
            ->method('bindParam')
            ->with($this->equalTo(1), $this->equalTo($this->habit->getId()), $this->equalTo(PDO::PARAM_INT));

        $this->mockPDOStatement->expects($this->once())
            ->method('execute');

        $this->mockPDOStatement->expects($this->once())
            ->method('fetchAll')
            ->with($this->equalTo(PDO::FETCH_ASSOC))
            ->will($this->returnValue([['id' => $this->habit->getId(), 'description' => $this->habit->getName()]]));

        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo('SELECT * FROM habit WHERE id=?'))
            ->will($this->returnValue($this->mockPDOStatement));

        $pdoRepo = new PDOHabitRepository($this->mockPDO);
        $h = $pdoRepo->findHabitById($this->Habit->getId());

        $this->assertEquals($h, $this->habit);
    }

    public function testFindHabitByUserIdHabitNotFound()
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
            ->with($this->equalTo('SELECT * FROM habit WHERE id=?'))
            ->will($this->returnValue($this->mockPDOStatement));

        $pdoRepo = new PDOHabitRepository($this->mockPDO);
        $h = $pdoRepo->findHabitById($wrongId);

        $this->assertEquals($h, null);
    }
}
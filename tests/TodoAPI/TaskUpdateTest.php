<?php

namespace TodoAPI;

class DatabaseUpdateMock {
    public $updateTaskReturn;
    public $getTaskByIdReturn;
    
    public function getTaskById($id) {
        return $this->getTaskByIdReturn;
    }
    public function updateTask($task) {
        return $this->updateTaskReturn;
    }
}

class TaskUpdateTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @covers            TodoApi\TaskUpdate::loadFromDB
    * @uses              TodoApi\TaskUpdate::__construct
    * @uses              TodoApi\Task::__construct
    */
    public function testLoadingFromDBWhenSuccess()
    {
        $db = new DatabaseUpdateMock();
        $db->getTaskByIdReturn = new Task(1, 'test_desc', 50);
        
        $taskUpdate = new TaskUpdate($db);
        
        $this->assertTrue($taskUpdate->loadFromDB(1));
    }
    
    /**
    * @covers            TodoApi\TaskUpdate::loadFromDB
    * @uses              TodoApi\TaskUpdate::__construct
    */
    public function testLoadingFromDBWhenFailure()
    {
        $db = new DatabaseUpdateMock();
        $db->getTaskByIdReturn = false;
        
        $taskUpdate = new TaskUpdate($db);
        
        $this->assertFalse($taskUpdate->loadFromDB(1));
    }
    
    /**
    * @covers            TodoApi\TaskUpdate::loadFromDB
    * @uses              TodoApi\TaskUpdate::__construct
    */
    public function testLoadingFromDBWhenEmpty()
    {
        $db = new DatabaseUpdateMock();
        $db->getTaskByIdReturn = [];
        
        $taskUpdate = new TaskUpdate($db);
        
        $this->assertFalse($taskUpdate->loadFromDB(1));
    }
    
    /**
    * @covers            TodoApi\TaskUpdate::updateFromXML
    * @uses              TodoApi\TaskUpdate::__construct
    * @uses              TodoApi\TaskUpdate::loadFromDB
    */
    public function testUpdateBothFieldsWithValidXML()
    {
        // valid XML
        $xml = '<?xml version="1.0"?>
<task><description>my_desc</description><progress>100</progress></task>';
        
        // load object
        $db = new DatabaseUpdateMock();
        $db->getTaskByIdReturn = new Task(1, 'test_desc', 50);
        
        $taskUpdate = new TaskUpdate($db);
        $taskUpdate->loadFromDB(1);
        
        $valid = $taskUpdate->updateFromXML($xml);
        $task = $taskUpdate->getTask();
        
        $this->assertTrue($valid);
        $this->assertEquals(1, $task->id);
        $this->assertEquals('my_desc', $task->description);
        $this->assertEquals(100, $task->progress);
    }

    /**
    * @covers            TodoApi\TaskUpdate::updateFromXML
    * @uses              TodoApi\TaskUpdate::__construct
    * @uses              TodoApi\TaskUpdate::loadFromDB
    */
    public function testUpdateDescriptionFieldWithValidXML()
    {
        // valid XML
        $xml = '<?xml version="1.0"?>
<task><description>my_desc</description></task>';
        
        // load object
        $db = new DatabaseUpdateMock();
        $db->getTaskByIdReturn = new Task(1, 'test_desc', 50);
        
        $taskUpdate = new TaskUpdate($db);
        $taskUpdate->loadFromDB(1);
        
        $valid = $taskUpdate->updateFromXML($xml);
        $task = $taskUpdate->getTask();
        
        $this->assertTrue($valid);
        $this->assertEquals(1, $task->id);
        $this->assertEquals('my_desc', $task->description);
        $this->assertEquals(50, $task->progress);
    }
    

    /**
    * @covers            TodoApi\TaskUpdate::updateFromXML
    * @uses              TodoApi\TaskUpdate::__construct
    * @uses              TodoApi\TaskUpdate::loadFromDB
    */
    public function testUpdateProgressFieldWithValidXML()
    {
        // valid XML
        $xml = '<?xml version="1.0"?>
<task><progress>100</progress></task>';
        
        // load object
        $db = new DatabaseUpdateMock();
        $db->getTaskByIdReturn = new Task(1, 'test_desc', 50);
        
        $taskUpdate = new TaskUpdate($db);
        $taskUpdate->loadFromDB(1);
        
        $valid = $taskUpdate->updateFromXML($xml);
        $task = $taskUpdate->getTask();
        
        $this->assertTrue($valid);
        $this->assertEquals(1, $task->id);
        $this->assertEquals('test_desc', $task->description);
        $this->assertEquals(100, $task->progress);
    }
    

    /**
    * @covers            TodoApi\TaskUpdate::updateFromXML
    * @uses              TodoApi\TaskUpdate::__construct
    * @uses              TodoApi\TaskUpdate::loadFromDB
    */
    public function testUpdatePreventUpdateOfIdFieldWithValidXML()
    {
        // valid XML
        $xml = '<?xml version="1.0"?>
<task><id>2</id></task>';
        
        // load object
        $db = new DatabaseUpdateMock();
        $db->getTaskByIdReturn = new Task(1, 'test_desc', 50);
        
        $taskUpdate = new TaskUpdate($db);
        $taskUpdate->loadFromDB(1);
        
        $valid = $taskUpdate->updateFromXML($xml);
        $task = $taskUpdate->getTask();
        
        $this->assertTrue($valid);
        $this->assertEquals(1, $task->id);
        $this->assertEquals('test_desc', $task->description);
        $this->assertEquals(50, $task->progress);
    }
    
    /**
    * @covers            TodoApi\TaskUpdate::updateFromXML
    * @uses              TodoApi\TaskUpdate::__construct
    * @uses              TodoApi\TaskUpdate::loadFromDB
    */
    public function testUpdateWithInvalidXML()
    {
        // valid XML
        $xml = '<?xml version="1.0"?>
<description>my_desc</description><progress>100</progress>';
        
        // load object
        $db = new DatabaseUpdateMock();
        $db->getTaskByIdReturn = new Task(1, 'test_desc', 50);
        
        $taskUpdate = new TaskUpdate($db);
        $taskUpdate->loadFromDB(1);
        
        $valid = $taskUpdate->updateFromXML($xml);
        $task = $taskUpdate->getTask();
        
        $this->assertFalse($valid);
        $this->assertEquals(1, $task->id);
        $this->assertEquals('test_desc', $task->description);
        $this->assertEquals(50, $task->progress);
    }
    
    /**
    * @covers            TodoApi\TaskUpdate::updateFromXML
    * @uses              TodoApi\TaskUpdate::__construct
    * @uses              TodoApi\TaskUpdate::loadFromDB
    */
    public function testUpdateWithInvalidDataButValidXML()
    {
        // valid XML
        $xml = '<?xml version="1.0"?>
<task><description></description></task>';
        
        // load object
        $db = new DatabaseUpdateMock();
        $db->getTaskByIdReturn = new Task(1, 'test_desc', 50);
        
        $taskUpdate = new TaskUpdate($db);
        $taskUpdate->loadFromDB(1);
        
        $valid = $taskUpdate->updateFromXML($xml);
        $task = $taskUpdate->getTask();
        
        $this->assertFalse($valid);
        $this->assertEquals(1, $task->id);
        $this->assertEquals('', $task->description);
        $this->assertEquals(50, $task->progress);
    }
    
    
    /**
    * @covers            TodoApi\TaskUpdate::save
    * @uses              TodoApi\TaskUpdate::__construct
    * @uses              TodoApi\TaskUpdate::loadFromDB
    */
    public function testSavingWithFailure()
    {
        // load objects
        $db = new DatabaseUpdateMock();
        $db->updateTaskReturn = false;
        
        $taskUpdate = new TaskUpdate($db);
        $this->assertFalse($taskUpdate->save());
    }
    
    /**
    * @covers            TodoApi\TaskUpdate::save
    * @uses              TodoApi\TaskUpdate::__construct
    * @uses              TodoApi\TaskUpdate::loadFromDB
    */
    public function testSavingWithSuccess()
    {
        // load objects
        $db = new DatabaseUpdateMock();
        $db->updateTaskReturn = true;
        
        $taskUpdate = new TaskUpdate($db);
        $this->assertTrue($taskUpdate->save());
    }
}
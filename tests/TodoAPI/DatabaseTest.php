<?php

namespace TodoAPI;

class StatementMock {
    public $return;
    public function __construct($return)
    {
        $this->return = $return;
    }
    public function bindParam($a, $b)
    {
    }
    public function execute()
    {
        return $this->return;
    }
    public function fetchObject() {
        if ($this->return == true) {
            $obj = new \stdClass();
            $obj->id = 1;
            $obj->description = 'my_desc';
            $obj->progress = 100;
            return $obj;
        } else {
            return null;
        }
    }
    public function fetchAll() {
        if ($this->return == true) {
            return [1,2,3];
        } else {
            return [];
        }
    }
}
class ConnectionMock
{
    public $executeReturn;
    public $lastInsertReturn;
    
    public function prepare($sql)
    {
        return new StatementMock($this->executeReturn);
    }
    public function lastInsertId()
    {
        return $this->lastInsertReturn;
    }
}
class DatabaseTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @covers            TodoApi\Database::insertTask
    * @uses              TodoApi\Task::__construct
    */
    public function testInsertTaskSuccess()
    {
        $db = new Database();
        $conn = new ConnectionMock();
        $conn->executeReturn = true;
        $conn->lastInsertReturn = 1;
        
        $db->setConnection($conn);
        
        $id = $db->insertTask(new Task(1, 'test_decr', 100));
        $this->assertEquals(1, $id);
    }
    /**
    * @covers            TodoApi\Database::insertTask
    * @uses              TodoApi\Task::__construct
    */
    
    public function testInsertTaskFailure()
    {
        $db = new Database();
        $conn = new ConnectionMock();
        $conn->executeReturn = false;
        $conn->lastInsertReturn = 1;
        
        $db->setConnection($conn);
        
        $id = $db->insertTask(new Task(1, 'test_decr', 100));
        $this->assertEquals(0, $id);
    }
    
    /**
    * @covers            TodoApi\Database::updateTask
    * @uses              TodoApi\Task::__construct
    */
    public function testUpdateTaskSuccess()
    {
        $db = new Database();
        $conn = new ConnectionMock();
        $conn->executeReturn = true;
        $conn->lastInsertReturn = 1;
        
        $db->setConnection($conn);
        
        $id = $db->updateTask(new Task(1, 'test_decr', 100));
        $this->assertEquals(1, $id);
    }
    
    /**
    * @covers            TodoApi\Database::updateTask
    * @uses              TodoApi\Task::__construct
    */
    public function testUpdateTaskFailure()
    {
        $db = new Database();
        $conn = new ConnectionMock();
        $conn->executeReturn = false;
        $conn->lastInsertReturn = 1;
        
        $db->setConnection($conn);
        
        $id = $db->updateTask(new Task(1, 'test_decr', 100));
        $this->assertEquals(0, $id);
    }
    
    /**
    * @covers            TodoApi\Database::getTaskList
    * @uses              TodoApi\Task::__construct
    */
    public function testGetTaskListSuccess()
    {
        $db = new Database();
        $conn = new ConnectionMock();
        $conn->executeReturn = true;
        
        $db->setConnection($conn);
        
        $rows = $db->getTaskList();
        $this->assertTrue(!empty($rows));
    }
    
    /**
    * @covers            TodoApi\Database::getTaskById
    * @uses              TodoApi\Task::__construct
    */
    public function testGetTaskListFailure()
    {
        $db = new Database();
        $conn = new ConnectionMock();
        $conn->executeReturn = false;
        
        $db->setConnection($conn);
        
        $rows = $db->getTaskList();
        $this->assertTrue(empty($rows));
    }
    
    /**
    * @covers            TodoApi\Database::getTaskById
    * @uses              TodoApi\Task::__construct
    */
    public function testGetTaskByIdSuccess()
    {
        $db = new Database();
        $conn = new ConnectionMock();
        $conn->executeReturn = true;
        
        $db->setConnection($conn);
        
        $rows = $db->getTaskById(1);
        $this->assertTrue(is_object($rows));
    }
    
    /**
    * @covers            TodoApi\Database::getTaskById
    * @uses              TodoApi\Task::__construct
    */
    public function testGetTaskByIdFailure()
    {
        $db = new Database();
        $conn = new ConnectionMock();
        $conn->executeReturn = false;
        
        $db->setConnection($conn);
        
        $rows = $db->getTaskById(1);
        $this->assertFalse(is_object($rows));
    }
    
    
    /**
    * @covers            TodoApi\Database::deleteTask
    * @uses              TodoApi\Task::__construct
    */
    public function testDeleteTaskSuccess()
    {
        $db = new Database();
        $conn = new ConnectionMock();
        $conn->executeReturn = true;
        
        $db->setConnection($conn);
        
        $success = $db->deleteTask(1);
        $this->assertTrue($success);
    }
    
    /**
    * @covers            TodoApi\Database::deleteTask
    * @uses              TodoApi\Task::__construct
    */
    public function testDeleteTaskFailure()
    {
        $db = new Database();
        $conn = new ConnectionMock();
        $conn->executeReturn = false;
        
        $db->setConnection($conn);
        
        $success = $db->deleteTask(1);
        $this->assertFalse($success);
    }
}

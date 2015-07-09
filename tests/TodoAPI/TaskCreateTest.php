<?php

namespace TodoAPI;

class DatabaseInsertMock {
    public $return;
    public function insertTask($task) {
        return $this->return;
    }
}

class TaskCreateTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @covers            TodoApi\TaskCreate::createFromXML
    */
    public function testCreateValidFromXML()
    {
        // valid XML
        $xml = '<?xml version="1.0"?>
<task><id>1</id><description>my_desc</description><progress>50</progress></task>';
        
        $taskCreate = new TaskCreate();
        
        $this->assertTrue($taskCreate->createFromXML($xml));
    }
    
    /**
    * @covers            TodoApi\TaskCreate::createFromXML
    */
    public function testCreateInvalidFromXML()
    {
        // valid XML
        $xml = '<?xml version="1.0"?>
<id>1</id><description>my_desc</description><progress>50</progress>';
        
        $taskCreate = new TaskCreate();
        
        $this->assertFalse($taskCreate->createFromXML($xml));
    }
    
    /**
    * @covers            TodoApi\TaskCreate::save
    */
    public function testSaveDatabaseReturnsPositiveResult()
    {
        $db = new DatabaseInsertMock();
        $db->return = 1;
        $taskCreate = new TaskCreate($db);
        
        $this->assertTrue($taskCreate->save());
        $this->assertEquals(1, $taskCreate->getInsertedId());
    }
    
    /**
    * @covers            TodoApi\TaskCreate::save
    */
    public function testSaveDatabaseReturnsZeroResult()
    {
        $db = new DatabaseInsertMock();
        $db->return = 0;
        $taskCreate = new TaskCreate($db);
        
        $this->assertFalse($taskCreate->save());
    }
}
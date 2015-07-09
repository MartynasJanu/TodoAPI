<?php

namespace TodoAPI;
    
class TaskTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @covers            TodoApi\Task::__construct
    */
    public function testConstructor()
    {
        // Initialize
        $task = new Task(1, 'test_descr', 50);

        // Assert
        $this->assertEquals(1, $task->id);
        $this->assertEquals('test_descr', $task->description);
        $this->assertEquals(50, $task->progress);
    }
    
    /**
    * @covers            TodoApi\Task::fromObject
    */
    public function testCreatingFromObject()
    {
        // setup object
        $obj = new \stdClass();
        $obj->id = 1;
        $obj->description = 'test_descr';
        $obj->progress = 50;
        
        // Initialize
        $task = new Task();
        $task->fromObject($obj);

        // Assert
        $this->assertEquals(1, $task->id);
        $this->assertEquals('test_descr', $task->description);
        $this->assertEquals(50, $task->progress);
    }
    
    /**
    * @covers            TodoApi\Task::isValid
    */
    public function testTaskMustBeValid()
    {
        // Initialize invalid object
        $task = new Task(1, '', 50);
        $this->assertFalse($task->isValid());
        
        // Initialize valid object
        $task = new Task(1, 'valid_descr', 50);
        $this->assertTrue($task->isValid());
    }
    
    /**
    * @covers            TodoApi\Task::outputXML
    */
    public function testTaskAsRootNodeOutput()
    {
        $task = new Task(1, 'valid_descr', 50);
        
        $expected = '<?xml version="1.0"?>
<task><id>1</id><description>valid_descr</description><progress>50</progress><link rel="get" href="/api/v1/task/1"/><link rel="delete" href="/api/v1/task/1"/><link rel="put" href="/api/v1/task/1"/></task>
';
        $received = $task->outputXML();
        
        $this->assertEquals($expected, $received);
    }
    
    /**
    * @covers            TodoApi\Task::outputXML
    */
    public function testTaskAsChildNodeOutput()
    {
        // initialize task
        $task = new Task(1, 'valid_descr', 50);
        // initialize XML
        $xml = simplexml_load_string('<tasks></tasks>');
       
        $expected = '<?xml version="1.0"?>
<tasks><task><id>1</id><description>valid_descr</description><progress>50</progress><link rel="get" href="/api/v1/task/1"/><link rel="delete" href="/api/v1/task/1"/><link rel="put" href="/api/v1/task/1"/></task></tasks>
';
        $xml = $task->outputXML($xml);
        $received = $xml->asXML();
        
        $this->assertEquals($expected, $received);
    }
}

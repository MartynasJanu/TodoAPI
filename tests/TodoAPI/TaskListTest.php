<?php

namespace TodoAPI;

class TaskListTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @covers            TodoApi\TaskList::setData
    */
    public function testAddNullList()
    {
        $taskList = new TaskList();
        $taskList->setData(null);
        
        $this->assertEquals(true, $taskList->isError());
    }
    
    /**
    * @uses             TodoApi\Task:__construct
    * @covers           TodoApi\TaskList::setData
    */
    public function testAddTasksWithDescriptionAndProgress()
    {
        $tasks = [['id' => 1, 'description' => 'test_desc', 'progress' => 50]];
        $tasks[] = ['id' => 2, 'description' => 'test_desc2', 'progress' => 100];
        
        $taskList = new TaskList();
        
        $this->assertEquals(2, $taskList->setData($tasks));
        $this->assertEquals(false, $taskList->isError());
    }
    
    
    /**
    * @uses             TodoApi\Task:__construct
    * @covers           TodoApi\TaskList::setData
    */
    public function testAddTasksWithDescriptionOnly()
    {
        $tasks = [['id' => 1, 'description' => 'test_desc']];
        $tasks[] = ['id' => 2, 'description' => 'test_desc2'];
        
        $taskList = new TaskList();
        
        $this->assertEquals(2, $taskList->setData($tasks));
        $this->assertEquals(false, $taskList->isError());
    }
    
    /**
    * @uses             TodoApi\Task:__construct
    * @covers           TodoApi\TaskList::setData
    */
    public function testAddTasksWithProgressOnly()
    {
        $tasks = [['id' => 1, 'progress' => 50]];
        $tasks[] = ['id' => 2, 'progress' => 100];
        
        $taskList = new TaskList();
        
        $this->assertEquals(2, $taskList->setData($tasks));
        $this->assertEquals(false, $taskList->isError());
    }
    
    /**
    * @uses             TodoApi\Task:__construct
    * @uses             TodoApi\TaskList::setData
    * @covers           TodoApi\TaskList::outputXML
    */
    public function testOutputValidTasks()
    {
        $tasks = [['id' => 1, 'progress' => 50]];
        $tasks[] = ['id' => 2, 'progress' => 100];
        
        $taskList = new TaskList();
        $taskList->setData($tasks);
        
        $expected = '<?xml version="1.0"?>
<tasks><task><id>1</id><description/><progress>50</progress><link rel="get" href="/api/v1/task/1"/><link rel="delete" href="/api/v1/task/1"/><link rel="put" href="/api/v1/task/1"/></task><task><id>2</id><description/><progress>100</progress><link rel="get" href="/api/v1/task/2"/><link rel="delete" href="/api/v1/task/2"/><link rel="put" href="/api/v1/task/2"/></task></tasks>
';
        
        $received = $taskList->outputXML();
        //die($received);
        
        $this->assertEquals($expected, $received);
    }
}

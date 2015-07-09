<?php
    
namespace TodoAPI;

class TaskListFactory
{
    public static function build()
    {
        $db = new Database();
        $tasks = $db->getTaskList();
        
        $taskList = new TaskList();
        $taskList->setData($tasks);
        return $taskList;
    }
}

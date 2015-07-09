<?php
    
namespace TodoAPI;

class TaskList
{
    private $tasks = null;
    private $error = false;
    
    public function isError() {
        return $this->error;
    }
    
    public function setData($tasks)
    {
        if ($tasks == null) {
            $this->error = true;
            return false;
        } else {
            $this->error = false;
        }
        
        $this->tasks = [];
        
        foreach ($tasks as $task) {
            $task_object = new Task($task['id']);
            if (!empty($task['description'])) {
                $task_object->description = $task['description'];
            }
            if (!empty($task['progress'])) {
                $task_object->progress = (int)$task['progress'];
            }
            
            $this->tasks[] = $task_object;
        }
        
        return count($this->tasks);
    }
    
    public function outputXML($base_uri = '') {
        if ($this->tasks == null) {
            return '';
        }
        
        $xml = simplexml_load_string('<tasks></tasks>');
        foreach ($this->tasks as $task) {
            $xml = $task->outputXML($xml, $base_uri);
        }
        
        return $xml->asXML();
    }
}

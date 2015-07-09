<?php

namespace TodoAPI;

class TaskUpdate
{
    private $db = null;
    private $task = null;

    public function __construct($db = null)
    {
        $this->db = $db;
    }
    
    public function getTask() {
        return $this->task;
    }
    
    public function loadFromDB($id) {
        $task = $this->db->getTaskById($id);
        
        // return false if not found
        if (empty($task)) {
            return false;
        // store and return true
        } else {
            $this->task = $task;
            return true;
        }
    }
    public function updateFromXML($xml)
    {
        // attempt loading of XML
        libxml_use_internal_errors(true);
        $object = simplexml_load_string($xml);
        libxml_use_internal_errors(false);

        // if loading failed, return false
        if (!$object) {
            return false;
        }
        
        // update task object
        if (isset($object->description)) {
            $this->task->description = (string)$object->description;
        }
        if (isset($object->progress)) {
            $this->task->progress = (int)$object->progress;
        }

        return $this->task->isValid();
    }
    
    public function save()
    {
        return $this->db->updateTask($this->task);
    }
}

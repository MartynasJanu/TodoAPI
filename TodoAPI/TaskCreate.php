<?php

namespace TodoAPI;

class TaskCreate
{
    private $db = null;
    private $task = null;
    private $insertedId = 0;
    
    public function __construct($db = null)
    {
        $this->db = $db;
    }
    
    public function getInsertedId() {
        return $this->insertedId;
    }
    public function createFromXML($xml)
    {
        // attempt loading of XML
        libxml_use_internal_errors(true);
        $object = simplexml_load_string($xml);
        libxml_use_internal_errors(false);
        
        // if loading failed, return false
        if (!$object) {
            return false;
        }
        
        // create task object
        $this->task = new Task();
        $this->task->fromObject($object);
        
        return $this->task->isValid();
    }
    
    public function save()
    {
        $id = $db->insert($this->task);
        if ($id == 0) {
            return false;
        } else {
            $this->insertedId = $id;
            return true;
        }
    }
}

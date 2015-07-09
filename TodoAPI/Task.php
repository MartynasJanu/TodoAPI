<?php

namespace TodoAPI;

class Task
{
    public $id;
    public $description;
    public $progress;
 
    public function __construct($id = 0, $description = '', $progress = 0)
    {
        $this->id = $id;
        $this->description = $description;
        $this->progress = $progress;
    }
    public function fromObject($object)
    {
        $this->id = (int)$object->id;
        $this->description = (string)$object->description;
        $this->progress = (int)$object->progress;
    }
    
    public function isValid()
    {
        if (empty($this->description)) {
            return false;
        }
        
        return true;
    }
    
    public function outputXML($xml = null, $base_uri = '')
    {
        // sets whether or not to return XML as string
        $return_string = true;
        
        // create new root node
        if ($xml == null) {
            $xml = simplexml_load_string('<task></task>');
            $child = $xml;
        } else {
            $return_string = false;
            $xml->addChild('task');
            $child = $xml->task[count($xml->task)-1];
        }
        
        // add data nodes
        $child->addChild('id', $this->id);
        $child->addChild('description', $this->description);
        $child->addChild('progress', $this->progress);
        
        // add links
        $link_idx = 0;
        // view link
        $child->addChild('link');
        $child->link[$link_idx]['rel'] = 'get';
        $child->link[$link_idx]['href'] = $base_uri.'/api/v1/task/'.$this->id;
        // delete link
        ++$link_idx;
        $child->addChild('link');
        $child->link[$link_idx]['rel'] = 'delete';
        $child->link[$link_idx]['href'] = $base_uri.'/api/v1/task/'.$this->id;
        // edit (put) link
        ++$link_idx;
        $child->addChild('link');
        $child->link[$link_idx]['rel'] = 'put';
        $child->link[$link_idx]['href'] = $base_uri.'/api/v1/task/'.$this->id;
        
        if ($return_string) {
            return $xml->asXML();
        } else {
            return $xml;
        }
    }
}
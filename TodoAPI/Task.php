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
        } else {
            $return_string = true;   
        }
        
        // add data nodes
        $xml->addChild('id', $this->id);
        $xml->addChild('description', $this->description);
        $xml->addChild('progress', $this->progress);
        
        // add links
        $link_idx = 0;
        // view link
        $xml->addChild('link');
        $xml->link[$link_idx]->addAttribute('rel', 'get');
        $xml->link[$link_idx]->addAttribute('href', $base_uri.'/api/v1/task/'.$this->id);
        // delete link
        ++$link_idx;
        $xml->addChild('link');
        $xml->link[$link_idx]->addAttribute('rel', 'delete');
        $xml->link[$link_idx]->addAttribute('href', $base_uri.'/api/v1/task/'.$this->id);
        // edit (put) link
        ++$link_idx;
        $xml->addChild('link');
        $xml->link[$link_idx]->addAttribute('rel', 'put');
        $xml->link[$link_idx]->addAttribute('href', $base_uri.'/api/v1/task/'.$this->id);
        
        if ($return_string) {
            return $xml->asXML();
        }
    }
}
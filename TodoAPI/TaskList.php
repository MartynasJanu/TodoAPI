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
        $i = 0;
        foreach ($this->tasks as $task) {
            $task->outputXML($xml, $base_uri);
            /*
            // add data
            $xml->addChild('task');
            $xml->task[$i]->addChild('id', $task->id);
            $xml->task[$i]->addChild('description', $task->description);
            $xml->task[$i]->addChild('progress', $task->progress);
            
            // add links
            $link_idx = 0;
            // view link
            $xml->task[$i]->addChild('link');
            $xml->task[$i]->link[$link_idx]->addAttribute('rel', 'get');
            $xml->task[$i]->link[$link_idx]->addAttribute('href', $base_uri.'/api/v1/task/'.$task->id);
            // delete link
            ++$link_idx;
            $xml->task[$i]->addChild('link');
            $xml->task[$i]->link[$link_idx]->addAttribute('rel', 'delete');
            $xml->task[$i]->link[$link_idx]->addAttribute('href', $base_uri.'/api/v1/task/'.$task->id);
            // edit (put) link
            ++$link_idx;
            $xml->task[$i]->addChild('link');
            $xml->task[$i]->link[$link_idx]->addAttribute('rel', 'put');
            $xml->task[$i]->link[$link_idx]->addAttribute('href', $base_uri.'/api/v1/task/'.$task->id);
            */
            ++$i;
        }
        
        return $xml->asXML();
    }
    
    private function outputPaging() {
        
    }
}

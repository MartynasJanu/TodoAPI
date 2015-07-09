<?php
    
namespace TodoAPI;

class Controller {
    public function taskListAction(&$app) {
        $taskList = TaskListFactory::build();
        $base_uri = $app->request->getRootUri();
        
        // set status and reply with data
        if ($taskList->isError()) {
            $app->response->status(500);
        } else {
            $app->response->status(200);
            echo '<xmp>'.$taskList->outputXML($base_uri);
        }
    }
    
    public function taskAction(&$app, $id) {
        $base_uri = $app->request->getRootUri();
        
        $db = new Database();
        $task = $db->getTaskById($id);

        // error in connection
        if ($task === false) {
            $app->response->status(500);
            die('500');
        // not found
        } elseif (empty($task)) {
            $app->response->status(404);
            die('404');
        } else {
            $app->response->status(200);
            echo '<xmp>'.$task->outputXML(null, $base_uri);
        }
    }
    
    public function taskCreateAction(&$app, $xml) {
        $base_uri = $app->request->getRootUri();
        $taskCreate = TaskCreateFactory::build();
        
        $created = $taskCreate->createFromXML($xml);
        
        // is object is not valid, return Bad Request
        if (!$created) {
            $app->response->status(404);
        // save to database
        } elseif ($taskCreate->save()) {
            $app->response->status(201);
            $app->response->headers->set('Location', $base_uri.'/task/'.$taskCreate->getInsertedId());
        // if save failed, return 500
        } else {
            $app->response->status(500);
        }
    }
    
    public function taskUpdateAction(&$app, $xml) {
        
    }
}

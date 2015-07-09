<?php
    
namespace TodoAPI;

class Controller {
    public function taskListAction(&$app, $db = null) {
        $taskList = TaskListFactory::build();
        $base_uri = $app->request->getRootUri();
        
        // set status and reply with data
        if ($taskList->isError()) {
            $app->response->status(500);
        } else {
            $app->response->status(200);
            echo $taskList->outputXML($base_uri);
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
            $app->response->status(400);
        // save to database
        } elseif ($taskCreate->save()) {
            $app->response->status(201);
            $location = $base_uri.'/task/'.$taskCreate->getInsertedId();
            $app->response->headers->set('Location', $location);
        // if save failed, return 500
        } else {
            $app->response->status(500);
        }
    }
    
    public function taskUpdateAction(&$app, $id, $xml) {
        $base_uri = $app->request->getRootUri();
        $taskUpdate = TaskUpdateFactory::build();

        // attemps to load an existing object and updates information from xml
        // if failed to load from database, return Not Found
        if (!$taskUpdate->loadFromDB($id)) {
            $app->response->status(404);
            return;
        }
        
        // update with new data
        $updated = $taskUpdate->updateFromXML($xml);

        // if object is not valid, return Bad Request
        if (!$updated) {
            $app->response->status(400);
            
        // save to database
        } elseif ($taskUpdate->save()) {
            $app->response->status(201);
            $location = $base_uri.'/task/'.$id;
            $app->response->headers->set('Location', $location);
            
        // if save failed, return 500
        } else {
            $app->response->status(500);
        }
    }
    
    public function taskDeleteAction(&$app, $id) {
        $db = new Database();
        $task = $db->getTaskById($id);
        
        if (!empty($task)) {
            $deleted = $db->deleteTask($task->id);
        }
        
        // error in connection
        if ($task === false || $deleted === false) {
            $app->response->status(500);
        // not found
        } elseif (empty($task)) {
            $app->response->status(404);
        // success
        } else {
            $app->response->status(204);
        }
    }
    
    public function frontAction(&$app) {
        echo '<!DOCTYPE html>';
        echo '<html lang="en">';
        echo '<body>';
    
        echo '<h1>To do list</h1>';
        $db = new Database();
        $list = $db->getTaskList();
        
        echo '<table border="1" style="width:100%;">';
        echo '<tr><th>ID</th><th>task</th><th>progress</th></tr>';
        foreach ($list as $item) {
            echo '<tr>';
            echo '<td>'.$item['id'].'</td>';
            echo '<td>'.$item['description'].'</td>';
            echo '<td>'.$item['progress'].' %</td>';
            echo '</tr>';
        }
        echo '</table>';
        
        echo '</body>';
        echo '</html>';
    }
}

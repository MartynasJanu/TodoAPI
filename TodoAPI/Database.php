<?php

namespace TodoAPI;

class Database
{
    private $conn = null;
    
    private function getConnection() {
        // prevent reconnection
        if ($this->conn != null) {
            return true;
        }
        
        $dbhost = 'localhost';
        $dbuser = 'root';
        $dbpass = 'omega';
        $dbname = 'todoAPI';
        
        try {
            $this->conn = new \PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function insert($task)
    {
        if (file_exists('db')) {
            $db = unserialize(file_get_contents('db'));
        } else {
            $db = array();
        }
        
        $array = json_decode(json_encode($task), true);
        $array['id'] = count($db)+1;
        $db[] = $array;
        
        file_put_contents('db', serialize($db));
        
        return $array['id'];
    }
    
    public function getTaskList()
    {
        $this->getConnection();
        
        $sql = 'SELECT id, description, progress FROM `task`';
        $statement = $this->conn->prepare($sql);
        $statement->execute();
        
        return $statement->fetchAll();
    }
    
    public function getTaskById($id)
    {
        if (!$this->getConnection()) {
            return false;
        }

        $sql = 'SELECT id, description, progress FROM `task` WHERE `id` = :id';
        $statement = $this->conn->prepare($sql);
        $statement->bindParam('id', $id);
       
        $statement->execute();
        $object = $statement->fetchObject();
        
        if ($object) {
            $task = new Task();
            $task->fromObject($object);
            return $task;
        } else {
            return [];
        }
    }
}

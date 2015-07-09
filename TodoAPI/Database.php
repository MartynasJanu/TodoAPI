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
    
    public function insertTask($task)
    {
       if (!$this->getConnection()) {
            return 0;
        }
        
        $sql = 'INSERT INTO `task` (`description`, `progress`)
                VALUES (:description, :progress)';
        $statement = $this->conn->prepare($sql);
        
        $statement->bindParam('description', $task->description);
        $statement->bindParam('progress', $task->progress);
        $statement->execute();
        
        return $this->conn->lastInsertId();
    }
    
    public function getTaskList()
    {
        if (!$this->getConnection()) {
            return null;
        }
        
        $sql = 'SELECT `id`, `description`, `progress` FROM `task`';
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

<?php

namespace TodoAPI;

class Database
{
    private $conn = null;
    
    public function setConnection($conn) {
        $this->conn = $conn;
    }
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
        
        if ($statement->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return 0;
        }
    }
    
    public function updateTask($task) {
        if (!$this->getConnection()) {
            return false;
        }
        
        $sql = 'UPDATE `task` SET `description` = :description,
                `progress` = :progress
                WHERE `id` = :id';
        $statement = $this->conn->prepare($sql);
        
        $statement->bindParam('id', $task->id);
        $statement->bindParam('description', $task->description);
        $statement->bindParam('progress', $task->progress);
        
        return $statement->execute();
    }
    
    public function getTaskList()
    {
        if (!$this->getConnection()) {
            return null;
        }
        
        $sql = 'SELECT `id`, `description`, `progress` FROM `task`';
        $statement = $this->conn->prepare($sql);
        
        if ($statement->execute()) {
            return $statement->fetchAll();
        } else {
            return null;
        }
    }
    
    public function getTaskById($id)
    {
        if (!$this->getConnection()) {
            return false;
        }

        $sql = 'SELECT id, description, progress FROM `task` WHERE `id` = :id';
        $statement = $this->conn->prepare($sql);
        $statement->bindParam('id', $id);
       
        if ($statement->execute()) {
            $object = $statement->fetchObject();
        } else {
            return false;
        }
        
        if ($object) {
            $task = new Task();
            $task->fromObject($object);
            return $task;
        } else {
            return [];
        }
    }
    
    public function deleteTask($id) {
        if (!$this->getConnection()) {
            return false;
        }
        
        $sql = 'DELETE FROM `task` WHERE `id` = :id';
        $statement = $this->conn->prepare($sql);
        $statement->bindParam('id', $id);
        
        return $statement->execute();
    }
}

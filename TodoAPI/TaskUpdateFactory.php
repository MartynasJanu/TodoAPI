<?php
    
namespace TodoAPI;

class TaskUpdateFactory
{
    public static function build()
    {
        $db = new Database();
        return new TaskUpdate($db);
    }
}

<?php
    
namespace TodoAPI;

class TaskCreateFactory
{
    public static function build()
    {
        $db = new Database();
        return new TaskCreate($db);
    }
}

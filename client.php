<?php

$data = '<?xml version="1.0" encoding="UTF-8" ?>
<task>
    <description>My edited task</description>
    <progress>75</progress>
</task>';


$ch = curl_init('http://localhost/BAA/todoapi/api/v1/task/2');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_HTTPHEADER, [
//    'Content-Type: application/xml',
//    'Content-Length: ' . strlen($data)]
//);


echo '<xmpx>'.curl_exec($ch).'</xmp>';
echo curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

/*

$app->get('/tasks', function () use ($app, $log) {
    $taskList = TaskListFactory::create();
    $taskList->reply();
});

// ................. //

class TaskList {
    private $xmlo;
    private $db;
    public __construct($xmlo = NULL, $db = NULL) {
        $this->xmlo = $xmlo;
        $this->db = $db;
    }
    private function getData() {
        return $this->db->getData();
    }
    
    public function reply() {
        $data = $this->getData();
        $this->xmlo($data);
    }
}

class TaskListFactory {
    public static function create() {
        $db = new DB();
        $xmlo = new XMLo();
        return new TaskList($db, $xmlo);
    }
}

// .............. //

// test TaskList::getData();
$taskList = new TaskList($db, NULL);
*/

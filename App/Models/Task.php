<?php

namespace App\Models;

class Task
{
    public $id;
    public $userId;
    public $description;
    public $completed;

    public static function fromArray($array) : Task
    {
        $task = new Task();
        $task->id = $array['id'];
        $task->userId = $array['userId'];
        $task->description = $array['description'];
        $task->completed = $array['completed'];
        return $task;
    }
}
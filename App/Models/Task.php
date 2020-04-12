<?php

namespace App\Models;

class Task
{
    public int $id;
    public int $userId;
    public string $description;
    public bool $completed;

    public static function fromArray(array $array) : Task
    {
        $task = new Task();
        $task->id = $array['id'];
        $task->userId = $array['userId'];
        $task->description = $array['description'];
        $task->completed = $array['completed'];
        return $task;
    }
}
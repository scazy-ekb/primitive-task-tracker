<?php

namespace App\DataModels;

class Task
{
    public int $id;
    public string $username;
    public string $email;
    public string $description;
    public bool $status;

    public static function fromArray(array $array) : Task
    {
        $task = new Task();
        $task->id = $array['id'];
        $task->username = $array['username'];
        $task->email = $array['email'];
        $task->description = $array['description'];
        $task->status = $array['status'];
        return $task;
    }
}
<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\TaskDataService;
use App\Services\UserDataService;
use App\ViewModels\CreateTaskRequest;
use App\ViewModels\EditTaskRequest;
use App\ViewModels\PageRequest;

class TaskController extends Controller
{
    private UserDataService $userDataService;
    private TaskDataService $taskDataService;

    public function __construct(UserDataService $userDataService, TaskDataService $taskDataService)
    {
        $this->userDataService = $userDataService;
        $this->taskDataService = $taskDataService;
    }

    public function getTasks(PageRequest $model) : void
    {
        if (!empty($model->errors()))
            $this->json(['errors' => $model->errors()]);

        $tasks = $this->taskDataService->getTasks($model->page, $model->count, $model->column, $model->order);
        $tasksCount = $this->taskDataService->getTasksCount();
        $this->json([ 'tasks' => $tasks, 'totalRowsCount' => $tasksCount]);
    }

    public function createTask(CreateTaskRequest $model) : void
    {
        if (!empty($model->errors()))
            $this->jsonError(['errors' => $model->errors()]);

        $id = $this->taskDataService->createTask($model->username, $model->email, htmlspecialchars($model->description), $model->status);

        $this->json($id);
    }

    public function editTask(EditTaskRequest $model) : void
    {
        if ($this->isAuthenticated()) {
            $user = $this->userDataService->getUser($this->userId);
            if ($user->login != 'admin')
                $this->unauthorized();
        }

        if (!empty($model->errors()))
            $this->json(['errors' => $model->errors()]);

        $this->taskDataService->editTask($model->id, $model->description, $model->status);
    }
}
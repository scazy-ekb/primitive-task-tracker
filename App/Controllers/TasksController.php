<?php

namespace App\Controllers;

use App\Services\TaskDataService;
use App\Services\UserDataService;

class TasksController extends Controller
{
    private $userDataService;
    private $taskDataService;

    public function __construct(UserDataService $userDataService, TaskDataService $taskDataService)
    {
        $this->userDataService = $userDataService;
        $this->taskDataService = $taskDataService;
    }

    public function index() : void
    {
        $user = $this->userDataService->getUser('admin');
        $tasks = $this->taskDataService->getTasks(0, 10, 'id', 'asc');

        $this->json([
            'tasks' => $tasks
        ]);
    }
}
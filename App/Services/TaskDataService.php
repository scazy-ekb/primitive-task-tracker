<?php

namespace App\Services;

require_once 'App/Models/Task.php';

use App\Models\Task;

class TaskDataService
{
    private DataService $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    public function getTasks(int $page, int $count, string $col, string $order) : array
    {
        $offset = $page*$count;

        $count = $count == 0 ? 10 : $count;
        $col = empty($col) ? "id" : $col;
        $order = empty($order) ? "ASC" : $order;

        $query = "SELECT * FROM `tasks` ORDER BY `$col` $order LIMIT $count OFFSET $offset";

        $result = array();
        $connection = $this->dataService->getConnection();
        $sqlResult = $connection->query($query);

        while ($row = $sqlResult->fetchArray()) {
            $result[] = Task::fromArray($row);
        }

        $sqlResult->free_result();
        return $result;
    }
}

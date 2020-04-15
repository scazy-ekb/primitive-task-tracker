<?php

namespace App\Services;

require_once 'App/DataModels/Task.php';

use App\DataModels\Task;

class TaskDataService
{
    private DataService $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    public function getTasks(int $page, int $count, string $column, bool $order) : array
    {
        $offset = $page*$count;

        $count = $count == 0 ? 10 : $count;
        $column = empty($column) ? "id" : $column;
        $orderKeyword = $order ? "ASC" : "DESC";

        $query = "SELECT * FROM `tasks` ORDER BY `$column` $orderKeyword LIMIT $count OFFSET $offset";

        $result = array();
        $connection = $this->dataService->getConnection();
        $sqlResult = $connection->query($query);

        if ($sqlResult === null)
            return array();

        while ($row = $sqlResult->fetchArray()) {
            $result[] = Task::fromArray($row);
        }

        $sqlResult->free_result();
        return $result;
    }

    public function getTasksCount() : int
    {
        $query = "SELECT count(*) AS `count` FROM `tasks`;";

        $connection = $this->dataService->getConnection();
        $sqlResult = $connection->query($query);

        if ($sqlResult === null)
            return 0;

        $result = ($row = $sqlResult->fetchArray()) ? $row['count'] : 0;
        $sqlResult->free_result();
        return $result;
    }

    public function createTask(string $username, string $email, string $description, bool $status) : int
    {
        $connection = $this->dataService->getConnection();
        $description_esc = $connection->escape($description);
        $query = "INSERT INTO `tasks` (`username`, `email`, `description`, `status`) VALUES ('$username', '$email', '$description_esc', $status);";
        return $connection->insert($query);
    }

    public function editTask(int $id, string $description, bool $status) : void
    {
        $connection = $this->dataService->getConnection();
        $description_esc = $connection->escape($description);
        $query = "UPDATE `tasks` SET `description`='$description_esc', `status`=$status WHERE `id`=$id;";
        $connection->execute($query);
    }
}

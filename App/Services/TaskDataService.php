<?php

namespace App\Services;

require_once 'App/Models/Task.php';

use App\Core\SqlConnection;
use App\Models\Task;

class TaskDataService
{
    private $connection;

    public function __construct(SqlConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getTasks($page, $count, $col, $order) : array
    {
        $offset = $page*$count;

        $count = $count == 0 ? 10 : $count;
        $col = empty($col) ? "id" : $col;
        $order = empty($order) ? "ASC" : $order;

        $query = "SELECT * FROM `tasks` ORDER BY `$col` $order LIMIT $count OFFSET $offset";

        $result = array();

        $sqlResult = $this->connection->execute($query);

        while ($row = $sqlResult->fetchArray()) {
            $result[] = Task::fromArray($row);
        }

        return $result;
    }
}

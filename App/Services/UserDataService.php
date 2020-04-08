<?php

namespace App\Services;

require_once 'App/Models/User.php';

use App\Core\SqlConnection;
use App\Models\User;

class UserDataService
{
    private $connection;

    public function __construct(SqlConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getUser($login) : User
    {
        //$login = $this->connection->escape($login);

        $query = "SELECT * FROM `users` WHERE `login`='$login'";

        $sqlResult = $this->connection->execute($query);

        if (!$sqlResult)
            return null;

        $arr = $sqlResult->fetchArray();

        return User::fromArray($arr);
    }
}

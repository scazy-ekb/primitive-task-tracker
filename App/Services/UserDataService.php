<?php

namespace App\Services;

require_once 'App/DataModels/User.php';

use App\DataModels\User;

class UserDataService
{
    private DataService $dataService;
    private string $secret;

    public function __construct(ConfigService $configService, DataService $dataService)
    {
        $this->secret = $configService->Get('secret');
        $this->dataService = $dataService;
    }

    public function getUserByName(string $login) : ?User
    {
        $connection = $this->dataService->getConnection();
        $login = $connection->escape($login);
        $query = "SELECT * FROM `users` WHERE `login`='$login'";
        $sqlResult = $connection->query($query);

        if (!$sqlResult || $sqlResult->RowsCount() == 0)
            return null;

        $arr = $sqlResult->fetchArray();
        $sqlResult->free_result();
        return User::fromArray($arr);
    }

    public function getUser(int $id) : ?User
    {
        $connection = $this->dataService->getConnection();

        $query = "SELECT * FROM `users` WHERE `id`='$id'";
        $sqlResult = $connection->query($query);

        if (!$sqlResult || $sqlResult->RowsCount() == 0)
            return null;

        $arr = $sqlResult->fetchArray();
        $sqlResult->free_result();
        return User::fromArray($arr);
    }

    public function createUser($name, $email, $password) : bool
    {
        $connection = $this->dataService->getConnection();
        $passwrd_hash = md5($this->secret.$password);
        $query = "INSERT INTO `users` (`login`, `email`, `password`) VALUES ('$name', '$email', '$passwrd_hash')";
        return $connection->execute($query);
    }

    public function checkPassword(int $id, string $password) : bool
    {
        $connection = $this->dataService->getConnection();
        $query = "SELECT `password` FROM `users` WHERE `id`='$id'";
        $sqlResult = $connection->query($query);

        if (!$sqlResult || $sqlResult->RowsCount() != 1)
            return false;

        $arr = $sqlResult->fetchArray();
        $sqlResult->free_result();

        return $arr['password'] == md5($this->secret.$password);
    }
}

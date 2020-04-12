<?php

namespace App\Services;

use App\Core\SqlConnection;

class DataService
{
    private ConfigService $configService;
    private SqlConnection $connection;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    public function getConnection()
    {
        if (!isset($this->connection)) {
            $this->connection = new SqlConnection();

            $this->connection->connect(
                $this->configService->Get('host'),
                $this->configService->Get('user'),
                $this->configService->Get('password'),
                $this->configService->Get('db')
            );
        }

        return $this->connection;
    }
}
<?php

require_once 'Config/AppConfig.php';
require_once 'App/Core/Container.php';
require_once 'App/Core/Router.php';
require_once 'App/Core/SqlConnection.php';
require_once 'App/Services/UserDataService.php';
require_once 'App/Services/TaskDataService.php';
require_once 'App/Services/AuthService.php';
require_once 'App/Controllers/Controller.php';
require_once 'App/Controllers/HomeController.php';
require_once 'App/Controllers/TasksController.php';

use App\Core\SqlConnection;
use App\Services\AuthService;
use App\Services\TaskDataService;
use App\Services\UserDataService;
use Config\AppConfig;

session_start();

try {

    Config\AppConfig::init();

    $ioc = new App\Core\Container();

    $ioc->register(UserDataService::class);
    $ioc->register(TaskDataService::class);
    $ioc->register(AuthService::class);

    $connection = new SqlConnection();
    $connection->connect(AppConfig::$host, AppConfig::$user, AppConfig::$password, AppConfig::$db);
    AppConfig::$password = '';

    $ioc->register(SqlConnection::class, $connection);

    $router = new App\Core\Router($ioc);

    $router->route($_SERVER['REQUEST_URI']);
} catch (\Exception $e) {
    echo $e->getMessage();
    http_response_code(500);
    exit;
}

<?php

require_once 'App/Core/Container.php';
require_once 'App/Core/Router.php';
require_once 'App/Core/Controller.php';
require_once 'App/Core/SqlConnection.php';

require_once 'App/Services/ConfigService.php';
require_once 'App/Services/DataService.php';
require_once 'App/Services/AuthService.php';
require_once 'App/Services/UserDataService.php';
require_once 'App/Services/TaskDataService.php';

require_once 'App/Controllers/AccountController.php';
require_once 'App/Controllers/PageController.php';
require_once 'App/Controllers/TasksController.php';

try {

    $ioc = new App\Core\Container();

    $ioc->register(App\Services\AuthService::class);
    $ioc->register(App\Services\DataService::class);
    $ioc->register(App\Services\UserDataService::class);
    $ioc->register(App\Services\TaskDataService::class);
    $ioc->register(App\Services\ConfigService::class);

    include 'config.php';

    $router = new App\Core\Router($ioc);
    $router->route($_SERVER['REQUEST_URI']);

} catch (\Throwable $e) {
    http_response_code(500);
    echo "<h3>Internal Server Error</h3>";
    echo "<p>Message: ".$e->getMessage()."</p>";
    //echo "<p>Place: ".$e->getLine()."</p>";
    exit;
}

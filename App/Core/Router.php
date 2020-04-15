<?php

namespace App\Core;

use App\Services\AuthService;
use ReflectionClass;

class Router
{
    const DEFAULT_CONTROLLER = "page";
    const DEFAULT_ACTION = "index";
    const PATH_REGEX = '%^/(?P<controller>[^/\\\\.]+)/(?P<action>[^/\\\\.\?]+).*$%x';

    private Container $ioc;

    public function __construct(Container $ioc)
    {
        $this->ioc = $ioc;
    }

    public function route(string $path)
    {
        $route = $this->getRoute($path);

        //TODO: implement fabric to safely init base Controller class using services, such as AuthService

        $authService = $this->ioc->resolve(AuthService::class);
        $authService->authentify();

        $controllerName = "App\\Controllers\\".$route['controller']."Controller";

        if (!class_exists($controllerName))
            $this->notFound();

        $reflectionClass = new \ReflectionClass($controllerName);

        $this->ioc->register($controllerName);

        $controller =  $this->ioc->resolve($controllerName);
        $controller->setCurrentUserId($authService->currentUser());

        try {
            $action = $reflectionClass->getMethod($route['action']);


            //TODO: complete model binding

            $parameters = $action->getParameters();

            $args = [$_REQUEST];

            if (count($parameters) === 1) {
                $parameter = $parameters[0];
                $type = $parameter->getType();

                if (class_exists("$type")) {
                    $class = new ReflectionClass("$type");

                    if ($class->implementsInterface(IBindable::class)) {
                        $instance = $class->newInstance();
                        $instance->bind($_REQUEST);
                        $args = [$instance];
                    }
                }
            }

            $action->invokeArgs($controller, $args);

        } catch (\ReflectionException $e) {
            echo $e->getMessage();
            $this->notFound();
        }
    }

    private function getRoute($path)
    {
        preg_match(Router::PATH_REGEX, $path, $matches);

        return array(
            'controller' => array_key_exists('controller', $matches) ? $matches['controller'] : Router::DEFAULT_CONTROLLER,
            'action' => array_key_exists('action', $matches) ? $matches['action'] : Router::DEFAULT_ACTION
        );
    }

    private function notFound()
    {
        http_response_code(404);
        exit;
    }
}
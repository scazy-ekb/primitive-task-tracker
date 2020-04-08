<?php

namespace App\Core;

class Router
{
    const DEFAULT_CONTROLLER = "home";
    const DEFAULT_ACTION = "index";
    const PATH_REGEX = '%^/(?P<controller>[^/\\\\.]+)/(?P<action>[^/\\\\.\?]+).*$%x';

    private $ioc;

    public function __construct(Container $ioc)
    {
        $this->ioc = $ioc;
    }

    public function route(string $path)
    {
        $route = $this->getRoute($path);

        $controllerName = "App\\Controllers\\".$route['controller']."Controller";

        if (!class_exists($controllerName))
            $this->notFound();

        $reflectionClass = new \ReflectionClass($controllerName);

        $this->ioc->register($controllerName);

        $controller =  $this->ioc->resolve($controllerName);

        try {
            $action = $reflectionClass->getMethod($route['action']);
            $action->invokeArgs($controller, $_REQUEST);
        } catch (\ReflectionException $e) {
            $this->notFound();
        }
    }

    private function notFound()
    {
        http_response_code(404);
        exit;
    }

    private function getRoute($path)
    {
        preg_match(Router::PATH_REGEX, $path, $matches);

        return array(
            'controller' => array_key_exists('controller', $matches) ? $matches['controller'] : Router::DEFAULT_CONTROLLER,
            'action' => array_key_exists('action', $matches) ? $matches['action'] : Router::DEFAULT_ACTION
        );
    }
}
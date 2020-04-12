<?php

namespace App\Core;

use Exception;
use ReflectionClass;

class Container
{
    private array $services;

    public function __construct()
    {
        $this->services = array();
    }

    public function register($name, $instance = null) : void
    {
        if (empty($name))
            throw new Exception('$name');

        $name = strtolower($name);

        if (array_key_exists($name, $this->services))
            throw new Exception("$name already exists");

        $this->services[$name] = $instance;
    }


    public function resolve($name)
    {
        $name = strtolower($name);

        if (!array_key_exists($name, $this->services))
            throw new Exception("name: $name");

        if ($this->services[$name] == null)
            $this->services[$name] = $this->build($name);

        return $this->services[$name];
    }

    private function build($name)
    {
        $reflectionClass = new ReflectionClass($name);

        if (!$reflectionClass->isInstantiable())
            throw new Exception("isn't instantiable");

        $constructor = $reflectionClass->getConstructor();

        if (is_null($constructor))
            return new $name;

        $parameters = $constructor->getParameters();

        if (empty($parameters))
            return new $name;

        $dependencies = $this->resolveDependencies($parameters);
        return $reflectionClass->newInstanceArgs($dependencies);
    }

    private function resolveDependencies($parameters)
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();

            if (is_null($dependency))
                throw new Exception('not a class');

            $dependencies[] = $this->resolve($dependency->name);
        }

        return $dependencies;
    }
}
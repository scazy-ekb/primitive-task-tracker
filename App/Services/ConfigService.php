<?php

namespace App\Services;

class ConfigService
{
    private array $settings;

    public function __construct()
    {
        $this->settings = array();
    }

    public  function Get(string $name)
    {
        return $this->settings[$name];
    }

    public  function Set(string $name, $value): void
    {
        $this->settings[$name] = $value;
    }
}
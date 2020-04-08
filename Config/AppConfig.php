<?php

namespace Config;

class AppConfig
{
    public static $host;
    public static $port;
    public static $db;
    public static $user;
    public static $password;

    public static function init()
    {
        AppConfig::$host = '';
        AppConfig::$port = 3306;
        AppConfig::$db = '';
        AppConfig::$user = '';
        AppConfig::$password = '';
    }
}
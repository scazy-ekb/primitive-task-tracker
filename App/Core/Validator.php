<?php

namespace App\Core;

class Validator
{
    static function isString($str): bool
    {
        return is_string($str) && !empty($str);
    }

    static function isStringWithoutSpaces($str) : bool
    {
        return is_string($str) && preg_match("/^[\w]+$/", $str);
    }

    static function isInt($str): bool
    {
        return isset($str) && preg_match("/^\-?[1-9]\d*$/", $str);
    }

    static function isPositiveInt($str): bool
    {
        return isset($str) && preg_match("/^[1-9]\d*$/", $str);
    }

    static function isNotNegativeInt($str): bool
    {
        return isset($str) && preg_match("/^\+?(0|[1-9]\d*)$/", $str);
    }

    static function isEmail($str): bool
    {
        return filter_var($str, FILTER_VALIDATE_EMAIL);
    }

    static function isBool($str): bool
    {
        return !is_bool($str);
    }
}
<?php

namespace App\Models;

class User
{
    public $id;
    public $login;
    public $email;

    public static function fromArray($array) : User
    {
        $user = new User();
        $user->id = $array['id'];
        $user->login = $array['login'];
        $user->email = $array['email'];
        return $user;
    }
}
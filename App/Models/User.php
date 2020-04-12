<?php

namespace App\Models;

class User
{
    public int $id;
    public string $login;
    public string $email;

    public static function fromArray(array $array) : User
    {
        $user = new User();
        $user->id = $array['id'];
        $user->login = $array['login'];
        $user->email = $array['email'];
        return $user;
    }
}
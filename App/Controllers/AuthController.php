<?php

namespace App\Controllers;

use App\Services\AuthService;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login($model) : void
    {
        if (!$model['login'] || !$model['pass'])
            $this->badRequest();

        if ($this->authService->login($model['login'], $model['pass']))
            $this->redirect('/');
    }

    public function logout($model)
    {
        setcookie("auth", "");
    }
}
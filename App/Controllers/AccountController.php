<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;
use App\Services\UserDataService;

class AccountController extends Controller
{
    private AuthService $authService;
    private UserDataService $userDataService;

    public function __construct(AuthService $authService, UserDataService $userDataService)
    {
        $this->authService = $authService;
        $this->userDataService = $userDataService;
    }

    public function register($model) : void
    {
        $name = $model['name'];
        $email = $model['email'];
        $password = $model['password'];

        if (empty($name) || empty($email) || empty($password))
            $this->badRequest();

        if (!$this->userDataService->createUser($name, $email, $password))
            $this->conflict();
    }

    public function login($model) : void
    {
        $name = $model['name'];
        $password = $model['password'];

        if (!$name || !$password)
            $this->badRequest();

        if (!$this->authService->login($name, $password))
            $this->unauthorized();

        $this->json();
    }

    public function logout()
    {
        $this->authService->logout();
    }
}
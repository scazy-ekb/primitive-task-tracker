<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;
use App\Services\UserDataService;

class PageController extends Controller
{
    private AuthService $authService;
    private UserDataService $userDataService;

    public function __construct(AuthService $authService, UserDataService $userDataService)
    {
        $this->authService = $authService;
        $this->userDataService = $userDataService;
    }

    public function index() : void
    {
        $user = $this->userDataService->getUser($this->userId);

        $mode = $user !== null && $user->login === 'admin' ? 'admin' : 'user';

        $this->view('Page/Index', [
            'isAuthenticated' => $user !== null,
            'username' => $user !== null ? $user->login : "",
            'mode' => $mode
        ]);
    }

    public function login() : void
    {
        if ($this->authService->isAuthenticated())
            $this->redirect('/');

        $this->view('Page/Login');
    }

    public function register() : void
    {
        if ($this->authService->isAuthenticated())
            $this->redirect('/');

        $this->view('Page/Register');
    }

    public function logout() : void
    {
        $this->authService->logout();
        $this->redirect('/');
    }
}
<?php

namespace App\Controllers;

use App\Services\UserDataService;

class HomeController extends Controller
{
    private $userDataService;

    public function __construct(UserDataService $userDataService)
    {
        $this->userDataService = $userDataService;
    }

    public function index() : void
    {
        echo $a->b;
        $user = $this->userDataService->getUser('admin');

        $this->view('Home/Index', [
            'login' => $user->login,
            'email' => $user->email
        ]);
    }
}
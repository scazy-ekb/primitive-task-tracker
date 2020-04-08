<?php

namespace App\Services;

class AuthService
{
    private $userDataService;

    public function __construct(UserDataService $userDataService)
    {
        $this->userDataService = $userDataService;
    }

    public function authentificate()
    {
        if (empty($_SESSION['auth'])) {
            header('Location: /');
            exit();
        }
    }

    public function authentificateBasic()
    {
        $user = $_SERVER['PHP_AUTH_USER'] ?? "";
        $pass = $_SERVER['PHP_AUTH_PW'] ?? "";

        if (!$this->validate($user, $pass)) {
            $_SESSION['auth'] = false;
            header('WWW-Authenticate: Basic realm="dummy"');
            header('HTTP/1.0 401 Unauthorized');
            exit;
        }

        $_SESSION['auth'] = $user;
    }

    public function login($login, $pass)
    {
        if (empty($login) || empty($pass))
            return false;

        if (!$this->validate($login, $pass)) {
            $_SESSION['auth'] = false;
            return false;
        }

        $_SESSION['auth'] = $_POST['login'];
        return true;
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
        exit;
    }

    private function validate($login, $pass)
    {
        $user = $this->userDataService->getUser($login);

        //TODO: user check
        return $login === 'admin' && $pass === '123';
    }
}
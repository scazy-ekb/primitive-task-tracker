<?php

namespace App\Services;

class AuthService
{
    private UserDataService $userDataService;
    private string $auth_cookie_name;
    private string $secret;
    private string $domain;
    private int $currentUserId;

    public function __construct(ConfigService $configService, UserDataService $userDataService)
    {
        $this->auth_cookie_name = $configService->Get('auth_cookie_name');
        $this->domain = $configService->Get('domain');
        $this->secret = $configService->Get('secret');
        $this->userDataService = $userDataService;
        $this->currentUserId = -1;
    }

    public function isAuthenticated() : bool
    {
        return $this->currentUserId > 0;
    }

    public function currentUser() : int
    {
        return $this->currentUserId;
    }

    public function authentify() : bool
    {
        $cookie = $_COOKIE[$this->auth_cookie_name];

        if (!$cookie)
            return false;

        $encrypted_cookie = openssl_decrypt($cookie, "AES-128-ECB", $this->secret);
        $value = explode(":", $encrypted_cookie);
        $this->currentUserId = (int)$value[0];
        return true;
    }

    public function login(string $name, string $password) : bool
    {
        if (empty($name) || empty($password))
            return false;

        if (!$this->validateUser($name, $password))
            return false;

        $value = $this->currentUserId.":".rand();
        $encrypted_cookie = openssl_encrypt($value, "AES-128-ECB", $this->secret);
        setcookie($this->auth_cookie_name, $encrypted_cookie, time()+86400, "/", $this->domain, false, true);
        return true;
    }

    public function logout() : void
    {
        setcookie($this->auth_cookie_name, "", 0, "/", $this->domain, false, true);
    }

    private function validateUser(string $name, string $pass) : int
    {
        $user = $this->userDataService->getUserByName($name);

        if ($user === null)
            return false;

        if (!$this->userDataService->checkPassword($user->id, $pass))
            return false;

        $this->currentUserId = $user->id;
        return true;
    }
}
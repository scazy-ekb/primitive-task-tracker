<?php

namespace App\Core;

class Controller
{
    protected ?int $userId = null;

    public function setCurrentUserId(int $userId)
    {
        if ($this->userId === null)
            $this->userId = $userId;
    }

    protected function view($view, $model = array())
    {
        $data = array(
            'viewPath' => $view.'.php',
            'model' => $model
        );

        extract($data);
        require __DIR__ . '/../Views/Layout.php';
    }

    protected function json($data = null)
    {
        header('Content-Type: application/json', true);
        echo json_encode($data);
        exit();
    }

    protected function jsonError($data = null)
    {
        header('Content-Type: application/json', true);
        http_response_code(400);
        echo json_encode($data);
        exit();
    }

    protected function isAuthenticated()
    {
        return $this->userId !== null && $this->userId > -1;
    }

    protected function redirect($url)
    {
        header("Location: $url");
    }

    protected function badRequest()
    {
        http_response_code(400);
        exit();
    }

    protected function unauthorized()
    {
        http_response_code(401);
        exit();
    }

    protected function conflict()
    {
        http_response_code(409);
        exit();
    }
}
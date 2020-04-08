<?php

namespace App\Controllers;

class Controller
{
    protected function view($view, $model = array())
    {
        $data = array(
            'viewPath' => $view.'.php',
            'model' => $model
        );

        extract($data);
        require __DIR__.'/../Views/Layout.php';
    }

    protected function json($data)
    {
        echo json_encode($data);
        header('Content-Type', 'application/json');
    }

    protected function isAuthentificated()
    {
        if ($_COOKIE['auth'])
            //$auth =

        if ($auth) {

        }
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
}
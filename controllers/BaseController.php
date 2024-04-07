<?php

class BaseController
{
    public $view;

    protected function changeRequestToGET()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
    }

    protected function requestIsGET()
    {
        return $_SERVER['REQUEST_METHOD'] == "GET";
    }

    protected function requestIsPOST()
    {
        return $_SERVER['REQUEST_METHOD'] == "POST";
    }

    protected function requestIsPUT()
    {
        return $_SERVER['REQUEST_METHOD'] == "PUT";
    }

    protected function requestIsDELETE()
    {
        return $_SERVER['REQUEST_METHOD'] == "DELETE";
    }

    protected function isAdmin()
    {
        $session = new Session();
        $isAdmin = $session->get("is-admin") == true;

        if ($isAdmin) {
            return true;
        }

        return false;
    }

    protected function isUserLogged()
    {
        $session = new Session();

        if ($session->has("usuario-logado")) {
            return true;
        }

        return false;
    }

    protected function stringIsNotEmpty($value)
    {
        if (!$value || strlen(trim($value)) == 0) {
            return false;
        }

        return true;
    }
}

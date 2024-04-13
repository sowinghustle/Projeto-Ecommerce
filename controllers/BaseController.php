<?php

require_once "models/Session.php";

class BaseController
{
    public $view;
    public $session;

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

    protected function isUserLogged()
    {
        if ($this->session->has("usuario-logado")) {
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

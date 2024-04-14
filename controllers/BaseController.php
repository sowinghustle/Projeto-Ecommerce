<?php

require_once "models/Session.php";

class BaseController
{
    public $view;
    public Session $session;

    protected function requestIsGET()
    {
        return $_SERVER['REQUEST_METHOD'] == "GET";
    }

    protected function requestIsPOST()
    {
        return $_SERVER['REQUEST_METHOD'] == "POST";
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

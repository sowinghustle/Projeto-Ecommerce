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

    protected function getLoggedUserId()
    {
        if (!$this->isUserLogged())
            return null;

        return $this->session->get("usuario-logado");
    }

    protected function isUserLogged()
    {
        return $this->session->has("usuario-logado");
    }

    protected function stringIsNotEmpty($value)
    {
        if (!$value || strlen(trim($value)) == 0) {
            return false;
        }

        return true;
    }
}

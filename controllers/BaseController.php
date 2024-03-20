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
}

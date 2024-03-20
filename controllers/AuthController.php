<?php

require_once "BaseController.php";

class AuthController extends BaseController
{
    public function index() 
    {
        $this->view->title = "Home";
        include "views/home/index.php";
    }
}

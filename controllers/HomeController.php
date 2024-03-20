<?php

require_once "BaseController.php";

class HomeController extends BaseController
{
    public function index() 
    {
        $this->view->title = "Home";
        include "views/home/index.php";
    }
}

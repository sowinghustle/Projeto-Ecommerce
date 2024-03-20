<?php

require_once "BaseController.php";
require_once "models/Database.php";

class HomeController extends BaseController
{
    public function index()
    {
        $this->view->title = "Home";
        include "views/home/index.php";
    }
}

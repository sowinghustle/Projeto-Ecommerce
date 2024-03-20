<?php

require_once "BaseController.php";
require_once "models/Database.php";

class HomeController extends BaseController
{
    public function index()
    {
        try {
            $db = new Database();
        } catch (Exception $e) {
            echo $e;
        }

        $this->view->title = "Home";
        include "views/home/index.php";
    }
}

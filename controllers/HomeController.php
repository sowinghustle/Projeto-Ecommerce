<?php

require_once "BaseController.php";
require_once "models/User.php";

class HomeController extends BaseController
{
    public function index()
    {
        $userId = $this->session->get('usuario-logado');
        $this->view->title = "Home";
        include "views/home/index.php";
    }
}

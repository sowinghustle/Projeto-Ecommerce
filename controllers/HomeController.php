<?php

require_once "BaseController.php";
require_once "models/Database.php";
require_once "models/Client.php";
require_once "models/Session.php";

class HomeController extends BaseController
{
    public function index()
    {
        $session = new Session();
        $userId = $session->get('usuario-logado');
        $this->view->title = "Home";
        include "views/home/index.php";
    }
}

<?php

require_once "BaseController.php";
require_once "models/Database.php";
require_once "models/Client.php";

class HomeController extends BaseController
{
    public function index()
    {
        if ($this->requestIsGET()) {
            $client = new Client("delt4d", "delt4d@email.com", "12345678");
            var_dump($client->save());
        }

        $this->view->title = "Home";
        include "views/home/index.php";
    }
}

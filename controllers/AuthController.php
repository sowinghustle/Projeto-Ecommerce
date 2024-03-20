<?php

require_once "BaseController.php";

class AuthController extends BaseController
{
    public function index()
    {
        $this->view->title = "Home";
        include "views/home/index.php";
    }
    public function login()
    {
        $this->view->title = "Login";
        include "views/login/login.php";
    }
    public function register()
    {
        $this->view->title = "Signin";
        include "views/login/signin.php";
    }
    public function logout()
    {
        $this->view->title = "Logout";
        header("location:login");
    }
}

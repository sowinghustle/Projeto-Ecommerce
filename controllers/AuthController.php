<?php

require_once "BaseController.php";

class AuthController extends BaseController
{
    public function login()
    {
        $this->view->title = "Login";
        include "views/auth/login.php";
    }
    public function register()
    {
        $this->view->title = "Signin";
        include "views/auth/register.php";
    }
    public function logout()
    {
        $this->view->title = "Logout";
        header("location:login");
    }
}

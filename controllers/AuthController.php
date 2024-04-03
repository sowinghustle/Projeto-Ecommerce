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
        $this->view->username = "";
        $this->view->email = "";
        $this->view->errorMsg = "";
        $this->view->successMsg = "";

        if ($this->requestIsPOST()) {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            $client = new Client($username, $email, $password);
            $result = $client->save();

            if ($result[0] == false) {
                $this->view->username = $username;
                $this->view->email = $email;
                $this->view->errorMsg = $result[1];
            } else {
                $this->view->successMsg = "O usuário foi cadastrado com sucesso!";
            }
        }

        $this->view->title = "Create account";
        include "views/auth/register.php";
    }
    public function logout()
    {
        $this->view->title = "Logout";
        header("location:login");
    }
}

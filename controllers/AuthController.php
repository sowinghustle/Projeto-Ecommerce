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

            $this->view->username = $username;
            $this->view->email = $email;


            $client = new Client($username, $email, $password);
            $checkIfUserExistsResult = $client->findByUsernameEmailAndPassword(true);

            if ($checkIfUserExistsResult[0] == false) { // deu erro
                $this->view->errorMsg = $checkIfUserExistsResult[1];
            } else if ($checkIfUserExistsResult[1] == true) { // encontrou um usuário com mesmo email ou uusário
                $this->view->errorMsg = "Já existe um usuário cadastrado com este e-mail ou nome de usuário.";
            } else {
                $saveResult = $client->save();

                if ($saveResult[0] == false) { // deu erro
                    $this->view->errorMsg = $saveResult[1];
                } else {
                    $this->view->username = "";
                    $this->view->email = "";
                    $this->view->successMsg = "O usuário foi cadastrado com sucesso!";
                }
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

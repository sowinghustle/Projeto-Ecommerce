<?php

require_once "BaseController.php";
require_once "models/Session.php";
require_once "models/Bookerr.php";

class AuthController extends BaseController
{
    public function login()
    {
        $this->view->emailOrUsername = "";
        $this->view->password = "";
        $this->view->errorMsg = "";
        $this->view->successMsg = "";

        if ($this->requestIsPOST()) {
            try {
                $usernameOrEmail = trim($_POST["email"] ?? "");
                $password = $_POST["password"] ?? "";

                $this->view->usernameOrEmail = $usernameOrEmail;

                $client = new Client($usernameOrEmail, $usernameOrEmail, $password);

                if (!$this->stringIsNotEmpty($usernameOrEmail))
                    throw Bookerr::ValidationError("Você precisa fornecer um nome de usuário ou e-mail!");

                if (!$this->stringIsNotEmpty($password))
                    throw Bookerr::ValidationError("Você precisa fornecer uma senha!");

                if (!$client->fillWithUserByUsernameOrEmailAndPassword())
                    throw Bookerr::ValidationError("Verifique se as credenciais estão corretas!");

                $session = new Session();
                $session->set("usuario-logado", $client->getId());
                $session->set("is-admin", $client->getIsAdmin());

                header("location:.");
            } catch (Bookerr $error) {
                $this->view->errorMsg = $error->getMessage();
            }
        } else {
            $session = new Session();

            if ($session->has("email")) {
                $this->view->usernameOrEmail = $session->get("email");
                $session->unset("email");
            }

            if ($session->has("password")) {
                $this->view->password = $session->get("password");
                $session->unset("password");
            }

            if ($session->has("success_msg")) {
                $this->view->successMsg = $session->get("success_msg");
                $session->unset("success_msg");
            }
        }

        $this->view->title = "Login";
        include "views/auth/login.php";
    }

    public function register()
    {
        $this->view->username = "";
        $this->view->email = "";
        $this->view->errorMsg = "";

        if ($this->requestIsPOST()) {
            $client = null;

            try {
                $username = trim($_POST["username"] ?? "");
                $email = trim($_POST["email"] ?? "");
                $password = $_POST["password"] ?? "";

                $this->view->username = $username;
                $this->view->email = $email;

                $client = new Client($username, $email, $password);

                if (!$this->stringIsNotEmpty($username))
                    throw Bookerr::ValidationError("Você precisa fornecer um nome de usuário!");

                if (!$this->stringIsNotEmpty($email))
                    throw Bookerr::ValidationError("Você precisa fornecer um e-mail!");

                if (!$this->stringIsNotEmpty($password))
                    throw Bookerr::ValidationError("Você precisa fornecer uma senha!");

                if (!$client->save()) {
                    throw Bookerr::BadRequest("Não foi possível salvar os dados de usuário! Tente novamente mais tarde.");
                }

                $session = new Session();
                $session->set("email", $email);
                $session->set("password", $password);
                $session->set("success_msg", "Usuário cadastrado com sucesso! Faça o login.");

                header("location:login");
            } catch (Bookerr $error) {
                $this->view->errorMsg = $error->getMessage();

                if ($client && $client->fillWithUserByUsernameOrEmailAndPassword(true)) {
                    $this->view->errorMsg = "Este usuário já existe!";
                }
            }
        }

        $this->view->title = "Create account";
        include "views/auth/register.php";
    }

    public function logout()
    {
        $session = new Session();
        $session->unset("is-admin");
        $session->unset("usuario-logado");

        header("location:login");
    }
}

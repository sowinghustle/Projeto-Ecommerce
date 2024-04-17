<?php

require_once "BaseController.php";
require_once "models/Bookerr.php";

class AuthController extends BaseController
{
    public function login()
    {
        $this->view->usernameOrEmail = "";
        $this->view->password = "";
        $this->view->errorMsg = "";
        $this->view->successMsg = "";

        if ($this->requestIsPOST()) {
            try {
                $usernameOrEmail = trim($_POST["email"] ?? "");
                $password = $_POST["password"] ?? "";

                $this->view->usernameOrEmail = $usernameOrEmail;

                $user = new User($usernameOrEmail, $usernameOrEmail, $password);

                if (!$this->stringIsNotEmpty($usernameOrEmail))
                    throw Bookerr::ValidationError("Você precisa fornecer um nome de usuário ou e-mail!");

                if (!$this->stringIsNotEmpty($password))
                    throw Bookerr::ValidationError("Você precisa fornecer uma senha!");

                if (!$user->fillUserByUsernameOrEmailAndPassword())
                    throw Bookerr::ValidationError("Verifique se as credenciais estão corretas!");

                $this->session->set("usuario-logado", $user->getId());
                $this->session->set("success-msg", "Seja bem vindo, " . $user->getUsername() . "!");

                header("location:./books");
            } catch (Bookerr $error) {
                $this->view->errorMsg = $error->getMessage();
            }
        } else {
            if ($this->session->has("email")) {
                $this->view->usernameOrEmail = $this->session->get("email");
                $this->session->unset("email");
            }

            if ($this->session->has("password")) {
                $this->view->password = $this->session->get("password");
                $this->session->unset("password");
            }

            if ($this->session->has("error-msg")) {
                $this->view->errorMsg = $this->session->get("error-msg");
                $this->session->unset("error-msg");
            }

            if ($this->session->has("success-msg")) {
                $this->view->successMsg = $this->session->get("success-msg");
                $this->session->unset("success-msg");
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
            $user = null;

            try {
                $username = trim($_POST["username"] ?? "");
                $email = trim($_POST["email"] ?? "");
                $password = $_POST["password"] ?? "";

                $this->view->username = $username;
                $this->view->email = $email;

                if (!$this->stringIsNotEmpty($username))
                    throw Bookerr::ValidationError("Você precisa fornecer um nome de usuário!");

                if (!$this->stringIsNotEmpty($email))
                    throw Bookerr::ValidationError("Você precisa fornecer um e-mail!");

                if (!$this->stringIsNotEmpty($password))
                    throw Bookerr::ValidationError("Você precisa fornecer uma senha!");

                $user = new User($username, $email, $password);

                if (!$user->save())
                    throw Bookerr::BadRequest("Não foi possível salvar os dados de usuário! Tente novamente mais tarde.");

                $this->session->set("email", $email);
                $this->session->set("password", $password);
                $this->session->set("success-msg", "Usuário cadastrado com sucesso! Faça o login.");

                header("location:../login");
            } catch (Bookerr $error) {
                $this->view->errorMsg = $error->getMessage();
                $this->setErrorIfUserExists($user);
            }
        }

        $this->view->title = "Create account";
        include "views/auth/register.php";
    }

    public function logout()
    {
        $this->session->unset("usuario-logado");
        header("location:../");
    }

    private function setErrorIfUserExists($user)
    {
        try {
            if ($user && $user->fillUserByUsernameOrEmailAndPassword(true)) {
                $this->view->errorMsg = "Este usuário já existe!";
            }
        } catch (Exception $error) {
            echo "ErrOr: $error";
            $this->view->errorMsg = "Não foi possível verificar as informações para o cadastro. Tente novamente mais tarde.";
        }
    }
}

<?php

require_once "BaseController.php";
require_once "models/User.php";

class HomeController extends BaseController
{
    public function index()
    {
        $this->view->title = "Home";
        include "views/home/index.php";
    }

    public function profile()
    {
        $this->ensureIsLogged();

        $user = User::withId($this->getLoggedUserId());

        try {
            if (!$user->fillUserById()) {
                $this->session->set("error-msg", "Não foi possível carregar os dados do perfil.");
                header("location:..");
            }
        } catch (Bookerr $error) {
            $this->view->errorMsg = $error->getMessage();
        }

        $this->view->username = $user->getUsername();
        $this->view->email = $user->getEmail();
        $this->view->errorMsg = "";
        $this->view->successMsg = "";

        if ($this->requestIsPOST()) {
            if ($_GET["delete"]) {
                try {
                    $user->delete();
                    $this->session->unset("usuario-logado");
                    $this->session->set("success-msg", "Sua conta foi excluida com sucesso!");
                    header("location:..");
                } catch (Bookerr $error) {
                    $this->view->errorMsg = $error->getMessage();
                }
            } else {
                $username = trim($_POST["username"] ?? "");
                $password = $_POST["password"] ?? "";
                $updatePassword = $this->stringIsNotEmpty($password);

                try {
                    if (!$this->stringIsNotEmpty($username))
                        throw Bookerr::ValidationError("Você precisa fornecer um nome de usuário!");

                    $updateUser = $user;
                    $updateUser->setUsername($username);

                    if ($updatePassword)
                        $updateUser->changePassword($password);

                    if (!$updateUser->save())
                        throw Bookerr::BadRequest("Não foi possível salvar os dados de usuário! Tente novamente mais tarde.");

                    $this->view->username = $updateUser->getUsername();
                    $this->view->email = $updateUser->getEmail();
                    $this->view->successMsg = "Os seus dados foram atualizados com sucesso!";
                } catch (Bookerr $error) {
                    $this->view->errorMsg = $error->getMessage();
                }
            }
        }

        $this->view->title = "Perfil";
        include "views/home/profile.php";
    }

    private function ensureIsLogged()
    {
        if (!$this->isUserLogged()) {
            $this->session->set("error-msg", "Você precisa fazer login primeiro!");
            header("location:../login");
            return;
        }
    }
}

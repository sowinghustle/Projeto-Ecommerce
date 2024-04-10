<?php

require_once "BaseController.php";

class BookController extends BaseController
{

    public function index()
    {
        $this->view->errorMsg = "";
        $this->view->successMsg = "";
        $this->view->title = "Books";
        include "views/book/list.php";
    }

    public function create()
    {
        $this->view->errorMsg = "";
        $this->view->successMsg = "";
        $this->view->name = "";
        $this->view->author = "";
        $this->view->description = "";
        $this->view->category = "";
        $this->view->value = "";
        $this->ensureIsLogged();

        if ($this->requestIsPOST()) {
            try {
                $name = trim($_POST["name"] ?? "");
                $author = trim($_POST["author"] ?? "");
                $description = $_POST["description"] ?? "";
                $category = $_POST["category"] ?? "";
                $value = $_POST["value"] ?? "";

                $this->view->name = $name;
                $this->view->author = $author;
                $this->view->description = $description;
                $this->view->category = $category;
                $this->view->value = $value;

                $session = new Session();
                $userId = $session->get("usuario-logado");
                $book = new Book($name, $author, $description, $category, $value, $userId);

                if (!$this->stringIsNotEmpty($name))
                    throw Bookerr::ValidationError("Você precisa fornecer um nome de usuário!");

                if (!$this->stringIsNotEmpty($author))
                    throw Bookerr::ValidationError("Você precisa fornecer um e-mail!");

                if (!$this->stringIsNotEmpty($description))
                    throw Bookerr::ValidationError("Você precisa fornecer uma senha!");

                if (!$book->save()) {
                    throw Bookerr::BadRequest("Não foi possível registrar o livro e suas informações! Tente novamente mais tarde.");
                }

                $session = new Session();
                $session->set("success_msg", "Livro cadastrado com sucesso!");

                header("location:./book");
            } catch (Bookerr $error) {
                $this->view->errorMsg = $error->getMessage();

                if ($user && $user->fillUserBynameOrauthorAnddescription(true)) {
                    $this->view->errorMsg = "Este usuário já existe!";
                }
            }
        } else {
        }

        $this->view->title = "Create Book";
        include "views/book/create.php";
    }

    public function update()
    {
        $this->view->errorMsg = "";
        $this->view->successMsg = "";
        $this->ensureIsLogged();

        if ($this->requestIsPOST()) {
        } else {
        }

        $this->view->title = "Update Book";
        include "views/book/update.php";
    }

    public function delete()
    {
        $this->view->errorMsg = "";
        $this->view->successMsg = "";
        $this->ensureIsLogged();

        if (!$this->requestIsPOST()) {
            header("location:../books");
            return;
        }
    }

    private function ensureIsLogged()
    {
        if (!$this->isUserLogged()) {
            header("location:../books");
            return;
        }
    }

    private function ensureIsAdmin()
    {
        if (!$this->isAdmin()) {
            header("location:../books");
            return;
        }
    }
}

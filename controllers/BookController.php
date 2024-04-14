<?php

require_once "BaseController.php";
require_once "models/Database.php";
require_once "models/Book.php";

class BookController extends BaseController
{

    public function index()
    {
        $this->view->errorMsg = "";
        $this->view->successMsg = "";

        if ($this->session->has("error_msg")) {
            $this->view->errorMsg = $this->session->get("error_msg");
            $this->session->unset("error_msg");
        }

        if ($this->session->has("success_msg")) {
            $this->view->successMsg = $this->session->get("success_msg");
            $this->session->unset("success_msg");
        }

        $this->view->title = "Books";
        include "views/book/list.php";
    }

    public function view()
    {
        $this->view->author = "";
        $this->view->description = "";
        $this->view->categories = "";
        $this->view->price = "";

        $id = $_GET["id"];

        if (isset($id) && !empty($id)) {
            $book = Book::withId($id);

            try {
                if (!$book->fillById()) {
                    $error404title = "Livro não encontrado.";
                    $error404description = "O livro com código $id não foi encontrado.";
                    include '404.php';
                } else {
                    $this->view->author = $book->getAuthor();
                    $this->view->description = $book->getDescription();
                    $this->view->categories = $book->getRawCategories();
                    $this->view->price = $book->getPrice();
                    $this->view->bookTitle = $book->getTitle();
                    $this->view->title = "Book";
                    include "views/book/view.php";
                }
            } catch (Bookerr $error) {
                $this->session->set("error_msg", "Não foi possível obter o livro requisitado.");
                header("location:../books");
            }

            return;
        }

        $error404title = "Livro não encontrado.";
        $error404description = "O código do livro não foi fornecido nesta requisição.";

        include '404.php';
    }

    public function create()
    {
        $this->view->errorMsg = "";
        $this->view->successMsg = "";
        $this->view->bookTitle = "";
        $this->view->author = "";
        $this->view->description = "";
        $this->view->categories = "";
        $this->view->price = "";
        $this->ensureIsLogged();

        if ($this->requestIsPOST()) {
            $book = null;

            try {
                $bookTitle = trim($_POST["title"] ?? "");
                $author = trim($_POST["author"] ?? "");
                $description = $_POST["description"] ?? "";
                $categories = $_POST["categories"] ?? "";
                $price = $_POST["price"] ?? "";

                $this->view->bookTitle = $bookTitle;
                $this->view->author = $author;
                $this->view->description = $description;
                $this->view->categories = $categories;
                $this->view->price = $price;

                if (!$this->stringIsNotEmpty($bookTitle))
                    throw Bookerr::ValidationError("Você precisa fornecer um título ao livro!");

                if (!$this->stringIsNotEmpty($author))
                    throw Bookerr::ValidationError("Você precisa fornecer um nome do autor!");

                if (!$this->stringIsNotEmpty($description))
                    throw Bookerr::ValidationError("Você precisa fornecer uma descrição!");

                if (!$this->stringIsNotEmpty($categories))
                    throw Bookerr::ValidationError("Você precisa fornecer uma categoria!");

                if ($price == null || $price <= 0)
                    throw Bookerr::ValidationError("Você precisa fornecer um valor válido!");

                $userId = $this->session->get("usuario-logado");
                $book = new Book($bookTitle, $author, $description, $categories, $price, $userId);

                if (!$book->save()) {
                    throw Bookerr::BadRequest("Não foi possível registrar o livro e suas informações! Tente novamente mais tarde.");
                }

                $this->session->set("success_msg", "Livro cadastrado com sucesso!");

                header("location:../book?id=" . $book->getId());
            } catch (Bookerr $error) {
                $this->view->errorMsg = $error->getMessage();
            }
        } else {
        }

        $this->view->title = "Create Book";
        include "views/book/create_update.php";
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
        include "views/book/create_update.php";
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
}

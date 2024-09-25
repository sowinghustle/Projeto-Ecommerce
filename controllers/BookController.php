<?php

require_once "BaseController.php";
require_once "models/Database.php";
require_once "models/BookFactory.php";
require_once "models/BookList.php";
require_once "models/BookFactory.php";

class BookController extends BaseController
{
    public function index()
    {
        $this->view->search = $_GET["search"] ?? "";
        $this->view->errorMsg = "";
        $this->view->successMsg = "";
        $this->view->bookList = new BookList($this->view->search);

        if ($this->session->has("error-msg")) {
            $this->view->errorMsg = $this->session->get("error-msg");
            $this->session->unset("error-msg");
        }

        if ($this->session->has("success-msg")) {
            $this->view->successMsg = $this->session->get("success-msg");
            $this->session->unset("success-msg");
        }

        try {
            $this->view->bookList->fillBySearchResults();
        } catch (Bookerr $error) {
            $this->view->errorMsg = "Ocorreu um erro ao tentar retornar os livros.";
        }
        
        $this->view->title = "Livros";
        include "views/book/list.php";
    }

    public function view()
    {
        $id = $_GET["id"];

        if (isset($id) && !empty($id)) {
            $this->view->errorMsg = "";
            $this->view->successMsg = "";
            $this->view->book = Book::withId($id);

            try {
                if (!$this->view->book->fillById()) {
                    $error404title = "Livro não encontrado.";
                    $error404description = "O livro com código $id não foi encontrado.";
                    include '404.php';
                } else {
                    if ($this->session->has("success-msg")) {
                        $this->view->successMsg = $this->session->get("success-msg");
                        $this->session->unset("success-msg");
                    }

                    if ($this->session->has("error-msg")) {
                        $this->view->errorMsg = $this->session->get("error-msg");
                        $this->session->unset("error-msg");
                    }

                    if ($this->view->book->getUserId() == $this->getLoggedUserId()) {
                        $this->view->title = "Atualizar Livro";
                        include "views/book/create_update.php";
                        return;
                    }

                    $this->view->title = "Comprar Livro";
                    include "views/book/view.php";
                }
            } catch (Bookerr $error) {
                $this->session->set("error-msg", "Não foi possível obter o livro requisitado.");
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
        $this->view->book = Book::withNothing();
        $this->ensureIsLogged();

        if ($this->requestIsPOST()) {
            try {
                $bookTitle = trim($_POST["title"] ?? "");
                $author = trim($_POST["author"] ?? "");
                $description = $_POST["description"] ?? "";
                $categories = $_POST["categories"] ?? "";
                $price = $_POST["price"] ?? "";
                $userId = $this->session->get("usuario-logado");

                $this->view->book = new Book($bookTitle, $author, $description, $categories, $price, $userId);
                $this->validateBook($this->view->book);

                if (!$this->view->book->save())
                    throw Bookerr::BadRequest("Não foi possível registrar o livro e suas informações! Tente novamente mais tarde.");

                $this->session->set("success-msg", "Livro cadastrado com sucesso!");

                header("location:../books/view?id=" . $this->view->book->getId());
            } catch (Bookerr $error) {
                $this->view->errorMsg = $error->getMessage();
            }
        } else {
        }

        $this->view->title = "Registrar Livro";
        include "views/book/create_update.php";
    }

    public function update()
    {
        $this->ensureIsLogged();

        $id = $_GET["id"];

        if (isset($id) && !empty($id)) {
            $this->view->errorMsg = "";
            $this->view->successMsg = "";
            $this->view->book = Book::withId($id);

            try {
                if (!$this->view->book->fillById()) {
                    $error404title = "Livro não encontrado.";
                    $error404description = "O livro com código $id não foi encontrado.";
                    include '404.php';
                } else {
                    if ($this->view->book->getUserId() != $this->getLoggedUserId()) {
                        $this->session->set("error-msg", "Você não tem permissão para editar este livro.");
                        header("location:../books/view?id=$id");
                        return;
                    }

                    if ($this->session->has("success-msg")) {
                        $this->view->successMsg = $this->session->get("success-msg");
                        $this->session->unset("success-msg");
                    }

                    if ($this->session->has("error-msg")) {
                        $this->view->errorMsg = $this->session->get("error-msg");
                        $this->session->unset("error-msg");
                    }

                    if ($this->requestIsPOST()) {
                        try {
                            $bookTitle = trim($_POST["title"] ?? "");
                            $author = trim($_POST["author"] ?? "");
                            $description = $_POST["description"] ?? "";
                            $categories = $_POST["categories"] ?? "";
                            $price = $_POST["price"] ?? "";
                            $userId = $this->session->get("usuario-logado");

                            $this->view->book = new Book($bookTitle, $author, $description, $categories, $price, $userId, $id);
                            $this->validateBook($this->view->book);

                            if (!$this->view->book->save())
                                throw Bookerr::BadRequest("Não foi possível registrar o livro e suas informações! Tente novamente mais tarde.");

                            $this->session->set("success-msg", "Livro atualizado com sucesso!");

                            header("location:../books/view?id=" . $this->view->book->getId());
                        } catch (Bookerr $error) {
                            $this->view->errorMsg = $error->getMessage();
                        }
                    }

                    $this->view->title = "Atualizar Livro";
                    include "views/book/create_update.php";
                }
            } catch (Bookerr $error) {
                $this->session->set("error-msg", "Não foi possível obter o livro requisitado.");
                header("location:../books");
            }

            return;
        }

        $error404title = "Livro não encontrado.";
        $error404description = "O código do livro não foi fornecido nesta requisição.";

        include '404.php';
    }

    public function delete()
    {
        if (!$this->requestIsPOST()) {
            header("location:../books");
        }

        $this->ensureIsLogged();

        $id = $_GET["id"];

        if (isset($id) && !empty($id)) {
            $book = Book::withId($id);

            if (!$book->fillById()) {
                $this->session->set("error-msg", "O livro com código $id não foi encontrado.");
                header("location:../books");
                return;
            }

            if ($book->getUserId() != $this->getLoggedUserId()) {
                $this->session->set("error-msg", "Você não tem permissão para excluir este livro.");
                header("location:../books/view?id=$id");
                return;
            }

            if (!$book->delete()) {
                $this->session->set("error-msg", "Não foi possível excluir este livro.");
                header("location:../books/view?id=$id");
                return;
            }

            $this->session->set("success-msg", "Livro " . $book->getTitle() . "#" . $book->getId() . " excluído com sucesso.");
        }

        header("location:../books");
        return;
    }

    private function validateBook(Book $book)
    {
        if (!$this->stringIsNotEmpty($book->getTitle()))
            throw Bookerr::ValidationError("Você precisa fornecer um título ao livro!");

        if (!$this->stringIsNotEmpty($book->getAuthor()))
            throw Bookerr::ValidationError("Você precisa fornecer um nome do autor!");

        if (!$this->stringIsNotEmpty($book->getDescription()))
            throw Bookerr::ValidationError("Você precisa fornecer uma descrição!");

        if (count($book->getCategories()) == 0)
            throw Bookerr::ValidationError("Você precisa fornecer uma categoria!");

        if ($book->getPrice() == null || $book->getPrice() <= 0)
            throw Bookerr::ValidationError("Você precisa fornecer um valor válido!");
    }

    public function addToCart()
    {
        $this->ensureIsLogged();


        $userId = $this->getLoggedUserId();
        $saleId = $_POST['sale_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if (!$saleId) {
            $this->session->set("error-msg", "O ID da venda não foi fornecido.");
            header("location:../books");
            return;
        }

        try {
            $book = Book::withId($saleId);
            $book->addToCart($userId, $saleId, $quantity);
            $this->session->set("success-msg", "Livro adicionado ao carrinho com sucesso!");
        } catch (Exception $e) {
            $this->session->set("error-msg", "Não foi possível adicionar o livro ao carrinho. Tente novamente mais tarde.");
        }

        header("location:../books/view?id=$saleId");
    }

    public function createSale()
    {
        $this->ensureIsLogged();

        $bookId = $_POST['book_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;
        $price = $_POST['price'] ?? null;
        $available = $_POST['available'] ?? true;

        if (!$bookId || !$price) {
            $this->session->set("error-msg", "Dados insuficientes para criar uma venda.");
            header("location:../books");
            return;
        }

        try {
            $userId = $this->getLoggedUserId();
            $book = Book::withId($bookId);
            $saleId = $book->createSale($userId, $bookId, $quantity, $price, $available);

            if ($saleId) {
                $this->session->set("success-msg", "Venda criada com sucesso!");
                header("location:../books/view?id=$bookId");
            } else {
                throw new Exception("Falha ao criar a venda.");
            }
        } catch (Exception $e) {
            $this->session->set("error-msg", "Não foi possível criar a venda. Tente novamente mais tarde.");
            header("location:../books");
        }
    }

    private function ensureIsLogged()
    {
        if (!$this->isUserLogged()) {
            header("location:../login");
            return;
        }
    }
}

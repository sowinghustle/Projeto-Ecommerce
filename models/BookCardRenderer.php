<?php

require_once "Book.php";

interface CardBuilder
{
    public function setBook(Book $book): void;
    public function render(): string;
}

class BookOwnerCardBuilder implements CardBuilder
{
    private Book $book;
    private string $mode;
    public function setIsView()
    {
        $this->mode = "view";
    }
    public function setIsUpdate()
    {
        $this->mode = "update";
    }
    public function setIsCreate()
    {
        $this->mode = "create";
    }
    public function setBook(Book $book): void
    {
        $this->book = $book;
    }
    public function render(): string
    {
        return "
            <form method='post' class='card mb-4' style='width:420px;'>
                <img src='" . $this->book->getImageSource() . "' class='card-img-top' style='height:200px;'>

                <div class='card-body'>
                    <div class='mb-3'>
                        <label for='id' class='form-label'>Código do Livro</label>
                        <input name='id' type='text' class='form-control' value='" . $this->book->getId() . "' readonly />
                    </div>

                    <div class='mb-3'>
                        <label for='title' class='form-label'>Nome do Livro</label>
                        <input name='title' type='text' class='form-control' value='" . $this->book->getTitle() . "' readonly />
                    </div>

                    <div class='mb-3'>
                        <label for='author' class='form-label'>Autor do livro</label>
                        <input name='author' type='text' class='form-control' value='" . $this->book->getAuthor() . "' readonly />
                    </div>

                    <div class='mb-3'>
                        <label for='description' class='form-label'>Descrição do livro</label>
                        <input name='description' type='text' class='form-control' value='" . $this->book->getDescription() . "' readonly />
                    </div>

                    <div class='mb-3'>
                        <label for='categories' class='form-label'>Categorias do livro</label>
                        <input name='categories' type='text' class='form-control' value='" . $this->book->getRawCategories() . "' readonly />
                    </div>

                    <div class='mb-3'>
                        <label for='price' class='form-label'>Valor do livro</label>
                        <input name='price' type='number' step='0.01' min='0.01' class='form-control' value='" . $this->book->getPrice() . "' readonly />
                    </div>

                    <div class='mb-3'>
                        <label class='form-label'>Vendedor</label>
                        <input class='form-control' type='text' value='" . $this->book->fetchOwnerUsername() . "' readonly />
                    </div>

                    <div class='mt-3'>
                    " . ($this->mode == "view" ? "
                        <input type='button' class='btn btn-primary' value='Atualizar' onclick=\"window.location.href = '../books/view?id=" . $this->book->getId() . "'\" />" : "") . "

                    " . ($this->mode == "update" ? "
                        <button type='submit' class='btn btn-primary' formaction='./edit?id=" . $this->book->getId() . "'>
                            Atualizar
                        </button>" : "") . "

                    " . ($this->mode == "create" ? "
                        <button type='submit' class='btn btn-primary' formaction='./new?id=0'>
                            Cadastrar
                        </button>" : " 
                        <button type='submit' class='btn btn-danger' formaction='../books/delete?id=" . $this->book->getId() . "' formnovalidate=''>Excluir</button>
                        ") . "
                    </div>
                </div>
            </form>";
    }
}

class BookNotOwnerCardBuilder implements CardBuilder
{
    private Book $book;
    public function setBook(Book $book): void
    {
        $this->book = $book;
    }
    public function render(): string
    {
        return "
        <form method='post' class='card mb-4' style='width:420px;'>
            <img src='" . $this->book->getImageSource() . "' class='card-img-top' style='height:200px;'>

            <div class='card-body'>
                <div class='mb-3'>
                    <label for='title' class='form-label'>Nome do Livro</label>
                    <input name='title' type='text' class='form-control' value='" . $this->book->getTitle() . "' readonly />
                </div>

                <div class='mb-3'>
                    <label for='author' class='form-label'>Autor do livro</label>
                    <input name='author' type='text' class='form-control' value='" . $this->book->getAuthor() . "' readonly />
                </div>

                <div class='mb-3'>
                    <label for='description' class='form-label'>Descrição do livro</label>
                    <input name='description' type='text' class='form-control' value='" . $this->book->getDescription() . "' readonly />
                </div>

                <div class='mb-3'>
                    <label for='categories' class='form-label'>Categorias do livro</label>
                    <input name='categories' type='text' class='form-control' value='" . $this->book->getRawCategories() . "' readonly />
                </div>

                <div class='mb-3'>
                    <label for='price' class='form-label'>Valor do livro</label>
                    <input name='price' type='number' step='0.01' min='0.01' class='form-control' value='" . $this->book->getPrice() . "' readonly />
                </div>

                <div class='mb-3'>
                    <label class='form-label'>Vendedor</label>
                    <input class='form-control' type='text' value='" . $this->book->fetchOwnerUsername() . "' readonly />
                </div>

                <div class='mt-3'>
                    <button type='button' class='btn btn-success'>
                        Comprar
                    </button>
                </div>
            </div>
        </form>";
    }
}

class FactoryBookBuilder
{
    public static function create(Book $book, int $userId, string $mode = null): CardBuilder
    {
        $bookBuilder = new BookNotOwnerCardBuilder();

        if ($userId == $book->getUserId()) {
            $bookBuilder = new BookOwnerCardBuilder();

            switch ($mode) {
                case "view":
                    $bookBuilder->setIsView();
                    break;

                case "update":
                    $bookBuilder->setIsUpdate();
                    break;

                case "create":
                    $bookBuilder->setIsCreate();
                    break;

                default:
                    break;
            }
        }

        $bookBuilder->setBook($book);

        return $bookBuilder;
    }
}

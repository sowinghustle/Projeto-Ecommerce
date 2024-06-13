<?php

require_once "Book.php";

interface CardBuilder
{
    public function setBook(Book $book): void;
    public function render(): string;
}

function _replaceTemplateKeys($template, $replacements)
{
    foreach ($replacements as $key => $value) {
        $template = str_replace("{{$key}}", $value, $template);
    }
    return $template;
}

class BookOwnerCardBuilder implements CardBuilder
{
    private Book $book;
    private string $mode;
    private bool $isReadonly;

    public function __construct()
    {
        $this->setIsView();
        $this->setIsReadonly(false);
    }

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

    public function setIsReadonly(bool $value)
    {
        $this->isReadonly = $value;
    }

    public function render(): string
    {
        $template = "
            <form method='post' class='card mb-4' style='width:420px;'>
                <img src='{imageSource}' class='card-img-top' style='height:200px;'>

                <div class='card-body'>
                    {bookIdField}

                    <div class='mb-3'>
                        <label for='title' class='form-label'>Nome do Livro</label>
                        <input name='title' type='text' class='form-control' value='{bookTitle}' {readonly} />
                    </div>

                    <div class='mb-3'>
                        <label for='author' class='form-label'>Autor do livro</label>
                        <input name='author' type='text' class='form-control' value='{bookAuthor}' {readonly} />
                    </div>

                    <div class='mb-3'>
                        <label for='description' class='form-label'>Descrição do livro</label>
                        <textarea name='description' class='form-control' {readonly}>{bookDescription}</textarea>
                    </div>

                    <div class='mb-3'>
                        <label for='categories' class='form-label'>Categorias do livro</label>
                        <input name='categories' type='text' class='form-control' value='{bookCategories}' {readonly} />
                    </div>

                    <div class='mb-3'>
                        <label for='price' class='form-label'>Valor do livro (R$)</label>
                        <input name='price' type='number' step='0.01' min='0.01' class='form-control' value='{bookPrice}' {readonly} />
                    </div>

                    <div class='mt-3' style='display:flex;gap:2px;'>
                        {viewButton}
                        {createButton}
                        {updateButton}
                        {deleteButton}
                    </div>
                </div>
            </form>";

        $book = $this->book;
        $bookId = $this->book->getId();

        return _replaceTemplateKeys($template, [
            "readonly" => $this->isReadonly ? ($this->mode == "view" ? "disabled" : "readonly") : "",
            "imageSource" => $book->getImageSource(),
            "bookIdField" => $this->mode ?
                "<input name='id' type='hidden' value='$bookId' />" :
                "<div class='mb-3'>
                    <label for='id' class='form-label'>Código do Livro</label>
                    <input name='id' type='text' class='form-control' value='$bookId' readonly />
                </div>",
            "bookTitle" => $book->getTitle(),
            "bookAuthor" => $book->getAuthor(),
            "bookDescription" => $book->getDescription(),
            "bookCategories" => $book->getRawCategories(),
            "bookPrice" => $book->getPrice(),
            "viewButton" => $this->getViewButton(),
            "createButton" => $this->getCreateButton(),
            "updateButton" => $this->getUpdateButton(),
            "deleteButton" => $this->getDeleteButton()
        ]);
    }

    private function getViewButton()
    {
        if ($this->mode == "view") {
            $bookId = $this->book->getId();
            return "<input type='button' class='btn btn-primary' value='Editar' onclick='window.location.href=\"../books/view?id=$bookId\"' />";
        }

        return "";
    }

    private function getCreateButton()
    {
        if ($this->mode == "create" && !$this->isReadonly) {
            return "<button type='submit' class='btn btn-primary' formaction='./new?id=0'>Cadastrar</button>";
        }

        return "";
    }

    private function getUpdateButton()
    {
        if ($this->mode == "update" && !$this->isReadonly) {
            $bookId = $this->book->getId();
            return "<button type='submit' class='btn btn-primary' formaction='./edit?id=$bookId'>Atualizar</button>";
        }

        return "";
    }

    private function getDeleteButton()
    {
        if ($this->mode == "create" || $this->isReadonly)
            return "";

        $bookId = $this->book->getId();
        return "<button type='submit' class='btn btn-danger' formaction='../books/delete?id=$bookId' formnovalidate=''>Excluir</button>";
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
        $template = "
            <form method='post' class='card mb-4' style='width:420px;'>
                <img src='{imageSource}' class='card-img-top' style='height:200px;'>

                <div class='card-body'>
                    <input name='id' type='hidden' value='{bookId}' />

                    <div class='mb-3'>
                        <label for='title' class='form-label'>Nome do Livro</label>
                        <input name='title' type='text' class='form-control' value='{bookTitle}' disabled />
                    </div>

                    <div class='mb-3'>
                        <label for='author' class='form-label'>Autor do livro</label>
                        <input name='author' type='text' class='form-control' value='{bookAuthor}' disabled />
                    </div>

                    <div class='mb-3'>
                        <label for='description' class='form-label'>Descrição do livro</label>
                        <textarea name='description' class='form-control' disabled>{bookDescription}</textarea>
                    </div>

                    <div class='mb-3'>
                        <label for='categories' class='form-label'>Categorias do livro</label>
                        <input name='categories' type='text' class='form-control' value='{bookCategories}' disabled />
                    </div>

                    <div class='mb-3'>
                        <label for='price' class='form-label'>Valor do livro (R$)</label>
                        <input name='price' type='number' step='0.01' min='0.01' class='form-control' value='{bookPrice}' disabled />
                    </div>

                    <div class='mb-3'>
                        <label class='form-label'>Vendedor</label>
                        <input class='form-control' type='text' value='{bookSeller}' disabled />
                    </div>

                    <div class='mt-3' style='display:flex;gap:2px;'>
                        <button type='button' class='btn btn-success'>
                            Comprar
                        </button>
                    </div>
                </div>
            </form>";

        $book = $this->book;

        return _replaceTemplateKeys($template, [
            "bookId" => $book->getId(),
            "imageSource" => $book->getImageSource(),
            "bookTitle" => $book->getTitle(),
            "bookAuthor" => $book->getAuthor(),
            "bookDescription" => $book->getDescription(),
            "bookCategories" => $book->getRawCategories(),
            "bookPrice" => $book->getPrice(),
            "bookSeller" => $book->fetchOwnerUsername()
        ]);
    }
}

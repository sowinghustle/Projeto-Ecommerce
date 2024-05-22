<?php

require_once "models/FactoryBook.php";
require_once "models/BookPublicado.php";
require_once "models/BookNaoPublicado.php";

class FactoryBook
{
    public static function create($bookTitle, $author, $description, $categories, $price, $publicado, $userId)
    {
        if ($publicado == true) {
            return new BookPublicado($bookTitle, $author, $description, $categories, $price, $userId);
        }

        return new BookNaoPublicado($bookTitle, $author, $description, $categories, $price, $userId);
    }

    public static function createById($id)
    {
        $bookData = AbstractBook::getById($id);

        if ($bookData['publicado'] == true) {
            return new BookPublicado($bookData['title'], $bookData['author'], $bookData['description'], $bookData['categories'], $bookData['price'], $bookData['userId'], $bookData['id']);
        }

        return new BookNaoPublicado($bookData['title'], $bookData['author'], $bookData['description'], $bookData['categories'], $bookData['price'], $bookData['userId'], $bookData['id']);
    }
}

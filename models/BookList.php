<?php

require_once "models/Bookerr.php";
require_once "models/Book.php";

class BookList
{
    private $books;
    private $search;

    public function __construct($search)
    {
        $this->books = array();
        $this->search = $search;
    }

    public function fillByUser($userId)
    {
        try {
            $db = new Database();
            $stmt = $db->pdo->prepare("SELECT b.id, b.title, b.author, b.description, b.categories, b.price, b.user as userId FROM books b WHERE b.user=:userId");
            $stmt->bindValue(":userId", $userId, PDO::PARAM_INT);
            $stmt->execute();

            $books = $stmt->fetchAll(PDO::FETCH_CLASS, "Book");

            $this->books = $books;
            return true;
        } catch (Exception $e) {
            $this->throw_exception();
        }

        return false;
    }

    public function fillBySearchResults(): bool
    {
        $search = $this->search;

        try {
            $db = new Database();
            $stmt = $db->pdo->prepare("SELECT b.id, b.title, b.author, b.description, b.categories, b.price, b.user as userId FROM books b WHERE IF (empty(:search), true, CONCAT(\"%\", b.title, \"%\", b.author, \"%\", b.description, \"%\") like :search)");
            $stmt->bindValue(":search", $search, PDO::PARAM_STR);
            $stmt->execute();

            $books = $stmt->fetchAll(PDO::FETCH_CLASS, "Book");

            $this->books = $books;
            return true;
        } catch (Exception $e) {
            $this->throw_exception();
        }

        return false;
    }

    public function addBook($book)
    {
        array_push($this->books, $book);
    }

    public function getBooks()
    {
        return $this->books;
    }

    public function setSearch($newSearch)
    {
        $this->search = $newSearch;
    }

    public function getSearch()
    {
        return $this->search;
    }

    private function throw_exception()
    {
        throw Bookerr::Exception("Sorry, something went wrong, and was not possible to proccess your request!");
    }
}

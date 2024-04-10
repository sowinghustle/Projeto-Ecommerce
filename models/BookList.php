<?php

require_once "models/Bookerr.php";
require_once "models/Book.php";

class BookList
{
    private $books;

    public function __construct()
    {
        $this->books = array();
    }

    public function fillBySearchResults($search)
    {
        try {
            $db = new Database();
            $stmt = $db->pdo->prepare("");
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

    private function throw_exception()
    {
        throw Bookerr::Exception("Sorry, something went wrong, and was not possible to proccess your request!");
    }
}

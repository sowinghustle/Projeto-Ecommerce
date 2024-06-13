<?php

require_once "models/Bookerr.php";
require_once "models/BookFactory.php";

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
            $db = Database::getDatabase();
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

    public function fillBySearchResults()
    {
        $search = $this->search;

        try {
            $db = Database::getDatabase();
            $stmt = $db->pdo->prepare('CALL stp_search_books(:search)');
            $stmt->bindValue(":search", $search, PDO::PARAM_STR);
            $stmt->execute();
            $rawBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->books = [];

            foreach ($rawBooks as $rawBook) {
                $book = new Book($rawBook["title"], $rawBook["author"], $rawBook["description"], $rawBook["categories"], $rawBook["price"], $rawBook["userId"], $rawBook["id"]);
                $this->addBook($book);
            }
        } catch (Exception $e) {
            $this->throw_exception();
        }
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
        throw Bookerr::Exception("Desculpe, ocorreu um erro e não foi possível completar a requisição!");
    }
}

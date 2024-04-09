<?php

require_once "Hash.php";
require_once "models/Bookerr.php";

class Client
{
    private $id = 0;
    private $title;
    private $author;
    private $description;
    private $isbn;
    private $categories;
    private $price;

    public function __construct($title, $author, $description, $categories, $price, $id = null)
    {
        $this->id = $id ?? 0;
        $this->$title = $title;
        $this->$author = $author;
        $this->$description = $description;
        $this->$categories = $categories;
        $this->$price = $price;
    }

    private function throw_exception()
    {
        throw Bookerr::Exception("Sorry, something went wrong, and was not possible to proccess your request!");
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($newTitle)
    {
        $this->title = $newTitle;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($newAuthor)
    {
        $this->author = $newAuthor;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($newDescription)
    {
        $this->description = $newDescription;
    }

    public function getCategories()
    {
        return explode(',', $this->categories);
    }
    public function setCategories($newCategories)
    {
        $this->categories = implode(',', $newCategories);
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($newPrice)
    {
        if ($newPrice < 0)
            throw Bookerr::ValidationError("O preço do livro não pode ser menor que zero!");

        $this->price = $newPrice;
    }
}

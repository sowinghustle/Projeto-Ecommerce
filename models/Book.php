<?php

require_once "models/Bookerr.php";

class Book
{
    private $id = 0;
    private $title;
    private $author;
    private $description;
    private $categories;
    private $price;
    private $userId;

    public function __construct($title, $author, $description, $categories, $price, $userId, $id = null)
    {
        $this->id = $id ?? 0;
        $this->title = $title;
        $this->author = $author;
        $this->description = $description;
        $this->categories = $categories;
        $this->price = $price;
        $this->userId = $userId;
    }

    public static function withId($id): Book
    {
        return new Book("", "", "", "", 0.00, $id);
    }

    public function fillById(): bool
    {
        $id = $this->id;

        try {
            $db = new Database();
            $stmt = $db->pdo->prepare("SELECT b.id, b.title, b.author, b.description, b.categories, b.price, b.user FROM books b WHERE b.id=:id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $this->id = $result["id"];
                $this->title = $result["title"];
                $this->author = $result["author"];
                $this->description = $result["description"];
                $this->price = $result["price"];
                $this->userId = $result["user"];
                $this->setCategories($result["categories"]);

                return true;
            }
        } catch (Exception $e) {
            $this->throw_exception();
        }

        return false;
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

    public function getUserId()
    {
        return $this->userId;
    }

    private function throw_exception()
    {
        throw Bookerr::Exception("Sorry, something went wrong, and was not possible to proccess your request!");
    }
}

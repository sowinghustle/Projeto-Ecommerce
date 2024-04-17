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
        $this->setCategories($categories ?? array());
        $this->setPrice($price ?? 0.00);
        $this->userId = $userId ?? 0;
    }


    public static function withId($id): Book
    {
        $book = self::withNothing();
        $book->id = $id;
        return $book;
    }

    public static function withNothing(): Book
    {
        return new Book("", "", "", "", 0.00, 0);
    }

    public function save()
    {
        try {
            $db = new Database();
            $stmt = null;

            if (!$this->hasId()) {
                $stmt = $db->pdo->prepare('CALL stp_create_book(:title, :author, :description, :categories, :price, :user)');
                $stmt->bindValue(":user", $this->userId, PDO::PARAM_INT);
            } else {
                $stmt = $db->pdo->prepare('CALL stp_update_book(:id, :title, :description, :categories, :price)');
                $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
            }

            $stmt->bindValue(":title", $this->title, PDO::PARAM_STR);
            $stmt->bindValue(":author", $this->author, PDO::PARAM_STR);
            $stmt->bindValue(":description", $this->description, PDO::PARAM_STR);
            $stmt->bindValue(":categories", $this->getRawCategories(), PDO::PARAM_STR);
            $stmt->bindValue(":price", $this->price, PDO::PARAM_STR);

            $stmt->execute();

            if ($this->id == 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->id = (int) $result["id"];
            }

            if ($this->id != 0) {
                return true;
            }
        } catch (Exception $e) {
            $this->throw_exception();
        }

        return false;
    }

    public function delete(): bool
    {
        $id = $this->id;

        try {
            $db = new Database();
            $stmt = $db->pdo->prepare("DELETE FROM books WHERE id=:id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (Exception $e) {
            $this->throw_exception();
        }

        return false;
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
                $this->id = (int) $result["id"];
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

    public function hasId()
    {
        return $this->id != 0;
    }

    public function getId()
    {
        return $this->id;
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
        return $this->categories;
    }

    public function getRawCategories()
    {
        return implode(',', $this->categories);
    }

    public function setCategories($newCategories)
    {
        if (is_array($newCategories)) {
            $this->categories = $newCategories;
        } else {
            $this->categories = explode(',', $newCategories);
        }
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
        throw Bookerr::Exception("Desculpe, ocorreu um erro e não foi possível completar a requisição!");
    }
}

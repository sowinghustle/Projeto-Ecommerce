<?php

require_once "models/Bookerr.php";
require_once "models/User.php";

interface Book
{
    public function save(): bool;
    public function delete(): bool;
    public function fillById(): bool;
    public function fetchOwnerUsername(): string;
    public function hasId(): bool;
    public function getId(): int;
    public function getTitle(): string;
    public function setTitle($newTitle): void;
    public function getAuthor(): string;
    public function setAuthor($newAuthor): void;
    public function getDescription(): string;
    public function setDescription($newDescription): void;
    public function getCategories(): array;
    public function getRawCategories(): string;
    public function getImageSource(): string;
    public function setCategories($newCategories): void;
    public function getPrice(): float;
    public function setPrice($newPrice): void;
    public function getPublicado(): bool;
    public function renderizarCard(): string;
    public function getUserId(): int;
}

abstract class AbstractBook implements Book
{
    protected $id = 0;
    protected $title;
    protected $author;
    protected $description;
    protected $categories;
    protected $price;
    protected $userId;

    public function __construct($title, $author, $description, $categories, $price,$ userId, $id = null)
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
        return new Book("", "", "", "", false, 0.00, 0);
    }

    public function save(): bool
    {
        try {
            $db = Database::getDatabase();
            $stmt = null;

            if (!$this->hasId()) {
                $stmt = $db->pdo->prepare('CALL stp_create_book(:title, :author, :description, :categories, :price, :user)');
                $stmt->bindValue(":user", $this->userId, PDO::PARAM_INT);
            } else {
                $stmt = $db->pdo->prepare('CALL stp_update_book(:id, :title, :author, :description, :categories, :price)');
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
            self::throw_exception();
        }

        return false;
    }

    public function delete(): bool
    {
        $id = $this->id;

        try {
            $db = Database::getDatabase();
            $stmt = $db->pdo->prepare("DELETE FROM books WHERE id=:id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (Exception $e) {
            self::throw_exception();
        }

        return false;
    }

    public static function getById($id): bool
    {
        try {
            $db = Database::getDatabase();
            $stmt = $db->pdo->prepare("SELECT b.id, b.title, b.author, b.description, b.categories, b.price, b.user FROM books b WHERE b.id=:id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (Exception $e) {
            self::throw_exception();
        }

        return false;
    }

    public function fillById(): bool
    {
        $id = $this->id;

        try {
            $db = Database::getDatabase();
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
            self::throw_exception();
        }

        return false;
    }

    public function fetchOwnerUsername(): string
    {
        $id = $this->id;

        try {
            $db = Database::getDatabase();
            $stmt = $db->pdo->prepare("SELECT u.username FROM users u INNER JOIN books b ON b.user=u.id WHERE b.id=:id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result["username"];
            }
        } catch (Exception $e) {
        }

        return "*usuário não encontrado*";
    }

    public function hasId(): bool
    {
        return $this->id != 0;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle($newTitle): void
    {
        $this->title = $newTitle;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor($newAuthor): void
    {
        $this->author = $newAuthor;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription($newDescription): void
    {
        $this->description = $newDescription;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getRawCategories(): string
    {
        return implode(',', $this->categories);
    }

    public function getImageSource(): string
    {
        return "https://m.media-amazon.com/images/I/71kEvJKILlL._AC_UF1000,1000_QL80_.jpg";
    }

    public function setCategories($newCategories): void
    {
        if (is_array($newCategories)) {
            $this->categories = $newCategories;
        } else {
            $this->categories = explode(',', $newCategories);
        }
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice($newPrice): void
    {
        if ($newPrice < 0)
            throw Bookerr::ValidationError("O preço do livro não pode ser menor que zero!");

        $this->price = $newPrice;
    }

    public function getPublicado(): bool
    {
        throw new Exception("Não Implementado.");
    }

    public function renderizarCard(): string
    {
        throw new Exception("Não Implementado.");
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    private static function throw_exception(): void
    {
        throw Bookerr::Exception("Desculpe, ocorreu um erro e não foi possível completar a requisição!");
    }
}

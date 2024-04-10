<?php

require_once "Hash.php";
require_once "models/Bookerr.php";

class Client
{
    private $id = 0;
    private $username;
    private $email;
    private $password;
    private $isAdmin;

    public function __construct($username, $email, $password, $id = null)
    {
        $this->id = $id ?? 0;
        $this->username = $username;
        $this->email = $email;

        if ($password)
            $this->changePassword($password);
    }

    public static function withId($id): Client
    {
        return new Client("", "", "", $id);
    }

    public function fillUserById(): bool
    {
        $id = $this->id;

        try {
            $db = new Database();
            $stmt = $db->pdo->prepare("SELECT c.id, c.username, c.password, c.email, c.is_admin FROM clients c WHERE c.id=:id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $this->id = $result["id"];
                $this->username = $result["username"];
                $this->email = $result["email"];
                $this->password = $result["password"];
                $this->isAdmin = $result["is_admin"];

                return true;
            }
        } catch (Exception $e) {
            $this->throw_exception();
        }

        return false;
    }

    public function fillUserByUsernameOrEmailAndPassword($isPasswordOptional = false): bool
    {
        $username = $this->username;
        $email = $this->email;
        $password = $this->password;

        try {
            $db = new Database();

            $stmt = $db->pdo->prepare("SELECT c.id, c.username, c.password, c.email, c.is_admin FROM clients c WHERE (c.username=:username OR c.email=:email) AND c.password=IF(:is_password_optional, c.password, :password)");
            $stmt->bindValue(":username", $username, PDO::PARAM_STR);
            $stmt->bindValue(":email", $email, PDO::PARAM_STR);
            $stmt->bindValue(":password", $password, PDO::PARAM_STR);
            $stmt->bindValue(":is_password_optional", $isPasswordOptional, PDO::PARAM_BOOL);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $this->id = $result["id"];
                $this->username = $result["username"];
                $this->email = $result["email"];
                $this->password = $result["password"];
                $this->isAdmin = $result["is_admin"];

                return true;
            }
        } catch (Exception $e) {
            $this->throw_exception();
        }

        return false;
    }

    public function save()
    {
        try {
            $db = new Database();
            $stmt = null;

            if ($this->id == 0) {
                $stmt = $db->pdo->prepare('CALL stp_create_client(:username, :email, :password, :is_admin, @id)');
            } else {
                $stmt = $db->pdo->prepare('CALL stp_update_client(:id, :username, :email, :password)');
                $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
            }

            $stmt->bindValue(":username", $this->username, PDO::PARAM_STR);
            $stmt->bindValue(":email", $this->email, PDO::PARAM_STR);
            $stmt->bindValue(":password", $this->password, PDO::PARAM_STR);
            $stmt->bindValue(":is_admin", $this->isAdmin, PDO::PARAM_BOOL);
            $stmt->execute();

            $stmt = $db->pdo->prepare("SELECT @id AS id");
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $result["id"] || 0;

            if ($this->id != 0) {
                return true;
            }
        } catch (Exception $e) {
            $this->throw_exception();
        }

        return false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($newUsername)
    {
        $this->username = $newUsername;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($newEmail)
    {
        $this->email = $newEmail;
    }

    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    public function changePassword($newPassword)
    {
        // $this->password = Hash::make($newPassword);
        // TODO: add again later, but checking the hashing results and comparison
        $this->password = $newPassword;
    }

    private function throw_exception()
    {
        throw Bookerr::Exception("Sorry, something went wrong, and was not possible to proccess your request!");
    }
}

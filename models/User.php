<?php

require_once "Hash.php";
require_once "models/Bookerr.php";

class User
{
    private $id = 0;
    private $username;
    private $email;
    private $password;

    public function __construct($username, $email, $password, $id = null)
    {
        $this->id = $id ?? 0;
        $this->username = $username;
        $this->email = $email;

        if ($password)
            $this->changePassword($password);
    }

    public static function withId($id): User
    {
        return new User("", "", "", $id);
    }

    public function fillUserById(): bool
    {
        $id = $this->id;

        try {
            $db = Database::getDatabase();
            $stmt = $db->pdo->prepare("SELECT c.id, c.username, c.password, c.email FROM users c WHERE c.id=:id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $this->id = $result["id"];
                $this->username = $result["username"];
                $this->email = $result["email"];
                $this->password = $result["password"];

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
            $db = Database::getDatabase();

            $stmt = $db->pdo->prepare("SELECT c.id, c.username, c.password, c.email FROM users c WHERE (c.username=:username OR c.email=:email) AND c.password=IF(:is_password_optional, c.password, :password)");
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

                return true;
            }
        } catch (Exception $e) {
            $this->throw_exception();
        }

        return false;
    }

    public function delete()
    {
        $id = $this->id;

        try {
            $db = Database::getDatabase();
            $stmt = $db->pdo->prepare("CALL stp_delete_user(:id)");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            var_dump($e);
            $this->throw_exception();
        }
    }

    public function save()
    {
        try {
            $db = Database::getDatabase();
            $stmt = null;

            if ($this->id == 0) {
                $stmt = $db->pdo->prepare('CALL stp_create_user(:username, :email, :password)');
            } else {
                $stmt = $db->pdo->prepare('CALL stp_update_user(:id, :username, :email, :password)');
                $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
            }

            $stmt->bindValue(":username", $this->username, PDO::PARAM_STR);
            $stmt->bindValue(":email", $this->email, PDO::PARAM_STR);
            $stmt->bindValue(":password", $this->password, PDO::PARAM_STR);
            $stmt->execute();

            if ($this->id == 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->id = $result["id"];
            }

            if ($this->id != 0) {
                return true;
            }
        } catch (Exception $e) {
            echo $e;
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

    public function getPassword()
    {
        return $this->password;
    }

    public function changePassword($newPassword)
    {
        // $this->password = Hash::make($newPassword);
        // TODO: add again later, but checking the hashing results and comparison
        $this->password = $newPassword;
    }

    private function throw_exception()
    {
        throw Bookerr::Exception("Desculpe, ocorreu um erro e não foi possível completar a requisição!");
    }
}

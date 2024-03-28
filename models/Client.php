<?php

require_once "Hash.php";

class Client
{
    private $id = 0;
    private $username;
    private $email;
    private $password;

    public function __construct($username, $email, $password, $id = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;

        if ($password)
            $this->changePassword($password);
    }

    public function findByUsernameAndPassword($isPasswordOptional = false)
    {
        $username = $this->username;
        $password = $this->password;

        if (!$username) {
            return [false, "you should provide valid username"];
        }

        if (!$isPasswordOptional && !$password) {
            return [false, "you should provide valid password"];
        }

        try {
            $conn = new Database();
            $stmt = $conn->pdo->prepare("SELECT c.id, c.username, c.password, c.email FROM client c WHERE c.username=:username AND c.password=IF(:is_password_optional, c.password, :password)");
            $stmt->bindValue(":username", $username, PDO::PARAM_STR);
            $stmt->bindValue(":is_password_optional", $isPasswordOptional, PDO::PARAM_BOOL);
            $stmt->bindValue(":password", $password, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $this->id = $result["id"];
                $this->username = $result["username"];
                $this->email = $result["email"];
                $this->password = $result["password"];

                return [true, true];
            }

            return [true, false];
        } catch (PDOException $e) {
            return array(false, "Sorry, we couldn't connect to the database. Please, try later...");
        } catch (Exception $e) {
            return array(false, "Sorry, something went wrong, and was not possible to proccess your request!");
        }
    }

    public function save()
    {
        try {
            $conn = new Database();
            $pdo = null;

            if ($this->id == 0) {
                $pdo = $conn->pdo->prepare('CALL stp_create_client(:username, :email, :password, @id)');
            } else {
                $pdo = $conn->pdo->prepare('CALL stp_update_client(:id, :username, :email, :password)');
                $pdo->bindValue(":id", $this->id, PDO::PARAM_INT);
            }

            $pdo->bindValue(":username", $this->username, PDO::PARAM_STR);
            $pdo->bindValue(":email", $this->email, PDO::PARAM_STR);
            $pdo->bindValue(":password", $this->password, PDO::PARAM_STR);
            $pdo->execute();

            if ($this->id == 0) {
                $stmt = $conn->pdo->prepare("SELECT @id AS id");
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->id = $result["id"];
            }

            return array(true, null);
        } catch (PDOException $e) {
            return array(false, "Sorry, we couldn't connect to the database to save the data. Please, try again later...");
        } catch (Exception $e) {
            return array(false, "Sorry, something went wrong, and was not possible to proccess your request!");
        }
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

    public function changePassword($newPassword)
    {
        // $this->password = Hash::make($newPassword);
        // TODO: add again later, but checking the hashing results and comparison
        $this->password = $newPassword;
    }
}

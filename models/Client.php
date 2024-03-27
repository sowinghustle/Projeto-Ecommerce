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
        $this->changePassword($password);
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
            return array(false, "unexpected exception " . $e->getMessage());
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
        $this->usernmae = $newUsername;
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
        $this->password = Hash::make($newPassword);
    }
}

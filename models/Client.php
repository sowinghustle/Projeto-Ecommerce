<?php

require_once "Hash.php";

class Client
{
    private $id;
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

            $pdo = $conn->pdo->prepare('CALL stp_create_client(:username, :email, :password, @id)');
            $pdo->bindValue(":username", $this->username, PDO::PARAM_STR);
            $pdo->bindValue(":email", $this->email, PDO::PARAM_STR);
            $pdo->bindValue(":password", $this->password, PDO::PARAM_STR);
            $pdo->execute();

            $stmt = $conn->pdo->prepare("SELECT @id AS id");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return array(true, $result['id']);
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

    public function getPassword()
    {
        return $this->password;
    }

    public function changePassword($newPassword)
    {
        $this->password = Hash::make($newPassword);
    }
}

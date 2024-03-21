<?php

class Database
{
    private $host = DB_HOST;
    private $db = DB_NAME;
    private $login = DB_USER;
    private $pass = DB_PASSWORD;
    private $error = null;
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db", $this->login, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->error = $e;
        }
    }

    public function hasError()
    {
        return $this->error != null;
    }

    public function getError()
    {
        return $this->error;
    }

    public function query($query)
    {
        if ($this->conn == null)
            return false;

        $this->error = null;

        try {
            $stmt = $this->conn->query($query);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            $this->error = $e;
            return false;
        }
    }

    public function exec($query)
    {
        if ($this->conn == null)
            return false;

        $this->error = null;

        try {
            return $this->conn->exec($query);
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return false;
        }
    }
}

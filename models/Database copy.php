<?php

class Database
{
    private $host = DB_HOST;
    private $db = DB_NAME;
    private $login = DB_USER;
    private $pass = DB_PASSWORD;
    private $error = null;
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->db", $this->login, $this->pass, array(PDO::ATTR_PERSISTENT => true));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

    public function fetch($query, $params = [])
    {
        if ($this->pdo == null)
            return false;

        $this->error = null;

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function exec($query, $params = [])
    {
        if ($this->pdo == null)
            return false;

        $this->error = null;

        try {
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute($params);

            return $result;
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function beginTransaction()
    {
        if ($this->pdo) {
            return $this->pdo->beginTransaction();
        }
        return false;
    }

    public function commit()
    {
        if ($this->pdo) {
            return $this->pdo->commit();
        }
        return false;
    }

    public function rollBack()
    {
        if ($this->pdo) {
            return $this->pdo->rollBack();
        }
        return false;
    }
}

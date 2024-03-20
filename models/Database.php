<?php

class Database
{
    private $host = "localhost";
    private $db = "db";
    private $login = "user";
    private $pass = "you_dont_deserve_to_live";
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli(
            $this->host,
            $this->login,
            $this->pass,
            $this->db
        );
    }

    public function query($query)
    {
        $result = $this->conn->query($query);

        if ($result && $result->num_rows > 0) {
            $data = array();

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            return $data;
        }

        return false;
    }

    public function exec($query)
    {
        return $this->conn->query($query);
    }
}

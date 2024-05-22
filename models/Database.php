<?php

class Database
{
    private $host = DB_HOST;
    private $db = DB_NAME;
    private $login = DB_USER;
    private $pass = DB_PASSWORD;
    public PDO $pdo;
    private static $database;

    private function __construct()
    {
        $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->db", $this->login, $this->pass, array(PDO::ATTR_PERSISTENT => true));
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public static function getDatabase()
    {
        if (self::$database == null) {
            self::$database = new Database();
        }
        return self::$database;
    }
}

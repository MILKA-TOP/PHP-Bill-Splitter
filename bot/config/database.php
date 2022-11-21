<?php

class Database
{
    public $conn;
    private $host = "127.0.0.1";
    private $database_name = BOT_DB_NAME;
    private $username = BOT_DB_USERNAME;
    private $password = BOT_DB_PASSWORD;

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Database could not be connected: " . $exception->getMessage();
        }
        return $this->conn;
    }
}



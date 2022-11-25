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
        } catch (PDOException $exception) {
            vkApi_messagesSend(219928545, $exception->getMessage());
            echo "Database could not be connected: " . $exception->getMessage();
        }
        return $this->conn;
    }
}



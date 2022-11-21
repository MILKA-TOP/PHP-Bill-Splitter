<?php

class User
{
    // Connection
    public $id;
    // Table
    public $stateId;
    // Columns
    public $stateArgs;
    public $bills;
    private $conn;
    private $db_table = "USER";

    // Db connection

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET ALL
    public function getUsers()
    {
        $sqlQuery = "SELECT id, stateId, stateArgs, bills FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createUser()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    (id, stateId, stateArgs, bills)
                    VALUES ($this->id, $this->stateId, '$this->stateArgs', '$this->bills');";
        vkApi_messagesSend(ADMIN_ID, $sqlQuery);

        $stmt = $this->conn->prepare($sqlQuery);

        /*
        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->stateId = htmlspecialchars(strip_tags($this->stateId));
        $this->stateArgs = htmlspecialchars(strip_tags($this->stateArgs));
        $this->bills = htmlspecialchars(strip_tags($this->bills));

        // bind data
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":stateId", $this->stateId);
        $stmt->bindParam(":stateArgs", $this->stateArgs);
        $stmt->bindParam(":bills", $this->bills);*/
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // READ single
    public function getSingleUser()
    {
        $sqlQuery = "SELECT
                        stateId, 
                        stateArgs, 
                        bills 
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       id = " . $this->id . ";";
        vkApi_messagesSend(ADMIN_ID, $sqlQuery);
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->stateId = $dataRow['stateId'];
        $this->stateArgs = $dataRow['stateArgs'];
        $this->bills = $dataRow['bills'];
    }
}


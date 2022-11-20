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
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
                    SET
                        id = :id, 
                        stateId = :stateId, 
                        stateArgs = :stateArgs, 
                        bills = :bills";

        $stmt = $this->conn->prepare($sqlQuery);

        /*
        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->stateId = htmlspecialchars(strip_tags($this->stateId));
        $this->stateArgs = htmlspecialchars(strip_tags($this->stateArgs));
        $this->bills = htmlspecialchars(strip_tags($this->bills));*/

        // bind data
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":stateId", $this->stateId);
        $stmt->bindParam(":stateArgs", $this->stateArgs);
        $stmt->bindParam(":bills", $this->bills);

        return $stmt->execute();
    }

    // READ single
    public function getSingleUser()
    {
        $sqlQuery = "SELECT
                        stateId, 
                        stateArgs, 
                        bills, 
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       id = ?
                    LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->stateId = $dataRow['stateId'];
        $this->stateArgs = $dataRow['stateArgs'];
        $this->bills = $dataRow['bills'];
    }
}
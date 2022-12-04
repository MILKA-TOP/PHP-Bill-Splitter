<?php

class User
{
    // Columns
    public $id;
    public $stateId;
    public $stateArgs;
    public $bills;
    // Connection
    private $conn;
    // Table
    private $db_table = "USER";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // CREATE
    public function createUser()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    (id, stateId, stateArgs, bills)
                    VALUES ($this->id, $this->stateId, '$this->stateArgs', '$this->bills');";

        $stmt = $this->conn->prepare($sqlQuery);
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
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->stateArgs = $dataRow['stateArgs'];
        $this->stateId = $dataRow['stateId'];
        $this->bills = $dataRow['bills'];
    }

    public function updateState($newStateId)
    {
        $sqlQuery = "UPDATE " . $this->db_table . " 
                    SET stateId = " . $newStateId . "
                    WHERE id = " . $this->id . ";";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
    }

    public function updateStateWithArgs($newStateId, $newStateArgs)
    {
        $sqlQuery = "UPDATE " . $this->db_table . " 
                    SET stateId = " . $newStateId . ",
                        stateArgs = '" . $newStateArgs . "'
                    WHERE id = " . $this->id . ";";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
    }

    public function updateBillIdsArray($newArray)
    {
        $sqlQuery = "UPDATE " . $this->db_table . " 
                    SET bills = '" . $newArray . "'
                    WHERE id = " . $this->id . ";";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
    }
}


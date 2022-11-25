<?php

class Field
{
    // Columns
    public $id;
    public $name;
    public $price;
    public $singleBillId;
    public $bills;
    // Connection
    private $conn;
    // Table
    private $db_table = "FIELD";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET ALL
    public function getField()
    {
        $sqlQuery = "SELECT id, name, price, singleBillId, bills FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createField()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    (name, price, singleBillId, bills)
                    VALUES ($this->name, $this->price, $this->singleBillId, $this->bills);";

        $stmt = $this->conn->prepare($sqlQuery);
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // READ single
    public function getSingleField()
    {
        $sqlQuery = "SELECT
                        name, 
                        price, 
                        singleBillId, 
                        bills 
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       id = " . $this->id . ";";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $dataRow['name'];
        $this->price = $dataRow['price'];
        $this->singleBillId = $dataRow['singleBillId'];
        $this->bills = $dataRow['bills'];
    }
}


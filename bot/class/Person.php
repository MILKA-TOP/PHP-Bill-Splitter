<?php

class Person
{
    // Columns
    public $id;
    public $name;
    public $singleBillsIds;
    public $billId;
    // Connection
    private $conn;
    // Table
    private $db_table = "PERSON";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET ALL
    public function getPerson()
    {
        $sqlQuery = "SELECT id, name, singleBillsIds, billId FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createPerson()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    (name, singleBillsIds, billId)
                    VALUES ('$this->name', '$this->singleBillsIds', $this->billId);";
        $stmt = $this->conn->prepare($sqlQuery);
        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    // READ single
    public function getSinglePerson()
    {
        $sqlQuery = "SELECT
                        name, 
                        singleBillsIds, 
                        billId 
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       id = " . $this->id . ";";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $dataRow['name'];
        $this->singleBillsIds = $dataRow['singleBillsIds'];
        $this->billId = $dataRow['billId'];
    }

    public function getPersonsBillList($id_array)
    {
        $sqlQuery = "SELECT
                        id,
                        name 
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       id in (" . implode(', ', $id_array) . ");";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $dataRow = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $output_array = [];
        foreach ($dataRow as $sub_array) {
            $output_array[$sub_array['id']] = $sub_array['name'];
        }
        return $output_array;
    }
}


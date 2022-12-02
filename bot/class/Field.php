<?php

class Field
{
    // Columns
    public $id;
    public $name;
    public $price;
    public $singleBillId;
    public $billId;
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
        $sqlQuery = "SELECT id, name, price, singleBillId, billId FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createField()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    (name, price, singleBillId, billId)
                    VALUES ('$this->name', $this->price, $this->singleBillId, $this->billId);";
        vkApi_messagesSend(ADMIN_ID, $sqlQuery);
        $stmt = $this->conn->prepare($sqlQuery);
        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
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
                        billId 
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
        $this->billId = $dataRow['billId'];
    }

    public function getFieldsNamesList($id_array)
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

    public function getFieldsValuesList($id_array)
    {
        $sqlQuery = "SELECT
                        id,
                        price 
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       id in (" . implode(', ', $id_array) . ");";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $dataRow = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $output_array = [];
        foreach ($dataRow as $sub_array) {
            $output_array[$sub_array['id']] = $sub_array['price'];
        }
        return $output_array;
    }

    public function getFieldsIdsBySingleBillId($singleBillId)
    {
        $sqlQuery = "SELECT
                        id
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       singleBillId = " . $singleBillId . ";";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}


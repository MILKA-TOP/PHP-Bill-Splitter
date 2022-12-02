<?php

class SingleBill
{
    // Connection
    private $conn;

    // Columns
    public $id;
    public $billId;
    public $persons;
    public $fields;
    public $fullValue;
    public $isPersonField;
    // Table
    private $db_table = "SINGLE_BILL";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET ALL
    public function getSingleBills()
    {
        $sqlQuery = "SELECT id, billId, persons, fields, fullValue, isPersonField FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createSingleBill()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    (billId, persons, fields, fullValue, isPersonField)
                    VALUES ($this->billId, '$this->persons', '$this->fields', $this->fullValue, $this->isPersonField);";

        $stmt = $this->conn->prepare($sqlQuery);
        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    // READ single
    public function getSingleBill()
    {
        $sqlQuery = "SELECT
                       billId,
                       persons,
                       fields,
                       fullValue,
                       isPersonField
                      FROM
                        " . $this->db_table . "
                    WHERE
                       id = " . $this->id . ";";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->billId = $dataRow['billId'];
        $this->persons = $dataRow['persons'];
        $this->fields = $dataRow['fields'];
        $this->fullValue = $dataRow['fullValue'];
        $this->isPersonField = $dataRow['isPersonField'];
    }

    public function getPersonsValueBillList($billId)
    {
        $sqlQuery = "SELECT
                        id,
                        persons,
                        fullValue
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       billId = " . $billId . ";";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPersonsSingleBillList($billId)
    {
        $sqlQuery = "SELECT
                        id,
                        persons 
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       billId = " . $billId . ";";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $dataRow = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $output_array = [];
        foreach ($dataRow as $sub_array) {
            $output_array[$sub_array['id']] = $sub_array['persons'];
        }
        return $output_array;
    }

    public function updateFullValue($deltaValue) {
        $sqlQuery = "UPDATE " . $this->db_table . " 
                    SET fullValue = fullValue + " . $deltaValue . "
                    WHERE id = " . $this->id . ";";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
    }

    public function updateFieldsArray($fields) {
        $sqlQuery = "UPDATE " . $this->db_table . " 
                    SET fields = '" . $fields . "'
                    WHERE id = " . $this->id . ";";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
    }

}


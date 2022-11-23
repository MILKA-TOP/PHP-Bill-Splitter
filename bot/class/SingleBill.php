<?php

class Bill
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
            return true;
        }

        return false;
    }

    // READ single
    public function getSingleBill()
    {
        $sqlQuery = "SELECT
                        adminId,
                        password,
                        persons,
                        name,
                        singleBillsIds
                      FROM
                        " . $this->db_table . "
                    WHERE
                       id = " . $this->id . ";";
        vkApi_messagesSend(ADMIN_ID, $sqlQuery);
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->adminId = $dataRow['adminId'];
        $this->password  = $dataRow['password'];
        $this->persons  = $dataRow['persons'];
        $this->name  = $dataRow['name'];
        $this->singleBillsIds = $dataRow['singleBillsIds'];
    }
}


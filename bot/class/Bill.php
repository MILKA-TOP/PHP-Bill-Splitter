<?php

class Bill
{
    // Connection
    private $conn;

    // Columns
    public $id;
    public $adminId;
    public $password;
    public $persons;
    public $name;
    public $singleBillsIds;
    // Table
    private $db_table = "BILL";


    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET ALL
    public function getBills()
    {
        $sqlQuery = "SELECT id, adminId, password, persons, name, singleBillsIds FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createBill()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    (adminId, password, persons, name, singleBillsIds)
                    VALUES ($this->adminId, $this->password, '$this->persons', $this->name, '$this->singleBillsIds');";

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


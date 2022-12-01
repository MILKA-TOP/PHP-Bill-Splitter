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
        $password_string = $this->password;
        if (!is_null($password_string)) $password_string = "'" . $password_string . "'";
        else $password_string = 'null';
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    (adminId, password, persons, name, singleBillsIds)
                    VALUES ($this->adminId, $password_string, '$this->persons', '$this->name', '$this->singleBillsIds');";

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
                        adminId, 
                        password, 
                        persons, 
                        name, 
                        singleBillsIds
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       id = " . $this->id . ";";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->adminId = $dataRow['adminId'];
        $this->password = $dataRow['password'];
        $this->persons = $dataRow['persons'];
        $this->name = $dataRow['name'];
        $this->singleBillsIds = $dataRow['singleBillsIds'];
    }

    public function updatePersonId($newPersonIdsJson)
    {
        $sqlQuery = "UPDATE " . $this->db_table . " 
                    SET persons = '" . $newPersonIdsJson . "'
                    WHERE id = " . $this->id . ";";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
    }

    public function updateSingleBillId($newSingleBillIdsJson)
    {
        $sqlQuery = "UPDATE " . $this->db_table . " 
                    SET singleBillsIds = '" . $newSingleBillIdsJson . "'
                    WHERE id = " . $this->id . ";";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
    }

    public function getNameBillList($id_array): array
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

    public function getSingleBillIds($billId)
    {
        $sqlQuery = "SELECT
                        singleBillsIds
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       id = " . $billId . ";";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();

        return json_decode($stmt->fetchAll(PDO::FETCH_ASSOC)[0]['singleBillsIds'], true);
    }

}


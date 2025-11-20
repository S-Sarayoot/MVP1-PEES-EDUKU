<?php
class Zipcode {
    // database connection and table name
    private $conn;
    private $table_name = "tb_areazone";

    // object properties
    public $user_id;
    public $areaId;
    public $areaZone;
    public $areaDistrict;
    public $areaZipcode;
    public $areaUpdateDate;
    public $create_date;
    public $update_date;

    // constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAreaByZipcode($zipcode) {
        // query to read single record
        $query = "SELECT * FROM " . $this->table_name . " WHERE areaZipcode = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of product to be updated
        $stmt->bindParam(1, $zipcode);

        // execute query
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result["areaZone"];
        }
        return "-";
    }
}
?>
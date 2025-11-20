<?php
class Price {
    // database connection and table name
    private $conn;
    private $table_name = "tb_user_price";

    // object properties
    public $price_id;
    public $user_id;
    public $chill_s;
    public $chill_m;
    public $chill_l;
    public $chill_xl;
    public $frozen_s;
    public $frozen_m;
    public $frozen_l;
    public $frozen_xl;
    public $cod_price;
    public $create_date;
    public $update_date;

    // constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // ดึงข้อมูลราคาตาม user_id
    public function getPriceByUserId($user_id) {
        // query to read single record
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of product to be updated
        $stmt->bindParam(1, $user_id);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // บันทึกหรืออัปเดตราคา
    public function savePrice() {
        // ตรวจสอบว่ามีข้อมูลราคาของ user นี้แล้วหรือไม่
        $check_query = "SELECT price_id FROM " . $this->table_name . " WHERE user_id = ? LIMIT 0,1";
        $check_stmt = $this->conn->prepare($check_query);
        $check_stmt->bindParam(1, $this->user_id);
        $check_stmt->execute();

        if($check_stmt->rowCount() > 0) {
            // อัปเดตข้อมูลที่มีอยู่
            $row = $check_stmt->fetch(PDO::FETCH_ASSOC);
            $this->price_id = $row['price_id'];
            
            $query = "UPDATE " . $this->table_name . " SET
                      chill_s = :chill_s,
                      chill_m = :chill_m,
                      chill_l = :chill_l,
                      chill_xl = :chill_xl,
                      frozen_s = :frozen_s,
                      frozen_m = :frozen_m,
                      frozen_l = :frozen_l,
                      frozen_xl = :frozen_xl,
                      cod_price = :cod_price,
                      update_date = NOW()
                      WHERE price_id = :price_id";
        } else {
            // สร้างข้อมูลใหม่
            $query = "INSERT INTO " . $this->table_name . "
                      SET user_id = :user_id,
                      chill_s = :chill_s,
                      chill_m = :chill_m,
                      chill_l = :chill_l,
                      chill_xl = :chill_xl,
                      frozen_s = :frozen_s,
                      frozen_m = :frozen_m,
                      frozen_l = :frozen_l,
                      frozen_xl = :frozen_xl,
                      cod_price = :cod_price,
                      create_date = NOW()";
        }

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->chill_s = htmlspecialchars(strip_tags($this->chill_s));
        $this->chill_m = htmlspecialchars(strip_tags($this->chill_m));
        $this->chill_l = htmlspecialchars(strip_tags($this->chill_l));
        $this->chill_xl = htmlspecialchars(strip_tags($this->chill_xl));
        $this->frozen_s = htmlspecialchars(strip_tags($this->frozen_s));
        $this->frozen_m = htmlspecialchars(strip_tags($this->frozen_m));
        $this->frozen_l = htmlspecialchars(strip_tags($this->frozen_l));
        $this->frozen_xl = htmlspecialchars(strip_tags($this->frozen_xl));
        $this->cod_price = htmlspecialchars(strip_tags(string: $this->cod_price));

        // bind values
        if(isset($this->price_id)) {
            $stmt->bindParam(":price_id", $this->price_id);
        } else {
            $stmt->bindParam(":user_id", $this->user_id);
        }
        
        $stmt->bindParam(":chill_s", $this->chill_s);
        $stmt->bindParam(":chill_m", $this->chill_m);
        $stmt->bindParam(":chill_l", $this->chill_l);
        $stmt->bindParam(":chill_xl", $this->chill_xl);
        $stmt->bindParam(":frozen_s", $this->frozen_s);
        $stmt->bindParam(":frozen_m", $this->frozen_m);
        $stmt->bindParam(":frozen_l", $this->frozen_l);
        $stmt->bindParam(":frozen_xl", $this->frozen_xl);
        $stmt->bindParam(":cod_price", $this->cod_price);

        // execute query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // ดึงราคาจากรหัสผู้ใช้ ประเภทบริการ และขนาดพัสดุ
    public function getPrice($user_id, $service_type, $parcel_size) {
        $query = "
            SELECT 
                CASE 
                    WHEN :service_type = 'CH' THEN 
                        CASE :parcel_size 
                            WHEN 'S' THEN chill_s 
                            WHEN 'M' THEN chill_m 
                            WHEN 'L' THEN chill_l 
                            WHEN 'XL' THEN chill_xl 
                        END
                    WHEN :service_type = 'FR' THEN 
                        CASE :parcel_size 
                            WHEN 'S' THEN frozen_s 
                            WHEN 'M' THEN frozen_m 
                            WHEN 'L' THEN frozen_l 
                            WHEN 'XL' THEN frozen_xl 
                        END
                END AS price
            FROM " . $this->table_name . " 
            WHERE user_id = :user_id"
        ;

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':service_type', $service_type);
        $stmt->bindParam(':parcel_size', $parcel_size);

        $stmt->execute();
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['price'];
        } else {
            return null; // หรือสามารถคืนค่าเป็น 0 หรือข้อความแสดงข้อผิดพลาดได้
        }
    }

    public function getCostPrice($service_type, $parcel_size) {
        $query = "
            SELECT 
                CASE 
                    WHEN :service_type = 'CH' THEN 
                        CASE :parcel_size 
                            WHEN 'S' THEN chill_s 
                            WHEN 'M' THEN chill_m 
                            WHEN 'L' THEN chill_l 
                            WHEN 'XL' THEN chill_xl 
                        END
                    WHEN :service_type = 'FR' THEN 
                        CASE :parcel_size 
                            WHEN 'S' THEN frozen_s 
                            WHEN 'M' THEN frozen_m 
                            WHEN 'L' THEN frozen_l 
                            WHEN 'XL' THEN frozen_xl 
                        END
                END AS price
            FROM " . $this->table_name . " 
            WHERE user_id = '1' "
        ;

        $stmt = $this->conn->prepare($query);

        //$stmt->bindParam(':user_id', '1');    // Assuming user_id is 1 for cost price
        $stmt->bindParam(':service_type', $service_type);
        $stmt->bindParam(':parcel_size', $parcel_size);

        $stmt->execute();
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['price'];
        } else {
            return null; // หรือสามารถคืนค่าเป็น 0 หรือข้อความแสดงข้อผิดพลาดได้
        }
    }

    public function getCodPrice($user_id) {
        $query = "
            SELECT 
                cod_price
            FROM " . $this->table_name . " 
            WHERE user_id = :user_id"
        ;

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['cod_price'];
        } else {
            return null; // หรือสามารถคืนค่าเป็น 0 หรือข้อความแสดงข้อผิดพลาดได้
        }
    }
}
?>
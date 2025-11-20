<?php
class Tracking {
    private $conn;
    private $table_name_order = "tb_shippingorder";
    private $table_name_status = "tb_status";  
    private $table_name_history = "tb_status_history";

    public function __construct($db) {
        $this->conn = $db;
    }

    // ตรวจสอบว่ามี barcode นี้ในระบบหรือไม่
    public function checkBarcode($barcode) {
        $query = "SELECT polarsTrackingcode FROM " . $this->table_name_order . " WHERE polarsTrackingcode = :barcode LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':barcode', $barcode);
        $stmt->execute();
        return $stmt;
    }

    //find status
    public function findStatus() {
        $query = "SELECT * FROM " . $this->table_name_status . " WHERE status_code != '101' ORDER BY status_code ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    
    public function findAllStatus() {
        $query = "SELECT * FROM " . $this->table_name_status . "  ORDER BY status_code ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // อัพเดตสถานะของออเดอร์ตาม barcode
    public function updateOrderStatus($barcode, $status, $status_code, $location, $note, $user_id, $user_code, $photoPath = null, $signaturePath = null) {
        // อัพเดตสถานะใน tb_shippingorder
        $query = "UPDATE {$this->table_name_order} SET parcelStatus = :status_code,updatedDate = NOW() WHERE polarsTrackingcode = :barcode";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status_code', $status_code);
        $stmt->bindParam(':barcode', $barcode);
        $success = $stmt->execute();

        if ($success) {
            // บันทึก log ลง tb_status_history (เพิ่มรูปและลายเซ็นต์)
            $query2 = "INSERT INTO {$this->table_name_history} 
                (polarsTrackingcode, status, status_code, location, status_date, note, updated_by, updated_by_code, receive_photo, receive_signature) 
                VALUES (:barcode, :status, :status_code, :location, NOW(), :note, :user_id, :user_code, :photoPath, :signaturePath)";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':barcode', $barcode);
            $stmt2->bindParam(':status', $status);
            $stmt2->bindParam(':status_code', $status_code);
            $stmt2->bindParam(':location', $location);
            $stmt2->bindParam(':note', $note);
            $stmt2->bindParam(':user_id', $user_id);
            $stmt2->bindParam(':user_code', $user_code);
            $stmt2->bindParam(':photoPath', $photoPath);
            $stmt2->bindParam(':signaturePath', $signaturePath);
            $stmt2->execute();
        }
        return $success;
    }

    // get history by barcode
    public function getHistoryByBarcode($barcode) {
        $query = "SELECT * FROM {$this->table_name_history} WHERE polarsTrackingcode = :barcode ORDER BY status_date ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':barcode', $barcode);
        $stmt->execute();
        return $stmt;
    }

    public function updateOrderStatus_only_status($polarsTrackingcode, $status, $status_code, $location, $note, $user_id, $user_code, $photoPath = null, $signaturePath = null) {

        // บันทึก log ลง tb_status_history (เพิ่มรูปและลายเซ็นต์)
        $query2 = "INSERT INTO {$this->table_name_history} 
            (polarsTrackingcode, status, status_code, location, status_date, note, updated_by, updated_by_code, receive_photo, receive_signature) 
            VALUES (:barcode, :status, :status_code, :location, NOW(), :note, :user_id, :user_code, :photoPath, :signaturePath)";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bindParam(':barcode', $polarsTrackingcode);
        $stmt2->bindParam(':status', $status);
        $stmt2->bindParam(':status_code', $status_code);
        $stmt2->bindParam(':location', $location);
        $stmt2->bindParam(':note', $note);
        $stmt2->bindParam(':user_id', $user_id);
        $stmt2->bindParam(':user_code', $user_code);
        $stmt2->bindParam(':photoPath', $photoPath);
        $stmt2->bindParam(':signaturePath', $signaturePath);
        $stmt2->execute();
        
    }

    public function findStatusName($status_code) {
        $query = "SELECT status_name FROM " . $this->table_name_status . " WHERE status_code = :status_code LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status_code', $status_code);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC)['status_name'];
        }
        return null;
    }
}

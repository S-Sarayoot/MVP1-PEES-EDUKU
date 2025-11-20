<?php
// Model สำหรับสื่อการสอน (TeachingMedia)
class TeachingMedia {
    private $conn;
    private $table = "elk_teaching_media";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($file_name, $description, $category, $credential_user_id) {
        $sql = "INSERT INTO {$this->table} (file_name, description, category, uploaded_by) VALUES (:file_name, :description, :category, :uploaded_by)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) return false;
        $file_name = $file_name ?? '';
        return $stmt->execute([
            ':file_name' => $file_name,
            ':description' => $description,
            ':category' => $category,
            ':uploaded_by' => $credential_user_id
        ]);
    }

    // ดึงข้อมูลทั้งหมด
    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}

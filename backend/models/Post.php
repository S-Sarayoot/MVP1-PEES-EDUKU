   
<?php
// Model สำหรับโพสต์ทรัพยากร (Post)
class Post {
    private $conn;
    private $table = "elk_post";

    public function __construct($db) {
        $this->conn = $db;
    }

    // $data = ['title'=>..., 'description'=>..., 'category'=>..., 'media_link'=>..., 'credential_user_id'=>..., 'images'=>[], 'videos'=>[]]
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (title, description, category, media_link, images, videos, files, uploaded_by) VALUES (:title, :description, :category, :media_link, :images, :videos, :files, :uploaded_by)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) return false;
        // images/videos/files เป็น array -> json_encode
        $images = isset($data['images']) ? json_encode($data['images']) : null;
        $videos = isset($data['videos']) ? json_encode($data['videos']) : null;
        $files = isset($data['files']) ? json_encode($data['files']) : null;
        return $stmt->execute([
            ':title' => $data['title'] ?? '',
            ':description' => $data['description'] ?? '',
            ':category' => $data['category'] ?? '',
            ':media_link' => $data['media_link'] ?? '',
            ':images' => $images,
            ':videos' => $videos,
            ':files' => $files,
            ':uploaded_by' => $data['credential_user_id'] ?? null
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

     // อัปเดตข้อมูลโพสต์
    public function update($data) {
        // Only update images/videos/files if not null, otherwise keep old value
        $fields = [
            'title = :title',
            'description = :description',
            'category = :category',
            'media_link = :media_link',
            'uploaded_by = :uploaded_by'
        ];
        $params = [
            ':id' => $data['id'],
            ':title' => $data['title'] ?? '',
            ':description' => $data['description'] ?? '',
            ':category' => $data['category'] ?? '',
            ':media_link' => $data['media_link'] ?? '',
            ':uploaded_by' => $data['credential_user_id'] ?? null
        ];
        if (isset($data['images']) && $data['images'] !== null) {
            $fields[] = 'images = :images';
            $params[':images'] = json_encode($data['images']);
        }
        if (isset($data['videos']) && $data['videos'] !== null) {
            $fields[] = 'videos = :videos';
            $params[':videos'] = json_encode($data['videos']);
        }
        if (isset($data['files']) && $data['files'] !== null) {
            $fields[] = 'files = :files';
            $params[':files'] = json_encode($data['files']);
        }
        $sql = "UPDATE {$this->table} SET ".implode(', ', $fields)." WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) return false;
        return $stmt->execute($params);
    }

    // ดึงโพสต์ตาม id
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

<?php

class Major
{
    private PDO $conn;
    private string $table = 'elk_major';

    public ?int $id = null;
    public ?string $name = null;

    public ?string $last_error = null;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    private function normalizeName(?string $name): string
    {
        return trim((string)($name ?? ''));
    }

    public function listAll(): array
    {
        $stmt = $this->conn->query("SELECT id, name FROM {$this->table} ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function existsByName(string $name, ?int $excludeId = null): bool
    {
        $sql = "SELECT id FROM {$this->table} WHERE name = :name";
        $params = [':name' => $name];
        if ($excludeId !== null) {
            $sql .= ' AND id <> :id';
            $params[':id'] = $excludeId;
        }
        $sql .= ' LIMIT 1';

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return (bool)$stmt->fetchColumn();
    }

    public function create(): bool
    {
        $name = $this->normalizeName($this->name);
        if ($name === '') {
            $this->last_error = 'Name is required';
            return false;
        }
        if ($this->existsByName($name)) {
            $this->last_error = 'DUPLICATE_NAME';
            return false;
        }

        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (name) VALUES (:name)");
        if (!$stmt->execute([':name' => $name])) {
            $this->last_error = 'DB_ERROR';
            return false;
        }
        $this->id = (int)$this->conn->lastInsertId();
        $this->name = $name;
        return true;
    }

    public function update(): bool
    {
        $id = (int)($this->id ?? 0);
        $name = $this->normalizeName($this->name);
        if ($id <= 0) {
            $this->last_error = 'ID is required';
            return false;
        }
        if ($name === '') {
            $this->last_error = 'Name is required';
            return false;
        }
        if ($this->existsByName($name, $id)) {
            $this->last_error = 'DUPLICATE_NAME';
            return false;
        }

        $stmt = $this->conn->prepare("UPDATE {$this->table} SET name = :name WHERE id = :id");
        if (!$stmt->execute([':name' => $name, ':id' => $id])) {
            $this->last_error = 'DB_ERROR';
            return false;
        }
        $this->name = $name;
        return true;
    }

    public function isInUse(): bool
    {
        $id = (int)($this->id ?? 0);
        if ($id <= 0) return false;
        $stmt = $this->conn->prepare('SELECT COUNT(*) FROM elk_user WHERE major_id = :id');
        $stmt->execute([':id' => $id]);
        return ((int)$stmt->fetchColumn()) > 0;
    }

    public function delete(): bool
    {
        $id = (int)($this->id ?? 0);
        if ($id <= 0) {
            $this->last_error = 'ID is required';
            return false;
        }
        if ($this->isInUse()) {
            $this->last_error = 'IN_USE';
            return false;
        }

        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = :id");
        if (!$stmt->execute([':id' => $id])) {
            $this->last_error = 'DB_ERROR';
            return false;
        }
        return true;
    }
}

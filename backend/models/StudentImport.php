<?php

class StudentImport
{
    private $conn;
    private $table = 'elk_user';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Insert a student user.
     *
     * @return array{status:string,message?:string}
     *         status: inserted|duplicate|error
     */
    public function insertStudent(array $row): array
    {
        $userCode = trim((string)($row['user_code'] ?? ''));
        $userName = trim((string)($row['user_name'] ?? ''));
        $academicYear = $row['academic_year'] ?? null;
        $academicTerm = $row['academic_term'] ?? null;

        if ($userCode === '') {
            return ['status' => 'error', 'message' => 'missing user_code'];
        }

        $username = $userCode;
        $passwordHash = password_hash($userCode, PASSWORD_DEFAULT);

        $sql = "INSERT INTO {$this->table}
            (user_code, username, password, user_type, user_name, status, faculty_id, major_id, academic_year, academic_term)
            VALUES
            (:user_code, :username, :password, 'student', :user_name, 1, :faculty_id, :major_id, :academic_year, :academic_term)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':user_code', $userCode);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $passwordHash);
        $stmt->bindValue(':user_name', $userName === '' ? null : $userName);

        // We don't import faculty/major in this flow.
        $stmt->bindValue(':faculty_id', null, PDO::PARAM_NULL);
        $stmt->bindValue(':major_id', null, PDO::PARAM_NULL);

        $stmt->bindValue(':academic_year', $academicYear !== null && trim((string)$academicYear) !== '' ? trim((string)$academicYear) : null);
        $stmt->bindValue(':academic_term', $academicTerm !== null && trim((string)$academicTerm) !== '' ? trim((string)$academicTerm) : null);

        try {
            $stmt->execute();
            return ['status' => 'inserted'];
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            if (stripos($msg, 'Duplicate entry') !== false && (stripos($msg, "key 'username'") !== false || stripos($msg, 'username') !== false)) {
                return ['status' => 'duplicate'];
            }

            // Some DB schemas may require faculty_id/major_id. Retry with 0 as a safe default.
            if ((stripos($msg, 'faculty_id') !== false || stripos($msg, 'major_id') !== false) &&
                (stripos($msg, 'cannot be null') !== false || stripos($msg, "doesn't have a default value") !== false)
            ) {
                try {
                    $stmt2 = $this->conn->prepare($sql);
                    $stmt2->bindValue(':user_code', $userCode);
                    $stmt2->bindValue(':username', $username);
                    $stmt2->bindValue(':password', $passwordHash);
                    $stmt2->bindValue(':user_name', $userName === '' ? null : $userName);
                    $stmt2->bindValue(':faculty_id', 0);
                    $stmt2->bindValue(':major_id', 0);
                    $stmt2->bindValue(':academic_year', $academicYear !== null && trim((string)$academicYear) !== '' ? trim((string)$academicYear) : null);
                    $stmt2->bindValue(':academic_term', $academicTerm !== null && trim((string)$academicTerm) !== '' ? trim((string)$academicTerm) : null);
                    $stmt2->execute();
                    return ['status' => 'inserted'];
                } catch (PDOException $e2) {
                    $msg = $e2->getMessage();
                    if (stripos($msg, 'Duplicate entry') !== false && (stripos($msg, "key 'username'") !== false || stripos($msg, 'username') !== false)) {
                        return ['status' => 'duplicate'];
                    }
                    return ['status' => 'error', 'message' => $msg];
                }
            }

            return ['status' => 'error', 'message' => $msg];
        }
    }
}

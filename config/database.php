<?php

// require_once('../../../utils/DatabaseConnection.php');
require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/utils/DatabaseConnection.php');
class Database {
    private $conn;

    public function __construct() {
        $this->conn = DatabaseConnection::getConnection();
    }

    // public function query($sql, $params = []) {
    //     try {
    //         $stmt = $this->conn->prepare($sql);
    //         $stmt->execute($params);
    //         return $stmt;
    //     } catch (PDOException $e) {
    //         echo "Query failed: " . $e->getMessage();
    //         return false;
    //     }
    // }
    public function query($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return false;
        }
    }

    public function getAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        if ($stmt) {
            $results = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $row;
            }
            return $results;
        }
        return [];
    }

    public function getOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        if ($stmt) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }

    public function insert($sql, $params = []) {
        $this->query($sql, $params);
        return $this->conn->lastInsertId();
    }

    public function delete($sql, $params = []) {
        return $this->query($sql, $params);
    }

    public function update($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute($params);
            if (!$result) {
                $errorInfo = $stmt->errorInfo();
                echo "Update failed: " . $errorInfo[2];
            }
            return $result;
        } catch (PDOException $e) {
            echo "Update failed: " . $e->getMessage();
            return false;
        }
    }

    public function count($sql, $params = []) {
        try {
            $stmt = $this->query($sql, $params);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            echo "Count query failed: " . $e->getMessage();
            return 0;
        }
    }
    
}
?>

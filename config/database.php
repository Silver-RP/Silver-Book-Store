<?php
require_once('config.php');
require_once(BASE_PATH . 'utils/DatabaseConnection.php');
// require_once(__DIR__ . '/../utils/DatabaseConnection.php');


class Database {
    private $conn;

    public function __construct() {
        $this->conn = DatabaseConnection::getConnection();
    }
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
    public function execute($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            echo "Execution failed: " . $e->getMessage();
            return false;
        }
    }

    // public function getAll($sql, $params = []) {
    //     $stmt = $this->query($sql, $params);
    //     if ($stmt) {
    //         $results = [];
    //         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //             $results[] = $row;
    //         }
    //         return $results;
    //     }
    //     return [];
    // }

    
    public function getAll($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        // echo "Prepared SQL: " . $stmt->queryString . "\n";
        // print_r($params);
        if ($stmt->execute($params)) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // print_r($result);
            return $result;
        } else {
            // print_r($stmt->errorInfo());
            return null;
        }
    }

    public function getOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        if ($stmt) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }
  
    

    public function insert($sql, $params = []) {
        if ($this->query($sql, $params)) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
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

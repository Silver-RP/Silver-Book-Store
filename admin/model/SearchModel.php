<?php
require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/config/database.php');

class SearchModel {
    private $conn;

    public function __construct() {
        $this->conn = new Database();
    }

    public function search($keyword, $category) {
        $query = "SELECT * FROM books WHERE title LIKE ? AND category = ?";
        $results = []; 
        $stmt = $this->conn->prepare($query);
        $stmt->execute(["%$keyword%", $category]);
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $row;
        }
    
        return $results;
    }
}
?>

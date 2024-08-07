<?php
class WishListModel {
    private $db;

    public function __construct() {
        $this->db = DatabaseConnection::getConnection(); 
    }

    public function addToWishList($userId, $bookId) {
        $sql = "INSERT INTO wishlist (user_id, book_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([$userId, $bookId]);
        // Return a boolean value or relevant message, not PDOStatement
        return $result;
    }
    public function addAllToWishList($userId, $bookId) {
        $sql = "INSERT INTO wishlist (user_id, book_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
    
        try {
            $result = $stmt->execute([$userId, $bookId]);
    
            // Check if the insert was successful
            if ($result) {
                return true; // Successfully added to wishlist
            } else {
                // Optional: Log or handle the case where insertion fails
                error_log("Failed to insert book ID $bookId for user ID $userId into wishlist.");
                return false; // Failed to add to wishlist
            }
        } catch (PDOException $e) {
            // Handle database errors
            error_log("Database error: " . $e->getMessage());
            return false; // Indicate an error occurred
        }
    }
    
    public function checkIfExists($userId, $bookId){
        $sql = "SELECT * FROM wishlist WHERE user_id = ? AND book_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId, $bookId]);
        return $stmt->fetchColumn()>0;
    }
    public function getBooksWishWithStatus($userId) {
        $sql = "SELECT b.*, IF(w.user_id IS NOT NULL, 1, 0) AS is_wished, a.author_name
                FROM book b
                LEFT JOIN wishlist w ON b.book_id = w.book_id AND w.user_id = ?
                JOIN author a ON a.author_id = b.author_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    public function getWishList($userId) {
        $sql = "SELECT w.*, b.book_name, b.book_price, b.book_old_price, b.book_image, a.author_name, b.book_id
                FROM wishlist w
                JOIN book b ON w.book_id = b.book_id
                JOIN author a ON a.author_id = b.author_id
                WHERE w.user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function removeFromWishList($userId, $bookId) {
        $sql = "DELETE FROM wishlist WHERE user_id = ? AND book_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$userId, $bookId]);
    }
}
?>

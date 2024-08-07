<?php

class CartModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function add($userId, $bookId, $quantity) {

        $sql = "SELECT quantity FROM cart WHERE user_id = :user_id AND book_id = :book_id";
        $stmt = $this->db->query($sql, ['user_id' => $userId, 'book_id' => $bookId]);
        $result = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : null;
        if ($result) {
            $newQuantity = $result['quantity'] + $quantity;
            $sql = "UPDATE cart SET quantity = :quantity WHERE user_id = :user_id AND book_id = :book_id";
            $params = ['quantity' => $newQuantity, 'user_id' => $userId, 'book_id' => $bookId];
        } else {
            $sql = "INSERT INTO cart (user_id, book_id, quantity) VALUES (:user_id, :book_id, :quantity)";
            $params = ['user_id' => $userId, 'book_id' => $bookId, 'quantity' => $quantity];
        }
        return $this->db->query($sql, $params);
    }
    public function getBooksFromCart($userId) {
        $sql = "SELECT c.book_id, c.quantity, 
                       b.book_name, b.book_price, b.book_old_price, b.book_image, b.author_id, b.cate_id,
                       (b.book_price * c.quantity) AS total
                FROM cart c 
                JOIN book b ON c.book_id = b.book_id 
                WHERE c.user_id = :user_id";
        return $this->db->getAll($sql, ['user_id' => $userId]);
    }
    public function updateQuantity($userId, $bookId, $quantity) {
        $sql = "UPDATE cart SET quantity = :quantity WHERE user_id = :user_id AND book_id = :book_id";
        $params = ['quantity' => $quantity, 'user_id' => $userId, 'book_id' => $bookId];

        return $this->db->query($sql, $params);
    }
    public function getBookById($bookId) {
        $sql = "SELECT * FROM book WHERE book_id = :book_id";
        return $this->db->getOne($sql, ['book_id' => $bookId]);
    }
    public function removeCart($userId, $bookId) {
        $sql = "DELETE FROM cart WHERE user_id = :user_id AND book_id = :book_id";
        return $this->db->delete($sql, ['user_id' => $userId, 'book_id' => $bookId]);
    }
    public function removeAllCart($userId) {
        $sql = "DELETE FROM cart WHERE user_id = :user_id";
        return $this->db->delete($sql, ['user_id' => $userId]);
    }
}

?>

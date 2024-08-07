<?php
class OrderModel{
    private $db;
    public function __construct(){
        $this->db = new Database();
    }
    public function addShippingInformation($user_id, $shipping) {
        $sql = "INSERT INTO shipping_information (user_id, full_name, address, city, state, zip_code, phone_number) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = [$user_id, $shipping['full_name'], $shipping['address'], $shipping['city'], $shipping['state'], $shipping['zip_code'], $shipping['phone_number']];
        $shipping_id = $this->db->insert($sql, $params);
        if (!$shipping_id) {
            error_log("Failed to add shipping information");
        }
        return $shipping_id;
    }
    
    public function addPaymentInformation($user_id, $payment) {
        $sql = "INSERT INTO payment_information (user_id, payment_method, card_number, card_holder_name, expiration_date, cvv, paypal_email) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $user_id,
            $payment['payment_method'],
            $payment['card_number'] ?? null,
            $payment['card_holder_name'] ?? null,
            $payment['expiration_date'] ?? null,
            $payment['cvv'] ?? null,
            $payment['paypal_email'] ?? null
        ];
        $payment_id = $this->db->insert($sql, $params);
        if (!$payment_id) {
            error_log("Failed to add payment information");
        }
        return $payment_id;
    }
    
    public function addOrder($user_id, $shipping_id, $payment_id, $total_price, $total_books, $books) {
        try {
            $sql = "INSERT INTO orders (user_id, shipping_id, payment_id, total_price, total_books) VALUES (?, ?, ?, ?, ?)";
            $params = [$user_id, $shipping_id, $payment_id, $total_price, $total_books];
            $order_id = $this->db->insert($sql, $params);
    
            if (!$order_id) {
                throw new Exception("Failed to add order");
            }
            $sql = "INSERT INTO order_detail (order_id, book_id, quantity, price) VALUES (?, ?, ?, ?)";
            foreach ($books as $book) {
                $params = [$order_id, $book['book_id'], $book['quantity'], $book['price']];
                $result = $this->db->execute($sql, $params);
                
                if (!$result) {
                    throw new Exception("Failed to add order detail for book_id: {$book['book_id']}. Params: " . json_encode($params));
                }
            }
            return true;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    public function getOrdersByUserId($user_id){
        $sql = "SELECT * FROM orders WHERE user_id = ?";
        return $this->db->getAll($sql, [$user_id]);
    }

    public function getOrderDetailByOrderId($order_id){
        $sql = "SELECT * FROM order_detail WHERE order_id = ?";
        return $this->db->getAll($sql, [$order_id]);
    }

    public function getOrderById($order_id){
        $sql = "SELECT * FROM orders WHERE order_id = ?";
        return $this->db->getOne($sql, $order_id);
    }

    public function getAllPayments(){
        $sql = "SELECT * FROM payment_information";
        return $this->db->getAll($sql);
    }

    // ADMIN FUNCTIONs
    public function countAllOrders(){
        $sql = "SELECT COUNT(*) AS total_orders FROM orders";
        return $this->db->count($sql);
    }

    public function getAllOrders($limit, $offset){
        $sql = "SELECT o.*, u.user_name FROM orders o
                JOIN users u ON o.user_id = u.user_id
                ORDER BY order_date DESC 
                LIMIT $limit OFFSET $offset";
        return $this->db->getAll($sql);
    }

    public function getOrderDetails($orderId) {
        $sql = "SELECT o.*, u.user_name, si.*, pi.*
                FROM orders o
                JOIN users u ON o.user_id = u.user_id
                JOIN shipping_information si ON o.shipping_id = si.id
                JOIN payment_information pi ON o.payment_id = pi.id
                WHERE o.order_id = ?";
        return $this->db->getOne($sql, [$orderId]);
    }

    public function getOrderItems($orderId) {
        $sql = "SELECT od.*, b.*, a.author_name, c.cate_name
                FROM order_detail od
                JOIN book b ON od.book_id = b.book_id
                JOIN author a ON b.author_id = a.author_id
                JOIN category c ON b.cate_id = c.cate_id
                WHERE od.order_id = ?";
        return $this->db->getAll($sql, [$orderId]);
    }

    public function updateOrderStatus($orderId, $newStatus) {
        $validStatuses = ['unpaid', 'paid', 'pending', 'confirmed', 'in delivery', 'received', 'cancelled'];
        if (!in_array($newStatus, $validStatuses)) {
            throw new InvalidArgumentException("Invalid status provided.");
        }
        $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
        try {
            $this->db->execute($sql, [$newStatus, $orderId]);
            return true;
        } catch (Exception $e) {
            throw new Exception("Error updating order status: " . $e->getMessage());
        }
    }

    public function deleteOrder($orderId) {
        $sql = "DELETE FROM orders WHERE order_id = ?";
        try {
            // $this->db->execute($sql, [$orderId]);
            // return true;
            return $this->db->delete($sql, [$orderId]);
        } catch (Exception $e) {
            throw new Exception("Error deleting order: " . $e->getMessage());
        }
    }
    
    
   
}

?>
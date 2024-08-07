<?php
require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/model/OrderModel.php');
class OrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new OrderModel();
    }

    public function index() {
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        try {
            $totalOrders = $this->orderModel->countAllOrders();
            $totalPages = ceil($totalOrders / $limit);
            
            if ($page > $totalPages) {
                $page = $totalPages;
                $offset = ($page - 1) * $limit;
            }

            $orders = $this->orderModel->getAllOrders($limit, $offset);
            require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/view/orders/AllOrders.php');
        } catch (Exception $e) {
            echo "Error fetching data: " . $e->getMessage();
        }
    }

    public function viewOrderDetail() {
        $orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($orderId <= 0) {
            echo "Invalid order ID.";
            return;
        }
        try {
            $orderDetails = $this->orderModel->getOrderDetails($orderId);
            $orderItems = $this->orderModel->getOrderItems($orderId);

            if (!$orderDetails) {
                echo "Order not found.";
                return;
            }
            require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/view/orders/OrderDetail.php');
        } catch (Exception $e) {
            echo "Error fetching order details: " . $e->getMessage();
        }
    }

    public function updateStatus(){
        $orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $newStatus = isset($_POST['status']) ? htmlspecialchars($_POST['status']) : '';

        if ($orderId <= 0 || empty($newStatus)) {
            echo "Invalid order ID or status.";
            return;
        }
        try {
            $this->orderModel->updateOrderStatus($orderId, $newStatus);
            echo "<script>
                    alert('Order status updated successfully.');
                    window.location.href='?act=orders&action=detail&id=$orderId';
                </script>";
            echo "Order status updated successfully.";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function delete(){
        $orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($orderId <= 0) {
            echo "Invalid order ID.";
            return;
        }
        echo "<script>
                if(confirm('Are you sure you want to delete this order?')){
                    window.location.href='?act=orders&action=confirmDelete&id=$orderId';
                }else{
                    window.location.href='?act=orders&action=index';
                }
            </script>";
    }

    public function confirmDelete(){
        $orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($orderId <= 0) {
            echo "Invalid order ID.";
            return;
        }
        try {
            $result = $this->orderModel->deleteOrder($orderId);
            if(!$result){
                echo "Error deleting order.";
                return;
            }
            echo "<script>
                    alert('Order deleted successfully.');
                    window.location.href='?act=orders&action=index';
                </script>";
        } catch (Exception $e) {
            echo "Error deleting order: " . $e->getMessage();
        }
    }

}


?>
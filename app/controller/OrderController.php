<?php
class OrderController
{
    private $orderModel;
    private $bookModel;
    private $authorModel;
    private $categoryModel;
    public function __construct(){
        $this->orderModel = new OrderModel();
        $this->bookModel = new BookModel();
        $this->authorModel = new AuthorModel();
        $this->categoryModel = new CategoryModel();
    }
    public function buyNow(){
        session_start();

        if (isset($_SESSION['user'])) {
            $user_id = $_SESSION['user']['user_id'];
            $book_id = isset($_GET['id']) ? intval($_GET['id']) : null;

            if ($book_id) {
                $book = $this->bookModel->getBookById($book_id);

                if ($book) {
                    $author = $this->authorModel->getAuthorById($book['author_id']);
                    $category = $this->categoryModel->getCategoryById($book['cate_id']);
                    require_once('app/view/order/BuyNow.php');
                } else {
                    echo "Book not found.";
                }
            } else {
                echo "Invalid book ID.";
            }
        } else {
            $book_id = isset($_GET['id']) ? intval($_GET['id']) : null;

            if ($book_id) {
                $_SESSION['redirect'] = '?route=order&subroute=buynow&id=' . $book_id;
            } else {
                $_SESSION['redirect'] = '?route=order&subroute=buyNow';
            }

            echo "<script>
                        alert('Please login to buy book');
                        setTimeout(() => {
                            window.location.href = 'index.php?route=user&subroute=signin';
                        }, 1000);
                      </script>";
        }
    }

    public function checkout(){
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
            exit();
        }

        $user_id = $_SESSION['user']['user_id'];
        $shipping = $data['shipping'];
        $payment = $data['payment'];
        $order = $data['order'];
        $shipping_id = $this->orderModel->addShippingInformation($user_id, $shipping);
        $payment_id = $this->orderModel->addPaymentInformation($user_id, $payment);
        $result = $this->orderModel->addOrder($user_id, $shipping_id, $payment_id, $order['total_price'], $order['total_books'], $order['books']);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Order placed successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to place order', 'result' => $result]);
        }
    }

    public function orderSuccess(){
        // random order number
        $orderNumber = 'ORD' . rand(100000, 999999);
        require_once('app/view/order/OrderResult.php');
    }

    public function viewOrder(){
        session_start();
        if (isset($_SESSION['user'])) {
            $user_id = $_SESSION['user']['user_id'];
            $authors = $this->authorModel->getAllAuthors();
            $categories = $this->categoryModel->getAllCate();
            $payments = $this->orderModel->getAllPayments();

            $orders = $this->orderModel->getOrdersByUserId($user_id);
            usort($orders, function($a, $b) {
                return strtotime($b['order_date']) - strtotime($a['order_date']);
            });

            $orderDetails = [];
            foreach ($orders as $order) {
                $order_id = $order['order_id'];
                $orderDetail = $this->orderModel->getOrderDetailByOrderId($order_id);
                $orderDetails[$order_id] = $orderDetail;
            }

            $bookIds = array_unique(array_merge(...array_map(function ($details) {
                return array_column($details, 'book_id');
            }, $orderDetails)));

            $books = $this->bookModel->getBooksByIds($bookIds);
            $booksById = [];
            foreach ($books as $book) {
                $booksById[$book['book_id']] = $book;
            }

          

            require_once('app/view/order/ViewOrder.php');
        } else {
            echo "<script>
                        alert('Please login to view order');
                        setTimeout(() => {
                            window.location.href = 'index.php?route=user&subroute=signin';
                        }, 1000);
                      </script>";
        }
    }
}

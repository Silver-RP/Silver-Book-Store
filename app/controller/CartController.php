<?php
    class CartController{
        private $cartModel;
        private $authorModel;
        private $categoryModel;
        public function __construct(){
            $this->cartModel = new CartModel();
            $this->authorModel = new AuthorModel();
            $this->categoryModel = new CategoryModel();
        }

        public function addCart() {
            session_start();
            header('Content-Type: application/json');
        
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookId = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;
                $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
        
                if (!isset($_SESSION['user']['user_id'])) {
                    echo json_encode(['status' => 'error', 'message' => 'Please login to add to cart']);
                    exit;
                }
                if ($quantity < 1) {
                    echo json_encode(['status' => 'error', 'message' => 'Invalid input quantity.']);
                    exit;
                }
                $userId = $_SESSION['user']['user_id'];
                $result = $this->cartModel->add($userId, $bookId, $quantity);
                $books = $this->cartModel->getBooksFromCart($userId);
                $count = count($books);
                $_SESSION['cart'] = $count > 0 ? $count : 0;
                if ($result) {
                    echo json_encode(['status' => 'success', 'message' => 'Book added to cart', 'cart' => $_SESSION['cart']]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to add book to cart']);
                }
                exit;
            }
        }

        public function viewBooksInCart(){
            session_start();
            $userId = $_SESSION['user']['user_id'];
            $books = $this->cartModel->getBooksFromCart($userId);
            $authors = $this->authorModel->getAllAuthors();
            $categories = $this->categoryModel->getAllCate();
            $count = count($books);
            $_SESSION['cart'] = $count > 0 ? $count : 0;
            require_once('app/view/books/ShowBooksInCart.php');
        }

        public function updateQuantityBookInCart(){
            header('Content-Type: application/json');
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookId = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;
                $newQuantity = isset($_POST['newquantity']) ? intval($_POST['newquantity']) : 1;
        
                $userId = $_SESSION['user']['user_id'];
                $result = $this->cartModel->updateQuantity($userId, $bookId, $newQuantity);

                if ($result) {
                    $booksInCart = $this->cartModel->getBooksFromCart($userId);
                    $subtotal = 0;
                    $totalBooks = 0;
                    foreach($booksInCart as $book){
                        $subtotal += $book['book_price'] * $book['quantity'];
                        $totalBooks += $book['quantity'];
                    }
                    $book = $this->cartModel->getBookById($bookId);
                    $newPrice = $book['book_price'] * $newQuantity;

                    echo json_encode([
                        'status' => 'success', 
                        'message' => 'Book quantity updated',
                        'newPrice' => $newPrice,
                        'subtotal' => $subtotal,
                        'totalBooks' => $totalBooks
                    ]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to update book quantity']);
                }
                exit;
            }
        }

        public function removeBookFromCart() {
            header('Content-Type: application/json');
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $bookId = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;
                $userId = $_SESSION['user']['user_id'];
        
                $result = $this->cartModel->removeCart($userId, $bookId);
                $books = $this->cartModel->getBooksFromCart($userId);
                $count = count($books);
                $_SESSION['cart'] = $count > 0 ? $count : 0;
                if ($result) {
                    $cartItems = $this->cartModel->getBooksFromCart($userId);
                    $subtotal = 0;
                    $totalBooks = 0;
                    foreach ($cartItems as $item) {
                        $subtotal += $item['book_price'] * $item['quantity'];
                        $totalBooks += $item['quantity'];
                    }
                    echo json_encode([
                        'status' => 'success',
                        'subtotal' => $subtotal,
                        'totalBooks' => $totalBooks,
                        'cart' => $_SESSION['cart']
                    ]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to remove book from cart']);
                }
                exit;
            }
        }

        public function removeAllCart(){
            session_start();
            $userId = $_SESSION['user']['user_id'];
            $result = $this->cartModel->removeAllCart($userId);
            if ($result) {
                $_SESSION['cart'] = 0;
                echo json_encode(['success' => true, 'message' => 'All books removed from cart']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to remove all books from cart']);
            }
            exit;
        }

        public function removeBookFromCartPage(){
            session_start();
            $userId = $_SESSION['user']['user_id'];
            $result = $this->cartModel->removeAllCart($userId);
            if ($result) {
                $_SESSION['cart'] = 0;
                echo json_encode(['success' => true, 'message' => 'All books removed from cart']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to remove all books from cart']);
            }
        }

        public function getAllItems() {
            header('Content-Type: application/json');
            session_start(); 
        
            $userId = $_SESSION['user']['user_id'];
            $items = $this->cartModel->getBooksFromCart($userId);
        
            $response = [
                'books' => array_map(function($item) {
                    return ['book_id' => $item['book_id']];
                }, $items)
            ];
        
            echo json_encode($response);
            exit();
        }
        
    }

?>

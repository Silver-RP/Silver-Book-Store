<?php
class WishListController {
    private $wishListModel;
    public function __construct() {
        $this->wishListModel = new WishListModel();
    }

    public function addWish() {
        header('Content-Type: application/json');
        // error_reporting(E_ALL);
        // ini_set('display_errors', 1);

        if (!isset($_SESSION['user']['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Please login to add to wishlist']);
            exit();
        }
        $userId = $_SESSION['user']['user_id'];
        $bookId = $_POST['book_id'];
        $existing = $this->wishListModel->checkIfExists($userId, $bookId);
    if ($existing) {
        echo json_encode(['success' => false, 'message' => 'Book already in wishlist']);
        return;
    }
        if (isset($_POST['book_id'])) {
            $userId = $_SESSION['user']['user_id'];
            $bookId = $_POST['book_id'];
            $result = $this->wishListModel->addToWishList($userId, $bookId);
            echo json_encode(['success' => $result]);
            exit();
        }
        echo json_encode(['success' => false, 'message' => 'Book ID not provided']);
        exit();
    }
    public function view(){
        if(isset($_SESSION['user']['user_id'])){
            $wishList = $this->wishListModel->getWishList($_SESSION['user']['user_id']);
        }else{
            $wishList = [];
        }
        require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/app/view/books/wishBooks.php');
    }
    public function addAllWish() {
        header('Content-Type: application/json');
        session_start(); 
    
        $userId = $_SESSION['user']['user_id'];
        $input = json_decode(file_get_contents('php://input'), true);
    
        if (!isset($input['books']) || !is_array($input['books'])) {
            echo json_encode(['success' => false, 'message' => 'No books provided or incorrect format']);
            exit();
        }
    
        $books = $input['books'];
        $result = true;
        $addResult = 0;
        $bResult = 0;
        $bookids = [];
    
        foreach ($books as $book) {
            if (!isset($book['book_id'])) {
                continue;
            }
    
            $bookId = $book['book_id'];
            $bookids[] = $bookId;
    
            $existing = $this->wishListModel->checkIfExists($userId, $bookId);
            if ($existing) {
                continue;
            }
    
            $addResult = $this->wishListModel->addAllToWishList($userId, $bookId);
            if (!$addResult) {
                $result = false;
            }
        }
    
        echo json_encode([
            'success' => $result,
            'message' => $result ? 'Books added to wishlist' : 'Failed to add some books to wishlist',
            'addResult' => $addResult,
            'bResult' => $bResult,
            'bookids' => $bookids
        ]);
        exit();
    }
    
    
    
    public function removeWish() {
        header('Content-Type: application/json');
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        if (!isset($_SESSION['user']['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Please login to remove from wishlist']);
            exit();
        }
        if (isset($_POST['book_id'])) {
            $userId = $_SESSION['user']['user_id'];
            $bookId = $_POST['book_id'];
            $result = $this->wishListModel->removeFromWishList($userId, $bookId);
            echo json_encode(['success' => $result]);
            exit();
        }
        echo json_encode(['success' => false, 'message' => 'Book ID not provided']);
        exit();
    }
    public function removeWishFromWishPage() {
        header('Content-Type: application/json');
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    
        if (!isset($_SESSION['user']['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Please login to remove from wishlist']);
            exit();
        }
    
        $input = json_decode(file_get_contents('php://input'), true);
        if (isset($input['book_id'])) { 
            $userId = $_SESSION['user']['user_id'];
            $bookId = $input['book_id']; 
            $result = $this->wishListModel->removeFromWishList($userId, $bookId);
            echo json_encode(['success' => $result]);
            exit();
        }
    
        echo json_encode(['success' => false, 'message' => 'Book ID not provided']);
        exit();
    }

}

?>

<?php
require_once('BASE_PATH' . '/../config/config.php');
    class BookController{
        private $bookModel;
        private $bookCateModel;
        private $bookAuthorModel;
        private $bookPublisherModel;
        private $wishListModel;
        public function __construct(){
            $this->bookModel = new BookModel();
            $this->bookCateModel = new CategoryModel();
            $this->bookAuthorModel = new AuthorModel();
            $this->bookPublisherModel = new PublisherModel();
            $this->wishListModel = new WishListModel();
        }

        public function showAllBooks(){
            $this->index();
        }

        public function index() {
            $limit = 30;
            $limit1 = 8;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;
            $offset1 = 1;

            $sortOrder = isset($_GET['sort']) ? $_GET['sort'] : null; 

            try {
                $totalBooks = $this->bookModel->countAllBooks();
                $totalPages = ceil($totalBooks / $limit);
                $booksForPage = $this->bookModel->getAllBooks($limit1, $offset1, $sortOrder);
                $books = $this->bookModel->getAllBooks($limit, $offset, $sortOrder);
                $bookCate = $this->bookCateModel->getAllCate();
                $bookAuthor = $this->bookAuthorModel->getAllAuthors();
                if(isset($_SESSION['user']['user_id'])){
                    $wishList = $this->wishListModel->getBooksWishWithStatus($_SESSION['user']['user_id']);
                }else{
                    $wishList = [];
                }
                // Create a dictionary for quick lookups
                $wishDict = [];
                foreach ($wishList as $wish) {
                    $wishDict[$wish['book_id']] = $wish;
                }
                // require_once(BASE_PATH.'/app/view/books/showAllBooks.php');
                require_once('/usr/local/var/www/Silver-Book-Store/app/view/books/showAllBooks.php');
            } catch (Exception $e) {
                echo "Error fetching data: " . $e->getMessage();
            }
        }
    
        public function detailBook() {
            session_start(); 
            
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            if (!$id) {
                echo "Invalid book ID.";
                return;
            }
        
            $book = $this->bookModel->getBookById($id);
            if (!$book) {
                echo "Book not found.";
                return;
            }
            $bookCate = $this->bookCateModel->getCategoryById($book['cate_id']);
            if (!$bookCate) {
                $bookCate = [];
            }
            $bookAuthor = $this->bookAuthorModel->getAuthorById($book['author_id']);
            if (!$bookAuthor) {
                $bookAuthor = [];
            }
            $bookPublisher = $this->bookPublisherModel->getPublisherById($book['publisher_id']);
            if (!$bookPublisher) {
                $bookPublisher = [];
            }
            $booksSameCategory = $this->bookModel->getBooksByCateId($book['cate_id']);
            if (!$booksSameCategory) {
                $booksSameCategory = [];
            }
            if (isset($_SESSION['user']['user_id'])) {
                $wishList = $this->wishListModel->getBooksWishWithStatus($_SESSION['user']['user_id']);
            } else {
                $wishList = [];
            }
            $wishDict = [];
            foreach ($wishList as $wish) {
                $wishDict[$wish['book_id']] = $wish;
            }
            require_once(BASE_PATH.'app/view/books/detailBook.php');
        }
        
        public function reviewBook() {
            header('Content-Type: application/json');
            session_start();

            $data = json_decode(file_get_contents('php://input'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
                exit();
            }
            // Check if user is logged in and redirect to book detail page if not
            if (!isset($_SESSION['user']['user_id'])) {
                $id = isset($data['book_id']) ? intval($data['book_id']) : null; 
                if ($id) {
                    $_SESSION['redirect'] = '?route=books&subroute=detail&id=' . $id;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Invalid book ID']);
                    exit();
                }
        
                echo json_encode(['success' => false, 'message' => 'You must login to review']);
                exit();
            }
        
            $user_id = $_SESSION['user']['user_id'];
            $book_id = isset($data['book_id']) ? intval($data['book_id']) : 0;
            $comment = isset($data['comment']) ? trim($data['comment']) : '';
            $rating = isset($data['rating']) ? intval($data['rating']) : 0;
        
            if (empty($comment)) {
                echo json_encode(['success' => false, 'message' => 'Comment is required']);
                exit();
            }
            if ($rating < 1 || $rating > 5) {
                echo json_encode(['success' => false, 'message' => 'Rating must be between 1 and 5']);
                exit();
            }
            if ($book_id <= 0) {
                echo json_encode(['success' => false, 'message' => 'Invalid book ID']);
                exit();
            }
        
            $result = $this->bookModel->addReview($book_id, $user_id, $comment, $rating);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Review added successfully']);
            } else {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Failed to add review', 
                    'result' => $result,
                    'data' => $data,
                    'user_id' => $user_id,
                    'book_id' => $book_id,
                    'comment' => $comment,
                    'rating' => $rating
                ]);
            }
        }
        
        
        public function getBookReviews() {
            header('Content-Type: application/json');
            try {
                $book_id = $_GET['book_id'];
                if (empty($book_id) || !is_numeric($book_id)) {
                    echo json_encode(['success' => false, 'message' => 'Invalid book ID']);
                    exit();
                }
                $comments = $this->bookModel->getBookComments($book_id);
                if (empty($comments)) {
                    echo json_encode(['success' => false, 'message' => 'No reviews found']);
                    exit();
                }
                echo json_encode(['success' => true, 'data' => $comments]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Failed to get reviews']);
            }
        }
        
        
        
        
    }
?>
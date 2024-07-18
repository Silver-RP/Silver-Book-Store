<?php
// require_once('../../../model/BookModel.php');
require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/model/BookModel.php');
require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/model/CategoryModel.php');
require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/model/AuthorModel.php');
require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/model/PublisherModel.php');

class BookController
{
    private $bookModel;
    private $bookCateModel;
    private $bookAuthorModel;
    private $bookPublisherModel;
    public function __construct(){
        $this->bookModel = new BookModel();
        $this->bookCateModel = new CategoryModel();
        $this->bookAuthorModel = new AuthorModel();
        $this->bookPublisherModel = new PublisherModel();
    }
    public function index(){
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        try {
            $totalBooks = $this->bookModel->countAllBooks();
            $totalPages = ceil($totalBooks / $limit);
            $books = $this->bookModel->getAllBooks($limit, $offset);
            $bookCate = $this->bookCateModel->getAllCate();
            require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/view/books/allBooks.php');
        } catch (Exception $e) {
            echo "Error fetching data: " . $e->getMessage();
        }
    }
    public function viewBookDetail(){
        if (!isset($_GET['id'])) {
            die('Book ID not provided.');
        }
        $id = $_GET['id'];
        $book = $this->bookModel->getBookById($id);
        $author = $this->bookAuthorModel->getAuthorById($book['author_id']);
        $publisher = $this->bookPublisherModel->getPublisherById($book['publisher_id']);
        $cate = $this->bookCateModel->getCategoryById($book['cate_id']);
        if (!$book) {
            echo "Book not found";
            return;
        }
        require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/view/books/books_crud/viewDetailBook.php');
    }
    public function add(){
        $cates = $this->bookCateModel->getAllCate();
        $authors = $this->bookAuthorModel->getAllAuthors();
        $publishers = $this->bookPublisherModel->getAllPublishers();

        usort($cates, function ($a, $b) {
            return strcmp($a['cate_name'], $b['cate_name']);
        });
        usort($authors, function ($a, $b) {
            return strcmp($a['author_name'], $b['author_name']);
        });
        usort($publishers, function ($a, $b) {
            return strcmp($a['publisher_name'], $b['publisher_name']);
        });

        require_once('view/books/books_crud/addBook.php');
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bookName = $_POST['book_name'];
            $bookTitle = $_POST['book_title'];
            $bookDescription = $_POST['book_description'];
            $bookYearOfPublication = $_POST['book_year_of_publication'];
            $bookPrice = $_POST['book_price'];
            $bookDateOfStorage = $_POST['book_date_of_storage'];
            $bookStockQuantity = $_POST['book_stock_quantity'];
            $cateId = $_POST['cate_id'];
            $authorId = $_POST['author_id'];
            $publisherId = $_POST['publisher_id'];

            $bookImage = '';
            if (isset($_FILES['book_image']) && $_FILES['book_image']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['book_image']['tmp_name'];
                $fileName = $_FILES['book_image']['name'];
                $fileSize = $_FILES['book_image']['size'];
                $fileType = $_FILES['book_image']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                // $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

                $uploadFileDir = '/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/public/images/book_name/';
                $destPath = $uploadFileDir . $fileName;

                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0777, true);
                }

                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $bookImage = $fileName;
                } else {
                    $message = 'There was some error moving the file to the upload directory. Please make sure the upload directory is writable by web server.';
                    echo $message;
                    exit;
                }
            }

            $this->bookModel->addBook(
                $bookName,
                $bookTitle,
                $bookImage,
                $bookDescription,
                $bookYearOfPublication,
                $bookPrice,
                $bookDateOfStorage,
                $bookStockQuantity,
                $cateId,
                $authorId,
                $publisherId
            );

            echo "<script>
                alert('Book added successfully!');
                window.location.href = '?act=books&action=index';
              </script>";
            exit;
        }
    }
    public function edit()
    {
        $id = $_GET['id'];
        $page = $_GET['page'];
        $book = $this->bookModel->getBookById($id);
        $categories = $this->bookCateModel->getAllCate();
        $authors = $this->bookAuthorModel->getAllAuthors();
        $publishers = $this->bookPublisherModel->getAllPublishers();
        require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/view/books/books_crud/editBook.php');
    }
    public function update() {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
    
        $id = $_POST['book_id'];
        $book_name = $_POST['book_name'];
        $book_title = $_POST['book_title'];
        $book_description = $_POST['book_description'];
        $book_year_of_publication = $_POST['book_year_of_publication'];
        $book_price = $_POST['book_price'];
        $book_date_of_storage = $_POST['book_date_of_storage'];
        $book_stock_quantity = $_POST['book_stock_quantity'];
        $cate_id = $_POST['cate_id'];
        $author_id = $_POST['author_id'];
        $publisher_id = $_POST['publisher_id'];
    
        if ($_FILES['book_image']['name']) {
            $uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/public/images/book_name/'; 
            $uploadFile = $uploadDir . basename($_FILES['book_image']['name']);
    
            if (move_uploaded_file($_FILES['book_image']['tmp_name'], $uploadFile)) {
                $book_image = $_FILES['book_image']['name'];
            } else {
                echo "<script>alert('Failed to upload book image.');
                      window.location.href = '?act=books&action=index&page=$page';</script>";
                return;
            }
        } else {
            $book_image = $_POST['current_image'];
        }
    
        $result = $this->bookModel->updateBook(
            $id, $book_name, $book_title, $book_image, $book_description, $book_year_of_publication, 
            $book_price, $book_date_of_storage, $book_stock_quantity, $cate_id, $author_id, $publisher_id
        );
    
        if ($result) {
            echo "<script>alert('Book updated successfully!');
                  window.location.href = '?act=books&action=index&page=$page';</script>";
        } else {
            echo "<script>alert('Failed to update book.');
                  window.location.href = '?act=books&action=index&page=$page';</script>";
        }
    }
    public function delete()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        if ($id) {
            echo "<script>
                    if(confirm('Are you sure you want to delete this book?')){
                        window.location.href = '?act=books&action=confirmDelete&page=$page&id=$id';
                    } else {
                        window.location.href = '?act=books&action=index&page=$page';
                    }
                  </script>";
        } else {
            echo "<script>alert('Invalid book ID');</script>";
        }
    }
    public function confirmDelete()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        if ($id) {
            $result = $this->bookModel->deleteBook($id);
            if ($result) {
                echo "<script>
                    alert('Book deleted successfully!');
                    window.location.href = '?act=books&action=index&page=$page';
                  </script>";
            } else {
                echo "<script>
                    alert('Failed to delete book.');
                    window.location.href = '?act=books&action=index&page=$page';
                  </script>";
            }
        } else {
            echo "<script>
                alert('Invalid book ID');
                window.location.href = '?act=books&action=index&page=$page';
              </script>";
        }
    }

}


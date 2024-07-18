<?php
    require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/model/AuthorModel.php');

    class AuthorController{
        private $authorModel;
        public function __construct(){
            $this->authorModel = new AuthorModel();
        }
        public function index(){
            $limit = 10; 
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;
            try {
                $totalAuthors = $this->authorModel->countAllAuthors();
                $totalPages = ceil($totalAuthors / $limit);
                $authors = $this->authorModel->index($limit, $offset);
                require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/view/books/allAuthors.php');
            } catch (Exception $e) {
                // Handle exceptions, log errors, or show a friendly error message
                echo "Error fetching data: " . $e->getMessage();
            }
        }
        public function add(){
            require_once('view/books/cate_author_publish_crud/addAuthor.php');
        }
        public function store(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $author_name = $_POST['author_name'];
                $author_phone = $_POST['author_phone'];
                $author_email = $_POST['author_email'];
                $author_address = $_POST['author_address'];
                $author_note = $_POST['author_note'];
                $this->authorModel->addAuthor($author_name, $author_phone, $author_email, $author_address, $author_note);

                echo "<script>alert('Add author successfully!')
                window.location.replace('index.php?act=authors&action=index');
                </script>";
                exit();
            }
            
        }
        public function edit(){
            $id = $_GET['id'];
            $author = $this->authorModel->getAuthorById($id);
            require_once('view/books/cate_author_publish_crud/editAuthor.php');
        }
        public function update(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $id = $_POST['author_id'];
                $author_name = $_POST['author_name'];
                $author_phone = $_POST['author_phone'];
                $author_email = $_POST['author_email'];
                $author_address = $_POST['author_address'];
                $author_note = $_POST['author_note'];
                $this->authorModel->updateAuthor($id, $author_name, $author_phone, $author_email, $author_address, $author_note);
                
                // echo $author_name;
                echo "<script>alert('Update author successfully!')
                window.location.replace('index.php?act=authors&action=index');
                </script>";
                exit();
            }
        }
        public function delete(){
            $id = $_GET['id'];
            $author = $this->authorModel->getAuthorById($id);
            if(!$author){
                echo "<script>alert('Author not found!')
                window.location.replace('index.php?act=authors&action=index');
                </script>";
                exit();
            }
            $authors = $this->authorModel->getBooksByAuthorId($id);
            if(count($authors)>0){
                echo "<script>alert('Author has associated books, cannot delete!')
                    window.location.replace('index.php?act=authors&action=index');
                </script>";
                exit();
            }
            echo "<script>
                var confirmDelete = confirm('Are you sure you want to delete this author?');
                if(confirmDelete){
                    window.location.replace('index.php?act=authors&action=confirmDelete&id=$id');
                }else{
                    window.location.replace('index.php?act=authors&action=index');
                }
                </script>";
            exit();
        }
        public function confirmDelete(){
            $id = $_GET['id'];
            $this->authorModel->deleteAuthor($id);
            echo "<script>alert('Delete author successfully!')
            window.location.replace('index.php?act=authors&action=index');
            </script>";
            exit();
        }
    }
?>
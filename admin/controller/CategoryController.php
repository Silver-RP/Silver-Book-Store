<?php
    require_once(BASE_PATH.'admin/model/CategoryModel.php');
    class CategoryController{
        private $categoryModel;
        public function __construct(){
            $this->categoryModel = new CategoryModel();
        }
        public function index() {
            $limit = 10; // Number of records per page
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;
            try {
                $totalCategories = $this->categoryModel->countAllCategories();
                $totalPages = ceil($totalCategories / $limit);
                $categories = $this->categoryModel->index($limit, $offset);
                require_once(BASE_PATH.'admin/view/books/allCategories.php');
            } catch (Exception $e) {
                echo "Error fetching data: " . $e->getMessage();
            }
        }
        public function add(){
            require_once('view/books/cate_author_publish_crud/addCategory.php');
        }
        public function store() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $cate_name = trim($_POST['cate_name']);
                $cate_description = trim($_POST['cate_description']);
                $cate_note = trim($_POST['cate_note']);
                
                $cate_image = '';
        
                if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] === UPLOAD_ERR_OK) {
                    $fileTempName = $_FILES['category_image']['tmp_name'];
                    $fileName = $_FILES['category_image']['name'];
                    $fileSize = $_FILES['category_image']['size'];
                    $fileType = $_FILES['category_image']['type'];
                    $fileNameCmps = explode(".", $fileName);
                    $fileExtension = strtolower(end($fileNameCmps));
                    
                    $uploadFileDir = BASE_PATH.'public/images/categories/';
                    $destPath = $uploadFileDir . $fileName;
                    
                    if (!is_dir($uploadFileDir)) {
                        mkdir($uploadFileDir, 0777, true);
                    }
                    
                    if (file_exists($destPath)) {
                        $fileName = time() . "_" . $fileName; 
                        $destPath = $uploadFileDir . $fileName;
                    }
                    
                    if (move_uploaded_file($fileTempName, $destPath)) {
                        $cate_image = $fileName;
                    } else {
                        echo "Error uploading image";
                        exit;
                    }
                }

                $this->categoryModel->addCategory($cate_name, $cate_description, $cate_note, $cate_image);
                
                echo "<script>alert('Category added successfully!');
                    window.location.href = '?act=categories&action=index';
                </script>";
                exit;
            }
        }
        public function edit(){
            $id = $_GET['id'];
            $category = $this->categoryModel->getCategoryById($id);
            require_once('view/books/cate_author_publish_crud/editCategory.php');
        }
        public function update(){
           if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $cate_id = $_POST['cate_id'];
                $cate_name = $_POST['cate_name'];
                $cate_description = $_POST['cate_description'];
                $cate_note = $_POST['cate_note'];
                $cate_image = '';
                
                if (isset($_FILES['cate_image']) && $_FILES['cate_image']['error'] === UPLOAD_ERR_OK) {
                    $fileTempName = $_FILES['cate_image']['tmp_name'];
                    $fileName = $_FILES['cate_image']['name'];
                    $fileSize = $_FILES['cate_image']['size'];
                    $fileType = $_FILES['cate_image']['type'];
                    $fileNameCmps = explode(".", $fileName);
                    $fileExtension = strtolower(end($fileNameCmps));
                    
                    $uploadFileDir = BASE_PATH.'public/images/categories/';
                    $destPath = $uploadFileDir . $fileName;
                    
                    if (!is_dir($uploadFileDir)) {
                        mkdir($uploadFileDir, 0777, true);
                    }
                    
                    if (file_exists($destPath)) {
                        $fileName = time() . "_" . $fileName; 
                        $destPath = $uploadFileDir . $fileName;
                    }
                    
                    if (move_uploaded_file($fileTempName, $destPath)) {
                        $cate_image = $fileName;
                    } else {
                        echo "Error uploading image";
                        exit;
                    }
                }
                $this->categoryModel->updateCategory($cate_id, $cate_name, $cate_description, $cate_note, $cate_image);
                
                echo "<script>alert('Update category successfully!')
                window.location.replace('index.php?act=categories&action=index');
                </script>";
                exit();
            }
        }
        public function delete() {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $cate_id = $_GET['id'];
                
                $category = $this->categoryModel->getCategoryById($cate_id);
                if (!$category) {
                    echo "<script>
                        alert('Category not found!');
                        window.location.href = '?act=categories&action=index';
                    </script>";
                    exit();
                }
        
                $books = $this->categoryModel->getBooksByCategoryId($cate_id);
                if (count($books) > 0) {
                    echo "<script>
                        if (confirm('Category has books, cannot delete this category! Do you want to update category to null for all books in this category and delete this category?')) {
                            window.location.href = '?act=categories&action=updateBooksAndDelete&id=$cate_id';
                        } else {
                            window.location.href = '?act=categories&action=index';
                        }
                    </script>";
                    exit();
                } else {
                    echo "<script>
                        if (confirm('Are you sure you want to delete this category?')) {
                            window.location.href = '?act=categories&action=confirmDelete&id=$cate_id';
                        } else {
                            window.location.href = '?act=categories&action=index';
                        }
                    </script>";
                    exit();
                }
            }
        }
        //Can not update because setting database schema is allow not null for cate_id in book table
        public function updateBooksAndDelete() {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $cate_id = $_GET['id'];
                $books = $this->categoryModel->getBooksByCategoryId($cate_id);
                
                foreach ($books as $book) {
                    $this->categoryModel->updateCategoryForBook($book['book_id']);
                }
                $this->categoryModel->deleteCategory($cate_id);
                // echo "<script>
                //     alert('Category and its books updated and deleted successfully!');
                //     window.location.href = '?act=categories&action=index';
                // </script>";
                echo "<script>
                alert('Sorry, CANNOT UPDATE books where category is null because the database schema DOES NOT ALLOW \"NULL\" values for cate_id in the book table.');
                    window.location.href = '?act=categories&action=index';
                </script>";
                exit();
            }
            
        }
        
        public function confirmDelete(){
            $id = $_GET['id'];
            $this->categoryModel->deleteCategory($id);
            echo "<script>alert('Category deleted successfully!');
            window.location.href = '?act=categories&action=index';
            </script>";
            exit();
        }
    }
?>
<?php
        require_once(BASE_PATH.'admin/model/PublisherModel.php');

        class PublisherController{
            private $publisherModel;
            public function __construct(){
                $this->publisherModel = new PublisherModel();
            }
            public function index(){
                $limit = 10; 
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $limit;
                try {
                    $totalPublishers = $this->publisherModel->countAllPublishers();
                    $totalPages = ceil($totalPublishers / $limit);
                    $publishers = $this->publisherModel->index($limit, $offset);
                    require_once(BASE_PATH.'admin/view/books/allPublishers.php');
                } catch (Exception $e) {
                    echo "Error fetching data: " . $e->getMessage();
                }
            }
            public function add(){
                require_once('view/books/cate_author_publish_crud/addPublisher.php');
            }
            public function store(){
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $publisher_name = $_POST['publisher_name'];
                    $publisher_address = $_POST['publisher_address'];
                    $publisher_phone = $_POST['publisher_phone'];
                    $publisher_email = $_POST['publisher_email'];
                    $publisher_url = $_POST['publisher_url'];
                    $this->publisherModel->addPublisher($publisher_name, $publisher_address, $publisher_phone, $publisher_email, $publisher_url);
    
                    echo "<script>alert('Add publisher successfully!')
                    window.location.replace('index.php?act=publishers&action=index');
                    </script>";
                    exit();
                }
            }
            public function edit(){
                $id = $_GET['id'];
                $publisher = $this->publisherModel->getPublisherById($id);
                require_once('view/books/cate_author_publish_crud/editPublisher.php');
            }
            public function update(){
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $id = $_POST['publisher_id'];
                    $publisher_name = $_POST['publisher_name'];
                    $publisher_address = $_POST['publisher_address'];
                    $publisher_phone = $_POST['publisher_phone'];
                    $publisher_email = $_POST['publisher_email'];
                    $publisher_url = $_POST['publisher_url'];
                   
                    $this->publisherModel->updatePublisher($publisher_name, $publisher_address, $publisher_phone, $publisher_email, $publisher_url, $id);
                    echo "<script>alert('Update publisher successfully!')
                    window.location.replace('index.php?act=publishers&action=index');
                    </script>";
                }
            }
            public function delete(){
                $id = $_GET['id'];
                $pub = $this->publisherModel->getPublisherById($id);
                if(!$pub){
                    echo "<script>alert('Publisher not found!')
                    window.location.replace('index.php?act=publishers&action=index');
                    </script>";
                    exit();
                }
                $pubs = $this->publisherModel->getBooksByPublisherId($id);
                if(count($pubs) > 0){
                    echo "<script>
                    if(confirm('Publisher has books. Can not delete!')){
                    window.location.replace('index.php?act=publishers&action=index')
                }else{
                    window.location.replace('index.php?act=publishers&action=index')
                };
                    </script>";
                    exit();
                }
                echo "<script>
                    if(confirm('Are you sure you want to delete this publisher?')){
                        window.location.replace('index.php?act=publishers&action=confirmDelete&id=$id');
                    }else{
                        window.location.replace('index.php?act=publishers&action=index');
                    }
                    </script>";
                    exit();
            }
            public function confirmDelete(){
                $id = $_GET['id'];
                $this->publisherModel->deletePublisher($id);
                echo "<script>alert('Delete publisher successfully!')
                window.location.replace('index.php?act=publishers&action=index');
                </script>";
                exit();
            }
        }


?>
<?php
require_once(BASE_PATH.'admin/model/CommentModel.php');

class CommentController
{
    private $commentModel;
    public function __construct()
    {
        $this->commentModel = new CommentModel();
    }
    public function index(){
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 15;
        $offset = ($page - 1) * $limit;
        $reviews = $this->commentModel->getAllReviews($limit, $offset);
        $totalComments = $this->commentModel->countAllReviews();
        $totalPages = ceil($totalComments / $limit);
        require_once(BASE_PATH.'admin/view/comments/AllComments.php');
    }
    public function show() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        header('Content-Type: application/json');
        if ($this->commentModel->setStatus($id)) {
            echo json_encode(['status' => 'success', 'action' => 'show']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }
    
    public function hide() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        header('Content-Type: application/json');
        if ($this->commentModel->setStatusHide($id)) {
            echo json_encode(['status' => 'success', 'action' => 'hide']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }
    
    public function allHide() {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 15;
        $offset = ($page - 1) * $limit;
        $reviews = $this->commentModel->getHiddenReviews($limit, $offset);
        $totalComments = $this->commentModel->countHiddenReviews();
        $totalPages = ceil($totalComments / $limit);
        require_once(BASE_PATH.'admin/view/comments/HideComments.php');
    }


    public function delete()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        if ($id) {
            echo "<script>
                    if(confirm('Are you sure you want to delete this book?')){
                        window.location.href = '?act=reviews&action=confirmDelete&page=$page&id=$id';
                    } else {
                        window.location.href = '?act=reviews&action=index&page=$page';
                    }
                  </script>";
        } else {
            echo "<script>alert('Invalid book ID');</script>";
        }
    }
    public function confirmDelete(){
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        if ($id) {
            if ($this->commentModel->deleteComment($id)) {
                echo "<script>alert('Review deleted successfully!');
                      window.location.href = '?act=reviews&action=index&page=$page';</script>";
            } else {
                echo "<script>alert('Failed to delete review.');
                      window.location.href = '?act=reviews&action=index&page=$page';</script>";
            }
        } else {
            echo "<script>alert('Invalid review ID');</script>";
        }
    }
}

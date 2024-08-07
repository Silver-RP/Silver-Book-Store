<?php
    class CategoryModel{
        private $db;
        public function __construct(){
            $this->db = new Database();
        }
        public function index($limit, $offset) {
            try {
                $sql = "SELECT * FROM category LIMIT " . $limit . " OFFSET " . $offset;
                $stmt = $this->db->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Query failed: " . $e->getMessage();
                return []; // or handle error as needed
            }
        }
        public function getAllCate() {
            try {
                $sql = "SELECT * FROM category";
                $stmt = $this->db->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Query failed: " . $e->getMessage();
                return []; // or handle error as needed
            }
        }
        public function getCategoryById($id){
            $sql = "SELECT * FROM category WHERE cate_id = ?";
            return $this->db->getOne($sql, [$id]);
        }
        public function addCategory($cate_name, $cate_description, $cate_note, $cate_image) {
            $sql = "INSERT INTO category (cate_name, cate_description, cate_image, cate_note) VALUES (?, ?, ?, ?)";
            return $this->db->insert($sql, [$cate_name, $cate_description, $cate_image, $cate_note]);
        }
        public function updateCategory($id, $cate_name, $cate_description, $cate_note, $cate_image) {
            $sql = "UPDATE category SET cate_name = ?, cate_description = ?, cate_image = ?, cate_note = ? WHERE cate_id = ?";
            return $this->db->update ($sql, [$cate_name, $cate_description, $cate_image, $cate_note, $id]);
        }
        public function deleteCategory($id){
            $sql = "DELETE FROM category WHERE cate_id = ?";
            return $this->db->delete($sql, [$id]);
        }
        public function getBooksByCategoryId($id){
            $sql = "SELECT * FROM book WHERE cate_id = ?";
            return $this->db->getAll($sql, [$id]);
        }
        public function updateCategoryForBook($id){
            $sql = "UPDATE book SET cate_id = NULL WHERE book_id = ?";
            return $this->db->update($sql, [$id]);
        }
        public function countAllCategories(){
            $sql = "SELECT COUNT(*) FROM category";
            return $this->db->count($sql);
        }
    }
?>
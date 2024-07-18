<?php
    require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/config/database.php');
    class PublisherModel{

        private $db;
        public function __construct(){
            $this->db = new Database();
        }
        public function index($limit, $offset) {
            try {
                $sql = "SELECT * FROM publisher LIMIT " . $limit . " OFFSET " . $offset;
                $stmt = $this->db->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Query failed: " . $e->getMessage();
                return []; // or handle error as needed
            }
        }
        public function getAllPublishers() {
            try {
                $sql = "SELECT * FROM publisher";
                $stmt = $this->db->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Query failed: " . $e->getMessage();
                return []; // or handle error as needed
            }
        }
        public function getPublisherById($id){
            $sql = "SELECT * FROM publisher WHERE publisher_id = ?";
            return $this->db->getOne($sql, [$id]);
        }
        public function addPublisher($publisher_name, $publisher_address, $publisher_phone, $publisher_email, $publisher_url){ 
            $sql = "INSERT INTO publisher (publisher_name, publisher_address, publisher_phone, publisher_email, publisher_url) VALUES (?, ?, ?, ?, ?)";
            return $this->db->insert ($sql, [$publisher_name, $publisher_address, $publisher_phone, $publisher_email, $publisher_url]);
        }
        public function updatePublisher($publisher_name, $publisher_address, $publisher_phone, $publisher_email, $publisher_url, $id){
            $sql = "UPDATE publisher SET publisher_name = ?, publisher_address = ?, publisher_phone = ?, publisher_email = ?, publisher_url = ? WHERE publisher_id = ?";
            return $this->db->update($sql, [$publisher_name, $publisher_address, $publisher_phone, $publisher_email, $publisher_url, $id]);
        }
        public function deletePublisher($id){
            $sql = "DELETE FROM publisher WHERE publisher_id = ?";
            return $this->db->delete($sql, [$id]);
        }
        public function getBooksByPublisherId($id){
            $sql = "SELECT * FROM book WHERE publisher_id = ?";
            return $this->db->getAll($sql, [$id]);
        }
        public function countAllPublishers(){
            $sql = "SELECT COUNT(*) FROM publisher";
            return $this->db->count($sql);
        }
    }
?>
<?php
    class AuthorModel{
        private $db;
        public function __construct(){
            $this->db = new Database();
        }
       
        
        public function index($limit, $offset) {
            try {
                $sql = "SELECT * FROM author LIMIT " . $limit . " OFFSET " . $offset;
                $stmt = $this->db->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Query failed: " . $e->getMessage();
                return []; // or handle error as needed
            }
        }
        public function getAllAuthors() {
            try {
                $sql = "SELECT * FROM author";
                $stmt = $this->db->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Query failed: " . $e->getMessage();
                return []; // or handle error as needed
            }
        }
        public function getAuthorById($author_id){
            $sql = "SELECT * FROM author WHERE author_id = ?";
            return $this->db->getOne($sql, [$author_id]);
        }
        public function addAuthor($author_name, $author_phone, $author_email, $author_address, $author_note){ 
            $sql = "INSERT INTO author (author_name, author_phone, author_email, author_address, author_note) VALUES (?, ?, ?, ?, ?)";
            return $this->db->insert ($sql, [$author_name, $author_phone, $author_email, $author_address, $author_note]);
        }
        public function updateAuthor($id, $author_name, $author_phone, $author_email, $author_address, $author_note) {
            $sql = "UPDATE author SET author_name = ?, author_phone = ?, author_email = ?, author_address = ?, author_note = ? WHERE author_id = ?";
            return $this->db->update ($sql, [$author_name, $author_phone, $author_email, $author_address, $author_note, $id]);
        }
        public function deleteAuthor($id){
            $sql = "DELETE FROM author WHERE author_id = ?";
            return $this->db->delete($sql, [$id]);
        }
        public function getBooksByAuthorId($author_id){
            $sql = "SELECT * FROM book WHERE author_id = ?";
            return $this->db->getAll($sql, [$author_id]);
        }
        public function countAllAuthors(){
            $sql = "SELECT COUNT(*) FROM author";
             return $this->db->count($sql);
         }
    }
?>
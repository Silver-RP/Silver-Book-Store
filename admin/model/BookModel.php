<?php
    // require_once('../../../config/database.php');
    require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/config/database.php');
    class BookModel{
        private $db;
        public function __construct(){
            $this->db = new Database();
        }
        public function getAllBooks($limit, $offset) {
            try {
                $sql = "SELECT * FROM book LIMIT " . $limit . " OFFSET " . $offset;
                $stmt = $this->db->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Query failed: " . $e->getMessage();
                return []; // or handle error as needed
            }
        }
        public function countAllBooks(){
            $sql = "SELECT COUNT(*) FROM book";
            return $this->db->count($sql);
        }
        public function getBookById($id){
            $sql = "SELECT * FROM book WHERE book_id = ?";
            return $this->db->getOne($sql, [$id]);
        }
        public function addBook($book_name, $book_title, $book_image, $book_description, $book_year_of_publication, 
                            $book_price, $book_date_of_storage, $book_stock_quantity, $cate_id, $author_id, $publisher_id) {
        $sql = "INSERT INTO book (book_name, book_title, book_image, book_description, book_year_of_publication, book_price, book_date_of_storage, book_stock_quantity, cate_id, author_id, publisher_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        return $this->db->insert ($sql, [$book_name, $book_title, $book_image, $book_description, $book_year_of_publication, $book_price, $book_date_of_storage, $book_stock_quantity, $cate_id, $author_id, $publisher_id]);
        }
        public function updateBook($id, $book_name, $book_title, $book_image, $book_description, $book_year_of_publication, 
                            $book_price, $book_date_of_storage, $book_stock_quantity, $cate_id, $author_id, $publisher_id) {
        $sql = "UPDATE book SET book_name = ?, book_title = ?, book_image = ?, book_description = ?, book_year_of_publication = ?, book_price = ?, book_date_of_storage = ?, book_stock_quantity = ?, cate_id = ?, author_id = ?, publisher_id = ? WHERE book_id = ?";
        return $this->db->update ($sql, [$book_name, $book_title, $book_image, $book_description, $book_year_of_publication, $book_price, $book_date_of_storage, $book_stock_quantity, $cate_id, $author_id, $publisher_id, $id]);
        }
        public function deleteBook($id){
            $sql = "DELETE FROM book WHERE book_id = ?";
            return $this->db->delete($sql, [$id]);
        }
    }
        
?>
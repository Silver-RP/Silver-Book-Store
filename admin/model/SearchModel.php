<?php

class SearchModel {
    private $conn;

    public function __construct() {
        $this->conn = new Database();
    }

    public function search($keyword) {
        $query = "
            SELECT 
                book.*, 
                author.author_name, 
                publisher.publisher_name, 
                category.cate_name 
            FROM book 
            JOIN author ON book.author_id = author.author_id 
            JOIN publisher ON book.publisher_id = publisher.publisher_id 
            JOIN category ON book.cate_id = category.cate_id 
            WHERE 
                book.book_name LIKE ? OR 
                author.author_name LIKE ? OR 
                publisher.publisher_name LIKE ? OR 
                category.cate_name LIKE ?
        ";

        $params = array_fill(0, 4, "%$keyword%");

        return $this->conn->getAll($query, $params);
    }
}
?>

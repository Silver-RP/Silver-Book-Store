<?php
class BookModel
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }
    public function getAllBooks($limit, $offset, $sort = null)
    {
        $defaultSort = "ASC";
        $sortOrder = ($sort == "ASC" || $sort == "DESC") ? $sort : $defaultSort;

        $sql = "SELECT * FROM book";
        if ($sort !== null) {
            $sql .= " ORDER BY book_price $sortOrder";
        }
        $sql .= " LIMIT $limit OFFSET $offset";

        try {
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return []; // or handle error as needed
        }
    }
    public function getBooks()
    {
        $sql = "SELECT * FROM book";
        return $this->db->getAll($sql);
    }
    public function countAllBooks()
    {
        $sql = "SELECT COUNT(*) FROM book";
        return $this->db->count($sql);
    }
    public function getBookById($id)
    {
        $sql = "SELECT * FROM book WHERE book_id = ?";
        return $this->db->getOne($sql, [$id]);
    }
    public function getBooksByIds(array $bookIds) {
        if (empty($bookIds)) {
            return []; 
        }
        $bookIds = array_values(array_unique($bookIds));
        $placeholders = implode(',', array_fill(0, count($bookIds), '?'));
        $sql = "SELECT * FROM book WHERE book_id IN ($placeholders)";
        return $this->db->getAll($sql, $bookIds);
    }
    
    public function getBooksByCateId($cate_id)
    {
        $sql = "SELECT * FROM book WHERE cate_id = ?";
        return $this->db->getAll($sql, [$cate_id]);
    }

    public function addBook(
        $book_name,
        $book_title,
        $book_image,
        $book_description,
        $book_year_of_publication,
        $book_price,
        $bookOldPrice,
        $book_date_of_storage,
        $book_stock_quantity,
        $cate_id,
        $author_id,
        $publisher_id
    ) {
        $sql = "INSERT INTO book (book_name, book_title, book_image, book_description, book_year_of_publication, book_price, book_old_price, book_date_of_storage, book_stock_quantity, cate_id, author_id, publisher_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        return $this->db->insert($sql, [$book_name, $book_title, $book_image, $book_description, $book_year_of_publication, $book_price, $bookOldPrice, $book_date_of_storage, $book_stock_quantity, $cate_id, $author_id, $publisher_id]);
    }
    public function updateBook(
        $id,
        $book_name,
        $book_title,
        $book_image,
        $book_description,
        $book_year_of_publication,
        $book_price,
        $bookOldPrice,
        $book_date_of_storage,
        $book_stock_quantity,
        $cate_id,
        $author_id,
        $publisher_id
    ) {
        $sql = "UPDATE book SET book_name = ?, book_title = ?, book_image = ?, book_description = ?, book_year_of_publication = ?, book_price = ?, book_old_price=?, book_date_of_storage = ?, book_stock_quantity = ?, cate_id = ?, author_id = ?, publisher_id = ? WHERE book_id = ?";
        return $this->db->update($sql, [$book_name, $book_title, $book_image, $book_description, $book_year_of_publication, $book_price, $bookOldPrice, $book_date_of_storage, $book_stock_quantity, $cate_id, $author_id, $publisher_id, $id]);
    }
    public function deleteBook($id)
    {
        $sql = "DELETE FROM book WHERE book_id = ?";
        return $this->db->delete($sql, [$id]);
    }
    public function addReview($book_id, $user_id, $review_content, $review_rating)
    {
        $sql = "INSERT INTO review (book_id, user_id, review_content, review_rating) VALUES (?, ?, ?, ?)";

        try {
            $result = $this->db->insert($sql, [$book_id, $user_id, $review_content, $review_rating]);
            return $result;
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return false;
        }
    }
    public function getBookComments($book_id)
    {
        $sql = "SELECT r.*, u.user_name 
                    FROM review r
                    JOIN users u ON r.user_id = u.user_id
                    WHERE r.book_id = ? AND r.review_status = 1
                    ORDER BY r.review_date DESC";
        return $this->db->getAll($sql, [$book_id]);
    }
    public function getBookReviews($book_id)
    {
        $sql = "SELECT r.review_content, r.review_rating, r.review_date, u.username 
                    FROM review r
                    JOIN users u ON r.user_id = u.user_id
                    WHERE r.book_id = :book_id AND r.review_status = 1
                    ORDER BY r.review_date DESC";
        return $this->db->getAll($sql, [$book_id]);
    }
}

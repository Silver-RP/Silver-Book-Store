<?php
class CommentModel{
    private $db;
    public function __construct(){
        $this->db = new Database();
    }
    public function getAllReviews($limit, $offset) {
        try {
            $sql = "SELECT * FROM review LIMIT " . $limit . " OFFSET " . $offset;
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return []; 
        }
    }
    public function countAllReviews(){
        $sql = "SELECT COUNT(*) FROM review";
        return $this->db->count($sql);
    }
    public function getCommentById($id){
        $sql = "SELECT * FROM review WHERE review_id = ?";
        return $this->db->getOne($sql, [$id]);
    }
    public function setStatus($id){
        $sql = "UPDATE review SET review_status = 1 WHERE review_id = ?";
        return $this->db->update($sql, [$id]);
    }
    public function setStatusHide($id){
        $sql = "UPDATE review SET review_status = 0 WHERE review_id = ?";
        return $this->db->update($sql, [$id]);
    }
    public function getHiddenReviews($limit, $offset){
        $sql = "SELECT * FROM review WHERE review_status = 0 LIMIT " . $limit . " OFFSET " . $offset;
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function countHiddenReviews(){
        $sql = "SELECT COUNT(*) FROM review WHERE review_status = 0";
        return $this->db->count($sql);
    }
    public function deleteComment($id){
        $sql = "DELETE FROM review WHERE review_id = ?";
        return $this->db->delete($sql, [$id]);
    }
}

?>
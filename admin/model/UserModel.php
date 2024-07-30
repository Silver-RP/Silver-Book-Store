<?php 
    class UserModel{
        private $db;
        public function __construct(){
            $this->db = new Database();
        }
        public function addUser($name, $birthday, $gender, $emailPhone, $password){
            $sql = "INSERT INTO users(user_name, user_birthday, user_gender, user_email_phone, user_password) 
                    VALUES(?,?,?,?,?)";
            return $this->db->insert($sql, [$name, $birthday, $gender, $emailPhone, $password]);
        }
        public function adminAddUser($name, $birthday, $gender, $emailPhone, $password, $role){
            $sql = "INSERT INTO users(user_name, user_birthday, user_gender, user_email_phone, user_password, user_role) 
                    VALUES(?,?,?,?,?,?)";
            return $this->db->insert($sql, [$name, $birthday, $gender, $emailPhone, $password, $role]);
        }
        // public function adminUpdateUser($id, $name, $birthday, $gender, $role){
        //     $sql = "UPDATE users SET user_name = ?, user_birthday = ?, user_gender = ?, user_role = ? WHERE user_id = ?";  
        //     return $this->db->update($sql, [$id, $name, $birthday, $gender, $role, $_GET['id']]);
        // }
        public function adminUpdateUser($id, $name, $birthday, $gender, $role) {
            $sql = "UPDATE users SET user_name = ?, user_birthday = ?, user_gender = ?, user_role = ? WHERE user_id = ?";
            return $this->db->update($sql, [$name, $birthday, $gender, $role, $id]);
        }
        
        public function deleteUser($userId){
            $sql = "DELETE FROM users WHERE user_id = ?";
            return $this->db->delete($sql, [$userId]);
        }
        public function getAllUsers($limit, $offset){
            try{
                $sql = "SELECT * FROM users LIMIT " . intval($limit) . " OFFSET " . intval($offset);
                return $this->db->getAll($sql);
            }catch(PDOException $e){
                echo "Error while getting all users: " . $e->getMessage();
            }
        }
        public function getUserByUsername($username){
            $sql = "SELECT * FROM users WHERE user_email_phone = ?";
            return $this->db->getOne($sql, [$username]);
        }
        public function getUserById($id){
            $sql = "SELECT * FROM users WHERE user_id = ?";
            return $this->db->getOne($sql, [$id]);
        }
        public function updateUser($name, $birthday, $gender, $userId){
            $sql = "UPDATE users SET user_name = ?, user_birthday = ?, user_gender = ? WHERE user_id = ?";
            return $this->db->update($sql, [$name, $birthday, $gender, $userId]);
        }
        public function updatePassword($newpassword){
            $sql = "UPDATE users SET user_password = ? WHERE user_id = ?";
            return $this->db->update($sql, [$newpassword, $_SESSION['user']['user_id']]);
        }
        public function countUsers(){
            $sql = "SELECT COUNT(*) FROM users;";
            return $this->db->count($sql);
        }
    }
?>
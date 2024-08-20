<?php
class UserModel
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }
    public function addUser($name, $birthday, $gender, $emailPhone, $hashedPassword, $activationCode, $activationExpires)
    {
        $sql = "INSERT INTO users (user_name, user_birthday, user_gender, user_email_phone, user_password, activation_code, activation_expires) 
                VALUES (:name, :birthday, :gender, :emailPhone, :hashedPassword, :activationCode, :activationExpires)";
        $params = [
            ':name' => $name,
            ':birthday' => $birthday,
            ':gender' => $gender,
            ':emailPhone' => $emailPhone,
            ':hashedPassword' => $hashedPassword,
            ':activationCode' => $activationCode,
            ':activationExpires' => $activationExpires
        ];
        // var_dump($params);
        // exit();
        return $this->db->insert($sql, $params);
    }

    public function getUserToCheck($emailPhone, $activationCode)
    {
        $sql = "SELECT * FROM users WHERE user_email_phone = ? AND activation_code = ? AND status = 'inactive'";
        return $this->db->getOne($sql, [$emailPhone, $activationCode]);
    }

    public function activateUser($userId)
    {
        $sql = "UPDATE users SET status = 'active', activation_code = NULL, activation_expires = NULL WHERE user_id = ?";
        return $this->db->update($sql, [$userId]);
    }

    public function adminAddUser($name, $birthday, $gender, $emailPhone, $password, $role)
    {
        $sql = "INSERT INTO users(user_name, user_birthday, user_gender, user_email_phone, user_password, user_role) 
                    VALUES(?,?,?,?,?,?)";
        return $this->db->insert($sql, [$name, $birthday, $gender, $emailPhone, $password, $role]);
    }
    public function adminUpdateUser($id, $name, $birthday, $gender, $role)
    {
        $sql = "UPDATE users SET user_name = ?, user_birthday = ?, user_gender = ?, user_role = ? WHERE user_id = ?";
        return $this->db->update($sql, [$name, $birthday, $gender, $role, $id]);
    }
    public function deleteUser($userId)
    {
        $sql = "DELETE FROM users WHERE user_id = ?";
        return $this->db->delete($sql, [$userId]);
    }

    public function getAllUsers($limit, $offset)
    {
        try {
            $sql = "SELECT * FROM users LIMIT " . intval($limit) . " OFFSET " . intval($offset);
            return $this->db->getAll($sql);
        } catch (PDOException $e) {
            echo "Error while getting all users: " . $e->getMessage();
        }
    }
    public function getUserByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE user_email_phone = ?";
        return $this->db->getOne($sql, [$username]);
    }
    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        return $this->db->getOne($sql, [$id]);
    }
    public function updateUser($name, $birthday, $gender, $userId)
    {
        $sql = "UPDATE users SET user_name = ?, user_birthday = ?, user_gender = ? WHERE user_id = ?";
        return $this->db->update($sql, [$name, $birthday, $gender, $userId]);
    }
    public function updatePassword($newpassword)
    {
        $sql = "UPDATE users SET user_password = ? WHERE user_id = ?";
        return $this->db->update($sql, [$newpassword, $_SESSION['user']['user_id']]);
    }
    public function updateForgotPassword($newPassword){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the user is properly stored in the session
        if (isset($_SESSION['reset_user']) && isset($_SESSION['reset_user']['user_id'])) {
            $userId = $_SESSION['reset_user']['user_id'];

            // Update the user's password in the database
            $sql = "UPDATE users SET user_password = ? WHERE user_id = ?";
            return $this->db->update($sql, [$newPassword, $userId]);
        } else {
            // Log an error or handle the case where the session does not contain user data
            error_log("No user information found in session during password update.");
            return false;
        }
    }

    public function countUsers()
    {
        $sql = "SELECT COUNT(*) FROM users;";
        return $this->db->count($sql);
    }
    public function addResetCode($userId, $resetCode, $resetExpires)
    {
        $sql = "INSERT INTO forgot_password (user_id, reset_code, reset_expires) VALUES (?, ?, ?)";
        return $this->db->insert($sql, [$userId, $resetCode, $resetExpires]);
    }
    public function getUserByResetCode($resetCode)
    {
        $sql = "SELECT * FROM forgot_password WHERE reset_code = ? AND reset_expires > NOW() AND used = 0";
        return $this->db->getOne($sql, [$resetCode]);
    }
    public function markResetCodeAsUsed($resetCode)
    {
        $sql = "UPDATE forgot_password SET used = 1 WHERE reset_code = ?";
        return $this->db->update($sql, [$resetCode]);
    }
}

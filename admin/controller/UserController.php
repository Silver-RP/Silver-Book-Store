<?php
require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/model/UserModel.php');

    class UserController{
        private $userController;
        function __construct(){
            $this->userController = new UserModel();
        }
        public function index(){
            $limit = 30;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;
            try{
                $totalUsers =  $this->userController->countUsers();
                $totalPages = ceil($totalUsers / $limit);
                $users = $this->userController->getAllUsers($limit, $offset);
                require_once('view/users/Allusers.php');
            }catch (Exception $e) {
                echo "Error while show all users: " . $e->getMessage();
            }
        }
        public function add(){
            require_once ('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/view/users/AddUser.php');
            if(isset($_POST['add'])){
                $username = $_POST['name'];
                $userBirthday = $_POST['birthday'];
                $userGender = $_POST['gender'];
                $userEmail = $_POST['emailPhone'];
                $userPassword = $_POST['password'];
                $userRePassword = $_POST['re_password'];
                $userRole = $_POST['role'];

                $existingUser = $this->userController->getUserByUsername($userEmail);
                if($existingUser){
                    echo "<script>
                    alert('An account with this email or phone number already exists!');
                        window.location.href='?act=user&action=add';
                    </script>";
                return;
                }

                // Can check other conditions here

                if ($userPassword !== $userRePassword) {
                    echo "<script>
                            alert('Password and Re-Password do not match!');
                            window.location.href='?act=user&action=add';
                        </script>";
                    return;
                }
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $this->userController->adminAddUser($username, $userBirthday, $userGender, $userEmail, $hashedPassword, $userRole);
                echo "<script>
                        alert('User added successfully!');
                        window.location.href='?act=user&action=index';
                    </script>";
            }
        }
        public function edit(){
            if(isset($_GET['id'])){
                $userId = $_GET['id'];
                $user = $this->userController->getUserById($userId);
                require_once ('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/view/users/EditUser.php');

                if (isset($_POST['edit'])) {
                    $username = $_POST['name'];
                    $userBirthday = $_POST['birthday'];
                    $userGender = $_POST['gender'];
                    $userRole = $_POST['role'];
        
                    $result = $this->userController->adminUpdateUser($userId, $username, $userBirthday, $userGender, $userRole);
                    
                    if ($result) {
                        echo "<script>
                                alert('User updated successfully!');
                                window.location.href='?act=user&action=index';
                            </script>";
                    } else {
                        echo "<script>
                                alert('Error while updating user!');
                                window.location.href='?act=user&action=edit&id=$userId';
                            </script>";
                    }
                }
            }
        }
        public function delete(){
            $userId = $_GET['id'];
            echo "<script>
                    if(confirm('Are you sure you want to delete this user?')){
                        window.location.href='?act=user&action=confirmDelete&id=$userId';
                    }else{
                        window.location.href='?act=user&action=index';
                        consolo.log('User not deleted!');
                    }
                </script>";
        }
        public function confirmDelete(){
            $userId = $_GET['id'];
            $this->userController->deleteUser($userId);
            echo "<script>
                    alert('User deleted successfully!');
                    window.location.href='?act=user&action=index';
                </script>";
        }
        public function checkEmailPhone() {
            header('Content-Type: application/json');
            $input = json_decode(file_get_contents('php://input'), true);
            $emailPhone = $input['emailPhone']; 
        
            $check = $this->userController->getUserByUsername($emailPhone);
            if ($check) {
                echo json_encode(['check' => true]);
            } else {
                echo json_encode(['check' => false]);
            }
            exit; 
        }
        // public function signinAccount(){
        //     if (isset($_POST['login-admin'])) {
        //         $emailPhone = $_POST['emailPhone'];
        //         $password = $_POST['password'];
        //         $user = $this->userController->getUserByUsername($emailPhone);
        //         if ($user) {
        //             if (password_verify($password, $user['user_password'])) {
        //                 $_SESSION['user'] = $user;
        //                 header('Location: /SilverBook/admin/index.php?act=home');
        //                 exit();
        //             } else {
        //                 echo "<script>
        //                     alert('Password is incorrect!');
        //                 </script>";
        //             }
        //         } else {
        //             echo "<script>
        //                 alert('User does not exist!');
        //             </script>";
        //         }
        //     }
        // }

        // public function signoutAccount(){
        //     session_start();
        //     session_unset(); 
        //     session_destroy(); 
        
        //     header("Location: /SilverBook/admin/view/layout/login.php");
        //     exit(); 
        // }
        
    }
?>
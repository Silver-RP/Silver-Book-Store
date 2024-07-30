<?php

class UserController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    public function signin()
    {
        session_start();
        if (isset($_POST['signin'])) {
            $username = htmlspecialchars($_POST['emailPhone']);
            $password = htmlspecialchars($_POST['password']);
            $user = $this->userModel->getUserByUsername($username);

            if ($user) {
                if (password_verify($password, $user['user_password'])) {
                    $_SESSION['user'] = $user;
                    if (isset($_SESSION['user'])) {
                        // var_dump($_SESSION['user']);
                        echo "<script>
                            alert('Login successfully!');
                            window.location.href='index.php';
                          </script>";
                    }
                } else {
                    echo "<script>
                            alert('Password is wrong!');
                            window.location.href='index.php?route=user&subroute=signin';
                          </script>";
                }
            } else {
                echo "<script>
                        alert('Username does not exist!');
                        window.location.href='index.php?route=user&subroute=signin';
                      </script>";
            }
        }
        require_once('app/view/users/login.php');
    }
    public function viewSignup()
    {
        require_once('app/view/users/register.php');
    }
    public function signup()
    {
        if (isset($_POST['signup'])) {
            $name = htmlspecialchars(trim($_POST['name']));
            $birthday = htmlspecialchars(trim($_POST['birthday']));
            $gender = htmlspecialchars(trim($_POST['gender']));
            $emailPhone = htmlspecialchars(trim($_POST['emailPhone']));
            $password = htmlspecialchars(trim($_POST['password']));
            $rePassword = htmlspecialchars(trim($_POST['re_password']));

            // Check for existing user
            $existingUser = $this->userModel->getUserByUsername($emailPhone);
            if ($existingUser) {
                echo "<script>
                        alert('An account with this email or phone number already exists!');
                        window.location.href='index.php?route=user&subroute=viewsignup';
                    </script>";
                return;
            }
            // Check for valid email or phone number
            if (!filter_var($emailPhone, FILTER_VALIDATE_EMAIL) && !preg_match('/^[0-9]{10}+$/', $emailPhone)) {
                echo "<script>
                        alert('Email or Phone number is invalid!');
                        window.location.href='index.php?route=user&subroute=viewsignup';
                    </script>";
                return;
            }

            if ($password !== $rePassword) {
                echo "<script>
                        alert('Password and Re-Password do not match!');
                        window.location.href='index.php?route=user&subroute=viewsignup';
                    </script>";
                return;
            }
            // Check for at least 8 characters
            if (strlen($password) < 8) {
                echo "<script>
                        alert('Password must be at least 8 characters long!');
                        window.location.href='index.php?route=user&subroute=viewsignup';
                    </script>";
                return;
            }
            // Check for at least one uppercase letter
            if (!preg_match('/[A-Z]/', $password)) {
                echo "<script>
                        alert('Password must contain at least one uppercase letter!');
                        window.location.href='index.php?route=user&subroute=viewsignup';
                    </script>";
                return;
            }
            // Check for at least one number
            if (!preg_match('/[0-9]/', $password)) {
                echo "<script>
                        alert('Password must contain at least one number!');
                        window.location.href='index.php?route=user&subroute=viewsignup';
                    </script>";
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $userAdded = $this->userModel->addUser($name, $birthday, $gender, $emailPhone, $hashedPassword);
            if ($userAdded) {
                echo "<script>
                        alert('Sign up successfully!');
                        window.location.href='index.php?route=user&subroute=signin';
                    </script>";
            } else {
                echo "<script>
                        alert('Registration failed, please try again!');
                        window.location.href='index.php?route=user&subroute=viewsignup';
                    </script>";
            }
        }
    }
    public function signout()
    {
        // Destroy the session cookie, uncomment the following lines
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
        echo "<script>
                alert('You are Signed Out!');
                window.location.href = 'index.php';
            </script>";
    }
    public function profile()
    {
        if (isset($_SESSION['user'])) {
            $user = $this->userModel->getUserById($_SESSION['user']['user_id']);
            require_once('app/view/users/profile.php');
        } else {
            echo "<script>
                    alert('Please login to view your profile!');
                    window.location.href = 'index.php?route=user&subroute=signin';
                </script>";
        }
    }
    public function viewEditProfile()
    {
        if (isset($_SESSION['user'])) {
            $user = $this->userModel->getUserById($_SESSION['user']['user_id']);
            require_once('app/view/users/editProfile.php');
        } else {
            echo "<script>
                    alert('Please login to edit your profile!');
                    window.location.href = 'index.php?route=user&subroute=signin';
                </script>";
        }
    }
    public function editProfile()
    {
        if (isset($_SESSION['user'])) {
            if (isset($_POST['edit'])) {
                $username = $_POST['user_name'];
                $birthday = $_POST['user_birthday'];
                $gender = $_POST['user_gender'];
                $userId = $_SESSION['user']['user_id'];
                
                $this->userModel->updateUser($username, $birthday, $gender, $userId);
                
                $user = $this->userModel->getUserById($userId);
                $_SESSION['user'] = $user;
                
                echo '<script>
                        alert("Profile updated successfully!");
                        window.location.href = "index.php?route=user&subroute=profile";
                    </script>';
            } else {
                require_once('app/view/users/editProfile.php');
            }
        }
    }
    public function viewChangePass()
    {
        if (isset($_SESSION['user'])) {
            require_once('app/view/users/ChangePass.php');
        } else {
            echo "<script>
                    alert('Please login to change your password!');
                    window.location.href = 'index.php?route=user&subroute=signin';
                </script>";
        }
    }
    public function changePass()
    {
        if (isset($_SESSION['user'])) {
            if (isset($_POST['changepass'])) {
                $oldPass = $_POST['user_old_pass'];
                $newPass = $_POST['user_new_pass'];
                $reNewPass = $_POST['user_confirm_pass'];
                $user = $this->userModel->getUserById($_SESSION['user']['user_id']);
                if (password_verify($oldPass, $user['user_password'])) {
                    if ($newPass == $reNewPass) {
                        $newPass = password_hash($newPass, PASSWORD_DEFAULT);

                        // Check password constraints ...

                        $this->userModel->updatePassword($newPass);
                        echo "<script>
                                alert('Password changed successfully!');
                                window.location.href = 'index.php?route=user&subroute=profile';
                            </script>";
                    } else {
                        echo "<script>
                                alert('New password and Confirm new password do not match!');
                                window.location.href = 'index.php?route=user&subroute=viewChangePass';
                            </script>";
                    }
                } else {
                    echo "
                    <script>
                        alert('Old password is wrong!');
                        window.location.href = 'index.php?route=user&subroute=viewChangePass';
                    </script>";
                }
            }
            require_once('app/view/users/ChangePass.php');
        } else {
            echo "<script>
                    alert('Please login to change your password!');
                    window.location.href = 'index.php?route=user&subroute=signin';
                </script>";
        }
    }
    public function  forgotPassword(){
        echo "<script>
                console.log('Forgot Password');
            </script>";
        require_once ('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/app/view/users/ForgotPassword.php');
        // if(isset($_POST['forgotPassword'])){
        //     $emailPhone = $_POST['emailPhone'];
        //     $user = $this->userController->getUserByUsername($emailPhone);
        //     if($user){
        //         // Send email to user with password reset link
        //         echo "<script>
        //                 alert('Password reset link sent to your email!');
        //                 window.location.href='?act=user&action=index';
        //             </script>";
        //     }else{
        //         echo "<script>
        //                 alert('User does not exist!');
        //                 window.location.href='?act=user&action=forgotPassword';
        //             </script>";
        //     }
        // }
    }
    public function checkEmailPhone() {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
        $emailPhone = $input['emailPhone']; 
    
        $check = $this->userModel->getUserByUsername($emailPhone);
        if ($check) {
            echo json_encode(['check' => true]);
        } else {
            echo json_encode(['check' => false]);
        }
        exit; 
    }
    
    // public function checkout(){
    // if(isset($_SESSION['user'])){
    // $user = $_SESSION['user'];
    // $carts = $this->userModel->getCartByUserId($user['id']);
    // if(isset($_POST['checkout'])){
    // $total = $_POST['total'];
    // $this->userModel->addOrder($user['id'], $total);
    // $order = $this->userModel->getOrderLast();
    // foreach($carts as $cart){
    // $this->userModel->addOrderDetail($order['id'], $cart['book_id'], $cart['quantity']);
    // }
    // $this->userModel->deleteCartByUserId($user['id']);
    // header('Location: index.php?route=user&subroute=order');
    // }
    // require_once('app/view/users/checkout.php');
    // }else{
    // header('Location: index.php?route=user&subroute=login');
    // }
    // }
    // public function order(){
    // if(isset($_SESSION['user'])){
    // $user = $_SESSION['user'];
    // $orders = $this->userModel->getOrderByUserId($user['id']);
    // require_once('app/view/users/order.php');
    // }else{
    // header('Location: index.php?route=user&subroute=login');
    // }
    // }
    // public function orderDetail(){
    // if(isset($_SESSION['user'])){
    // $user = $_SESSION['user'];
    // $id = $_GET['id'];
    // $order = $this->userModel->getOrderById($id);
    // $orderDetails = $this->userModel->getOrderDetailByOrderId($id);
    // require_once('app/view/users/orderDetail.php');
    // }else{
    // header('Location: index.php?route=user&subroute=login');
    // }
    // }

    // public function orderHistory(){
    // if(isset($_SESSION['user'])){
    // $user = $_SESSION['user'];
    // $orders = $this->userModel->getOrderByUserId($user['id']);
    // require_once('app/view/users/orderHistory.php');
    // }else{
    // header('Location: index.php?route=user&subroute=login');
    // }
    // }
    // public function orderHistoryDetail(){
    // if(isset($_SESSION['user'])){
    // $user = $_SESSION['user'];
    // $id = $_GET['id'];
    // $order = $this->userModel->getOrderById($id);
    // $orderDetails = $this->userModel->getOrderDetailByOrderId($id);
    // require_once('app/view/users/orderHistoryDetail.php');
    // }else{
    // header('Location: index.php?route=user&subroute=login');
    // }
    // }

}

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class UserController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
  
    public function signin(){
        session_start();

        if (isset($_POST['signin'])) {
            $username = htmlspecialchars(trim($_POST['emailPhone']));
            $password = htmlspecialchars(trim($_POST['password']));

            // Validate username (email or phone) format
            if (!filter_var($username, FILTER_VALIDATE_EMAIL) && !preg_match('/^[0-9]{10}$/', $username)) {
                echo "<script>
                    alert('Invalid email or phone number format!');
                    window.location.href='index.php?route=user&subroute=signin';
                  </script>";
                exit;
            }

            // Retrieve user information
            $user = $this->userModel->getUserByUsername($username);

            if ($user) {
                // Check if the account is active
                if ($user['status'] !== 'active') {
                    echo "<script>
                        alert('Account is not activated. Please check your email to activate your account.');
                        window.location.href='index.php?route=user&subroute=signin';
                      </script>";
                    exit;
                }

                // Verify password
                if (password_verify($password, $user['user_password'])) {
                    $_SESSION['user'] = $user;

                    // Redirect logic
                    if (isset($_SESSION['redirect'])) {
                        $redirect = $_SESSION['redirect'];
                        unset($_SESSION['redirect']);
                        echo "<script>
                            // alert('Login successfully!');
                            window.location.href='$redirect';
                          </script>";
                    } else {
                        echo "<script>
                            // alert('Login successfully!');
                            window.location.href='index.php';
                          </script>";
                    }
                    exit;
                } else {
                    echo "<script>
                        alert('Incorrect password!');
                        window.location.href='index.php?route=user&subroute=signin';
                      </script>";
                    exit;
                }
            } else {
                echo "<script>
                    alert('Username does not exist!');
                    window.location.href='index.php?route=user&subroute=signin';
                  </script>";
                exit;
            }
        }

        require_once('app/view/users/login.php');
    }
    public function viewSignup()
    {
        require_once('app/view/users/register.php');
    }
   
    public function signup(){
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
                echo "<script>alert('An account with this email or phone number already exists!'); window.location.href='index.php?route=user&subroute=viewsignup';</script>";
                return;
            }

            // Validate email or phone number
            if (!filter_var($emailPhone, FILTER_VALIDATE_EMAIL) && !preg_match('/^[0-9]{10}$/', $emailPhone)) {
                echo "<script>alert('Email or Phone number is invalid!'); window.location.href='index.php?route=user&subroute=viewsignup';</script>";
                return;
            }

            // Validate passwords
            if ($password !== $rePassword) {
                echo "<script>alert('Password and Re-Password do not match!'); window.location.href='index.php?route=user&subroute=viewsignup';</script>";
                return;
            }

            // Password strength validation
            if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
                echo "<script>alert('Password must be at least 8 characters long, contain at least one uppercase letter, and one number!'); window.location.href='index.php?route=user&subroute=viewsignup';</script>";
                return;
            }

            // Generate activation code
            $activationCode = md5(uniqid(rand(), true));
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $activationExpires = date('Y-m-d H:i:s', strtotime('+24 hours'));

            $newUser = [
                'name' => $name,
                'birthday' => $birthday,
                'gender' => $gender,
                'emailPhone' => $emailPhone,
                'hashedPassword' => $hashedPassword,
                'activationCode' => $activationCode,
                'activationExpires' => $activationExpires
            ];
            $userAdded = $this->userModel->addUser($name, $birthday, $gender, $emailPhone, $hashedPassword, $activationCode,  $activationExpires);
            if ($userAdded) {
                // Send verification email
                $emailSent = $this->sendVerificationEmail($emailPhone, $activationCode);
                if ($emailSent) {
                    echo "<script>alert('Sign up successful! Please check your email to activate your account.'); window.location.href='index.php?route=user&subroute=signin';</script>";
                } else {
                    echo "<script>alert('Sign up successful, but failed to send verification email. Please contact support.'); window.location.href='index.php?route=user&subroute=signin';</script>";
                }
            } else {
                var_dump($newUser);
                exit;
                echo "<script>alert('Registration failed, please try again!'); window.location.href='index.php?route=user&subroute=viewsignup';</script>";
            }
        }
    }
    function sendVerificationEmail($email, $activationCode){
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'roppyhoangle@gmail.com';
            $mail->Password   = 'ujatodehwuwrmbue';
            $mail->SMTPSecure = 'TLS';
            $mail->Port       = 587;

            $mail->setFrom('roppyhoangle@gmail.com', 'Silver-Book');
            // $mail->addAddress('roppyhoang@gmail.com');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body    = "Please click the link below to verify your email address:<br><br>
                              <a href='http://localhost:3000/SilverBook/index.php?route=user&subroute=activate&email=" . urlencode($email) . "&code=" . urlencode($activationCode) . "'>
                              Verify Email</a>";
            $mail->AltBody = "Please click the link to verify your email address: http://localhost:3000/SilverBook/index.php?route=user&subroute=activate&email=" . urlencode($email) . "&code=" . urlencode($activationCode);

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Mailer Error: " . $mail->ErrorInfo);
            return false;
        }
    }
    function activate(){
        if (isset($_GET['email']) && isset($_GET['code'])) {
            $email = htmlspecialchars(trim($_GET['email']));
            $activationCode = htmlspecialchars(trim($_GET['code']));
            $user = $this->userModel->getUserToCheck($email, $activationCode);
            
            if ($user) {
                if (new DateTime() > new DateTime($user['activation_expires'])) {
                    $this->userModel->deleteUser($user['user_id']);
                    echo "<script>
                            alert('Activation link expired. Please register again.');
                            window.location.href='index.php?route=user&subroute=viewsignup';
                          </script>";
                } else {
                    $checked = $this->userModel->activateUser($user['user_id']);
                    if ($checked) {
                    echo "<script>
                            alert('Account activated successfully!');
                            window.location.href='index.php?route=user&subroute=signin';
                          </script>";
                    } else {
                        echo "<script>
                                alert('Failed to activate account. Please try again.');
                                exit();
                                window.location.href='index.php?route=user&subroute=viewsignup';
                              </script>";
                    }
                }
            } else {
                echo "<script>
                        alert('Invalid or expired activation link!');
                        window.location.href='index.php?route=user&subroute=viewsignup';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Missing email or activation code!');
                    window.location.href='index.php?route=user&subroute=viewsignup';
                  </script>";
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
                // alert('You are Signed Out!');
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
    public function forgotPassword(){
        echo "<script>
                console.log('Forgot Password');
              </script>";

        require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/app/view/users/ForgotPassword.php');
        
        if (isset($_POST['forgotPassword'])) {
            $emailPhone = trim($_POST['emailPhone']);
            $user = $this->userModel->getUserByUsername($emailPhone);
    
            if ($user) {
                // Generate reset code and expiration time
                $resetCode = md5(uniqid(rand(), true));
                $resetExpires = date('Y-m-d H:i:s', strtotime('+24 hours'));
    
                // Save reset code to the database
                $this->userModel->addResetCode($user['user_id'], $resetCode, $resetExpires);
    
                // Send the reset email
                if ($this->sendResetEmail($emailPhone, $resetCode)) {
                    echo "<script>
                            alert('Password reset link sent to your email!');
                            window.location.href='?route=user&subroute=forgotPassword';
                          </script>";
                } else {
                    echo "<script>
                            alert('Failed to send reset email. Please try again later.');
                          </script>";
                }
            } else {
                echo "<script>
                        alert('User does not exist!');
                        window.location.href='?route=user&subroute=forgotPassword';
                      </script>";
            }
        }
    }
    public function sendResetEmail($email, $resetCode){
        $mail = new PHPMailer(true);
    
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'roppyhoangle@gmail.com';
            $mail->Password   = 'ujatodehwuwrmbue';  
            $mail->SMTPSecure = 'tls';  
            $mail->Port       = 587;
    
            $mail->setFrom('no-reply@silver-book.com', 'Silver-Book');  
            $mail->addAddress($email);
    
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset';
            $mail->Body    = "Please click the link below to reset your password:<br><br>
                              <a href='http://localhost:3000/SilverBook/index.php?route=user&subroute=resetPassword&email=" . urlencode($email) . "&code=" . urlencode($resetCode) . "'>
                              Reset Password</a>";
            $mail->AltBody = "Please click the link to reset your password: http://localhost:3000/SilverBook/index.php?route=user&subroute=resetPassword&email=" . urlencode($email) . "&code=" . urlencode($resetCode);
    
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Mailer Error: " . $mail->ErrorInfo);
            return false;
        }
    }
    public function resetPassword() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_GET['email']) && isset($_GET['code'])) {
            $email = htmlspecialchars(trim($_GET['email']));
            $resetCode = htmlspecialchars(trim($_GET['code']));
            $user = $this->userModel->getUserByResetCode($resetCode);
    
            if ($user) {
                // Check if reset link has expired
                if (new DateTime() > new DateTime($user['reset_expires'])) {
                    echo "<script>
                            alert('Reset link expired. Please try again.');
                            window.location.href='?act=user&action=forgotPassword';
                          </script>";
                } else {
                    session_regenerate_id(true);
                    $_SESSION['reset_user'] = $user;
                    require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/app/view/users/ResetPassword.php');
    
                    if (isset($_POST['resetPassword'])) {
                        $password = htmlspecialchars(trim($_POST['password']));
                        $rePassword = htmlspecialchars(trim($_POST['confirmPassword']));

                        // var_dump($password);
                        // var_dump($rePassword);
                        // var_dump($user);
                        // exit;
    
                        if ($password !== $rePassword) {
                            echo "<script>
                                    alert('Password and Confirm Password do not match!');
                                  </script>";
                        } else {
                            if (strlen($password) < 8) {
                                echo "<script>
                                        alert('Password must be at least 8 characters long!');
                                      </script>";
                            } elseif (!preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/\d/", $password) || !preg_match("/[\W]/", $password)) {
                                echo "<script>
                                        alert('Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character!');
                                      </script>";
                            } else {
                                $newPassword = password_hash($password, PASSWORD_DEFAULT);
                                $result = $this->userModel->updateForgotPassword($newPassword);
                                $resultCode = $this->userModel->markResetCodeAsUsed($resetCode);
    
                                if ($result && $resultCode) {
                                    echo "<script>
                                            alert('Password reset successfully!');
                                            window.location.href='?act=user&action=signin';
                                          </script>";
                                } else {
                                    error_log("Failed to reset password for user: {$user['user_id']}");
                                    echo "<script>
                                            alert('Failed to reset password. Please try again.');
                                          </script>";
                                }
                            }
                        }
                    }
                }
            } else {
                echo "<script>
                        alert('Invalid or expired reset link!');
                        window.location.href='?act=user&action=forgotPassword';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Missing email or reset code!');
                    window.location.href='?act=user&action=forgotPassword';
                  </script>";
        }
    }
    

    public function checkEmailPhone(){
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
}

<?php
    session_start(); 
    session_unset(); 
    session_destroy(); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="path/to/your/styles.css"> <!-- Include your CSS file -->
    <style>
        body,
        h2,
        form,
        div {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .login-container {
            background: #fff;
            margin-bottom: 150px;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px 10px;
            margin-left: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="emailPhone">Email or Phone:</label>
                <input type="text" id="emailPhone" name="emailPhone" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="login-admin">Login</button>
        </form>
    </div>

    <?php
    require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/config/database.php');
    require_once('/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/model/UserModel.php');
        $userModel = new UserModel();
        if (isset($_POST['login-admin'])) {
            session_start();
            $emailPhone = $_POST['emailPhone'];
            $password = $_POST['password'];
            $user = $userModel->getUserByUsername($emailPhone);
            if ($user) {
                if (password_verify($password, $user['user_password'])) {
                    $_SESSION['user'] = $user;
                    header('Location: /SilverBook/admin/index.php?act=home');
                    exit();
                } else {
                    echo "<script>
                        alert('Password is incorrect!');
                    </script>";
                }
            } else {
                echo "<script>
                    alert('User does not exist!');
                </script>";
            }
        }
    ?>
</body>

</html>
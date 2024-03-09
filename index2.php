<?php
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: rgb(142, 149, 195);
            background: linear-gradient(90deg, rgba(142, 149, 195, 1) 0%, rgba(78, 72, 182, 1) 21%, rgba(22, 17, 105, 1) 50%, rgba(78, 72, 182, 1) 80%, rgba(142, 149, 195, 1) 100%);
        }

        .login-container {
            max-width: 400px;
            margin: auto;
            margin-top: 100px;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-logo img {
            max-width: 100px;
        }

        .login-card {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 20px;
            background-color: #ccfff7;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
        }
    </style>
    <title>Login | MDXC</title>
</head>


<body>

    <div class="container login-container">
        <div class="card login-card">
            <div class="login-logo">
                <img src="images/MDXC-200px1.png" alt=" MDXC Logo">
            </div>
            <h2 class="text-center">Login</h2>
            <?php

            // Check if the user is already logged in and redirect to dashboard if true
            if (isset($_SESSION['user_id'])) {
                header("Location: ./user/index.php");
                exit();
            }

            // Check if login form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                require 'config.php'; // Include your database connection file
                $call_sign = $_POST['call_sign'];
                $password = $_POST['password'];

                // Check user credentials
                $query = "SELECT * FROM `user` WHERE `call_sign` = '$call_sign' AND `password` = '$password'";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    // Login successful, set session variables and redirect to dashboard
                    $user = mysqli_fetch_assoc($result);
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['operator'] = $user['call_sign'];
                    $_SESSION['sitename'] = "mdxc_adi_process";
                    $_SESSION['login'] = true;
                    header("Location: ./user/index.php");
                    exit();
                } else {
                    echo '<div class="alert alert-danger">Invalid username or password</div>';
                }
            }
            ?>
            <!-- Login Form -->
            <form method="post" action="">
                <div class="form-group">
                    <label for="call_sign">Call Sign</label>
                    <input type="text" class="form-control" id="call_sign" name="call_sign" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
        <div class="login-footer" style="color:white">
            &copy; 2024 MDXC </br> Developed by &nbsp <a href="https://onirbanbd.com/" style="color: white;">
                <img src="images/logo-dark.png" style="height:35px; "> </a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
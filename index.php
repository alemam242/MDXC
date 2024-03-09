<?php
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login | MDXC</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet" />
    <link href="assets/css/fontawesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/toastify.min.css" rel="stylesheet" />
    <script src="assets/js/toastify-js.js"></script>
    <script src="assets/js/axios.min.js"></script>
    <script src="assets/js/config.js"></script>
</head>

<body style="background: #E5FCFF;">

    <div id="loader" class="LoadingOverlay d-none">
        <div class="Line-Progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <div>
        <!-- Main Content -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
                    <div class="card w-90  p-4">
                        <div class="row">
                            <div class="col-12 text-center login-logo">
                                <img style="width:7em; height:7em" src="images/MDXC-200px1.png" alt=" MDXC Logo">
                            </div>
                        </div>
                        <div class="card-body">
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
                            <form method="post" action="" autocomplete="FALSE">
                                <h4>SIGN IN</h4>
                                <br />
                                <input id="call_sign" name="call_sign" placeholder="Call Sign" class="form-control input-field" type="text" required />
                                <br />
                                <input placeholder="Password" class="form-control input-field" type="password" id="password" name="password" required />
                                <br />
                                <button class="btn w-100 bg-gradient-info">Login</button>
                                <hr />
                            </form>
                        </div>
                        <div class="row text-muted">
                            <div class="col-12">
                            <div class="row">
                                <div class="col-12 text-center">
                                    &copy; <?php echo date('Y'); ?> MDXC
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12 text-center">
                                    <spqan>Developed by </spqan> 
                                    <a href="https://onirbanbd.com/" style="color: white;">
                                        <img src="images/logo-dark.png" style="height:25px" alt="Onirban Bangladesh Technology"> </a>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>

    <script src="assets/js/bootstrap.bundle.js"></script>

</body>

</html>
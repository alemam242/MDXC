<?php
// Assuming you have a config.php file for database connection
require('../config.php');
session_start();


// Check if the user is not logged in, redirect to login screen
if (!isset($_SESSION['user_id']) || !isset($_SESSION['sitename']) || !isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit();
}
// Get user details from the database
$user_id = $_SESSION['user_id'];
$query_user = "SELECT * FROM `user` WHERE `id` = $user_id";
$result_user = mysqli_query($conn, $query_user);

// Extract users;
if ($result_user && mysqli_num_rows($result_user) > 0) {
    $user_details = mysqli_fetch_assoc($result_user);
    
    // $username = explode(" ",$user_details['name'])[0];
    $username = $user_details['name'];
}else{
    $user_details = null;
    $username = "";
}

// Get admin notices from the database
$query_notices = "SELECT * FROM `admin_notices` ORDER BY `create_date` DESC";
$result_notices = mysqli_query($conn, $query_notices);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>User Dashboard | MDXC ADI Management System</title>

    <!-- <link rel="icon" type="image/x-icon" href="../assets//favicon.ico" /> -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/animate.min.css" rel="stylesheet" />
    <link href="../assets/css/fontawesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link href="../assets/css/toastify.min.css" rel="stylesheet" />


    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <link href="../assets/css/jquery.dataTables.min.css" rel="stylesheet" />
    <script src="../assets/js/jquery-3.7.0.min.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>


    <script src="../assets/js/toastify-js.js"></script>
    <script src="../assets/js/axios.min.js"></script>
    <script src="../assets/js/config.js"></script>
    <script src="../assets/js/bootstrap.bundle.js"></script>
</head>

<body>

    <div id="loader" class="LoadingOverlay d-none">
        <div class="Line-Progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <!-- Header -->
    <?php
    include('include/header.php')
    ?>

    <!-- Navbar -->
    <?php include('menu.php') ?>

    <div id="contentRef" class="content">
        <div class="container-fluid">
            <div class="row">
        <div class="col-12">
            <div class="page-title-box align-items-center justify-content-between p-2">
                <h4 class="mb-sm-0">Dashboard</h4>
                <div class="">
                    <span class="mb-sm-0">Welcome Back
                    <?php
                            if ($user_details) {
                                echo $username;
                            }
                            ?>
                        !</span>
                </div>

            </div>
        </div>
    </div>
        </div>
        <div class="container">

        


            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="background-color: #313A38; color:white">
                            Personal Details
                        </div>
                        <div class="card-body">
                            <?php
                            if ($user_details) {
                                echo '<p><strong>Name:</strong> ' . $user_details['name'] . '</p>';
                                echo '<p><strong>Email:</strong> ' . $user_details['email'] . '</p>';
                                echo '<p><strong>Phone:</strong> ' . $user_details['phone'] . '</p>';
                                echo '<p><strong>Address:</strong> ' . $user_details['address'] . '</p>';
                                echo '<p><strong>Country:</strong> ' . $user_details['country'] . '</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="background-color: #313A38; color:white">
                            Notices From Admin
                        </div>
                        <div class="card-body">
                            <?php
                            if ($result_notices && mysqli_num_rows($result_notices) > 0) {
                                while ($notice = mysqli_fetch_assoc($result_notices)) {
                                    echo '<p class="text-capitalize"><strong>' . $notice['title'] . ':</strong> ' . $notice['content'] . '</p>';
                                }
                            } else {
                                echo '<p>No notices available.</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <script>
        showLoader();
        function MenuBarClickHandler() {
            let sideNav = document.getElementById('sideNavRef');
            let content = document.getElementById('contentRef');
            if (sideNav.classList.contains("side-nav-open")) {
                sideNav.classList.add("side-nav-close");
                sideNav.classList.remove("side-nav-open");
                content.classList.add("content-expand");
                content.classList.remove("content");
            } else {
                sideNav.classList.remove("side-nav-close");
                sideNav.classList.add("side-nav-open");
                content.classList.remove("content-expand");
                content.classList.add("content");
            }
        }
    </script>

    <script>
        $().ready(function (){
            hideLoader();
        });
    </script>

</body>

</html>
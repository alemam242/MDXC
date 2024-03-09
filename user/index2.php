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

// Get admin notices from the database
$query_notices = "SELECT * FROM `admin_notices` ORDER BY `create_date` DESC";
$result_notices = mysqli_query($conn, $query_notices);
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>User Dashboard | MDXC ADI Management System</title>
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/master.css" rel="stylesheet">
    <link href="assets/vendor/flagiconcss/css/flag-icon.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <?php include("menu.php"); ?>
        <div id="body" class="active">
            <!-- navbar navigation component -->

            <nav class="navbar navbar-expand-lg navbar-white bg-white">
                <button type="button" id="sidebarCollapse" class="btn btn-light">
                    <i class="fas fa-bars"></i><span></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                </div>
            </nav>
            <!-- end of navbar navigation -->
            
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 page-header">
                            <div class="page-pretitle">Overview</div>
                            <h2 class="page-title">User Dashboard</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header" style="background-color: #313A38; color:white">
                                    Personal Details
                                </div>
                                <div class="card-body">
                                    <?php
                                    if ($result_user && mysqli_num_rows($result_user) > 0) {
                                        $user_details = mysqli_fetch_assoc($result_user);
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
                                            echo '<p><strong>' . $notice['title'] . ':</strong> ' . $notice['content'] . '</p>';
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
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chartsjs/Chart.min.js"></script>
    <script src="assets/js/dashboard-charts.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>
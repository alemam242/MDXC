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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>User Dashboard | Mediterraneo Dx Club</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="dashboard.css"> <!-- Include your custom dashboard styles if any -->
    
    <style>
        .user-logo {
            width: 100px;
            height: 100px;
            
        }

        .footer {
            float: left;
            text-align: center;
            margin-top: 10px;
            color: #6c757d;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Mediterraneo Dx Club</a>
    
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="logout.php"style="color: white;">Sign Out</a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <style>
        .container-fluid{
            background: rgb(142,149,195);
            background: linear-gradient(90deg, rgba(142,149,195,1) 0%, rgba(78,72,182,1) 21%, rgba(22,17,105,1) 50%, rgba(78,72,182,1) 80%, rgba(142,149,195,1) 100%);
        }
    </style>

</style>
    <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-dark sidebar" style="width: 150px; height: calc(100vh - 56px); overflow-y: auto;">
    <div class="sidebar-sticky">
    <div class="sidebar-sticky">
        <!-- Your sidebar content here -->
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <span data-feather="home"></span>
                    Dashboard <span class="sr-only">(current)</span>
                </a>
            </li>
            <!-- Add more menu items as needed -->
            <li class="nav-item">
                <a class="nav-link" href="upload.php">
                    <span data-feather="folder-plus"></span>
                    Upload ADI
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="view_files.php">
                    <span data-feather="printer"></span>
                    Files
                </a>
            </li>
        </ul>
    </div>
</nav>


        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2" style="color: white;">DASHBOARD</h1>
            </div>

            <!-- Your content here -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="background-color: #313A38; color:white" >
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
                            Admin Notices
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
        </main>
    </div>
</div>

<footer class="footer" style="background-color: #343a40; color: white;">
    &copy; <?php echo date("Y"); ?> MDXC Developed by <a href="https://onirbanbd.com/"style="color: white;">onirbanbd.com</a>
</footer>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="../../assets/js/vendor/popper.min.js"></script>
<script src="../../dist/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>feather.replace()</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>

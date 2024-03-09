<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Assuming you have established a database connection
require('../config.php');

// Fetch total user count
$query_total_users = "SELECT COUNT(*) AS total_users FROM `user`";
$result_total_users = mysqli_query($conn, $query_total_users);
$row_total_users = mysqli_fetch_assoc($result_total_users);
$total_users = $row_total_users['total_users'];

// Fetch total event count
$query_total_events = "SELECT COUNT(*) AS total_events FROM `events`";
$result_total_events = mysqli_query($conn, $query_total_events);
$row_total_events = mysqli_fetch_assoc($result_total_events);
$total_events = $row_total_events['total_events'];

// Fetch total adi file count
$query_total_files = "SELECT COUNT(*) AS total_files FROM `user_adfi_files`";
$result_total_files = mysqli_query($conn, $query_total_files);
$row_total_files = mysqli_fetch_assoc($result_total_files);
$total_files = $row_total_files['total_files'];

// Fetch total notice count
$query_total_notices = "SELECT COUNT(*) AS total_notices FROM `admin_notices`";
$result_total_notices = mysqli_query($conn, $query_total_notices);
$row_total_notices = mysqli_fetch_assoc($result_total_notices);
$total_notices = $row_total_notices['total_notices'];

// Fetch last 10 users
$query_last_users = "SELECT `call_sign`, `name`, `country` FROM `user` ORDER BY `create_date` DESC LIMIT 10";
$result_last_users = mysqli_query($conn, $query_last_users);

// Fetch last 10 events
$query_last_events = "SELECT `event_name` FROM `events` ORDER BY `create_date` DESC LIMIT 10";
$result_last_events = mysqli_query($conn, $query_last_events);

// Fetch last 10 uploaded adi files
$query_last_files = "SELECT `u`.`call_sign`, `e`.`event_name`, `uaf`.`file_name`
                     FROM `user_adfi_files` AS `uaf`
                     INNER JOIN `user` AS `u` ON `u`.`id` = `uaf`.`user_id`
                     INNER JOIN `events` AS `e` ON `e`.`id` = `uaf`.`event_id`
                     ORDER BY `uaf`.`upload_date` DESC LIMIT 10";
$result_last_files = mysqli_query($conn, $query_last_files);

// Fetch last 10 notices
$query_last_notices = "SELECT `title` FROM `admin_notices` ORDER BY `create_date` DESC LIMIT 10";
$result_last_notices = mysqli_query($conn, $query_last_notices);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 56px; /* Adjust according to your navbar height */
            background-color: #f8f9fa;
        }

        .sidebar {
            position: fixed;
            top: 56px; /* Height of the navbar */
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 68px 0 0; /* Increased padding to match the navbar and footer */
            background-color: #343a40; /* Sidebar background color */
            color: white;
            width: 200px; /* Width of the sidebar */
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #343a40;
            color: white;
            text-align: center;
           
        }

        .content {
            margin-left: 220px; /* Increased margin to accommodate the wider sidebar */
            padding: 20px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Logout</a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="view_users.php">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Products</a>
            </li>
            <!-- Add more sidebar items here -->
        </ul>
    </div>

    <!-- Page content -->
    <div class="content">
        <h1>Welcome to the Admin Dashboard</h1>
        <!-- Add your dashboard content here -->
    </div>
<div class="container mt-5">
    <h2>User Dashboard</h2>
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Users: <?php echo $total_users; ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Events: <?php echo $total_events; ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total ADI Files: <?php echo $total_files; ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Notices: <?php echo $total_notices; ?></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Last 10 Users
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php
                        while ($row = mysqli_fetch_assoc($result_last_users)) {
                            echo '<li class="list-group-item">' . $row['call_sign'] . ' - ' . $row['name'] . ' - ' . $row['country'] . '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Last 10 Events
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php
                        while ($row = mysqli_fetch_assoc($result_last_events)) {
                            echo '<li class="list-group-item">' . $row['event_name'] . '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Last 10 Uploaded ADI Files
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php
                        while ($row = mysqli_fetch_assoc($result_last_files)) {
                            echo '<li class="list-group-item">' . $row['call_sign'] . ' - ' . $row['event_name'] . ' - ' . $row['file_name'] . '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Last 10 Notices
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php
                        while ($row = mysqli_fetch_assoc($result_last_notices)) {
                            echo '<li class="list-group-item">' . $row['title'] . '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</br>
    <!-- Footer -->
    <footer class="footer">
        &copy; <?php echo date("Y"); ?> MDXC. All rights reserved.
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

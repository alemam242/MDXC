<?php
ob_start();
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Assuming you have established a database connection
require('../config.php');

$query_events = "SELECT * FROM `events`";
$result_events = mysqli_query($conn, $query_events);

// Fetch user call signs from the database
$query_callsigns = "SELECT DISTINCT `call_sign` FROM `user`";
$result_callsigns = mysqli_query($conn, $query_callsigns);
?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard | MDXC ADI Management System</title>
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
                <div class="container-fluid">
                    <div class="page-title">
                        <h3>Event QSO List</h3>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="content">
                                    <div class="head">
                                        <h5 class="mb-0"> Export Event QSO List</h5> 
                                        <!--<p class="text-muted">Current year website visitor data</p>-->
                                    </div>
                                    <div class="canvas-wrapper">
    <form method="post" action="qso_data.php">
        <div class="form-group">
             <label for="event_id">Select Event:</label>
            <select class="form-control" name="event_id" id="event_id">
            <?php
            echo "<option value=''>Select One</option>";
            // Loop through each event and create an option element
            while ($row = mysqli_fetch_assoc($result_events)) {
                
                echo '<option value="' . $row['id'] . '">' . $row['event_name'] . '</option>';
            }
            ?>
        </select>
        </div>

        <button type="submit" class="btn btn-primary">Find Data</button>
    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>
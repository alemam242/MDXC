<?php
ob_start();
session_start();
require('../config.php'); // Assuming you have a config.php file for database connection

// Check if the user is not logged in, redirect to login screen
if (!isset($_SESSION['user_id']) || !isset($_SESSION['sitename']) || !isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit();
}

$user_id=$_SESSION['user_id'];
// Fetch QSL records with event names from the database
$query_qsl = "SELECT q.*, e.event_name 
              FROM user_qsl q 
              INNER JOIN events e ON q.event_id = e.id 
              WHERE q.user_id = '$user_id'";
$result_qsl = mysqli_query($conn, $query_qsl);
?>
<html lang="en"> 

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>QSO List | MDXC ADI Management System</title> 
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
                            <div class="page-pretitle">Your</div>
                            <h2 class="page-title">QSO List</h2>
                        </div>
                    </div>
                   
                </div>
            </div>
            
           <div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                The QSL's you added
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-hover" id="dataTables-example" width="100%">
                    <thead>
                        <tr>
                            <th>Dx-pedition</th>
                            <th>User ID</th>
                            <th>Call</th>
                            <th>Band</th>
                            <th>Mode</th>
                            <th>QSO Date</th>
                            <th>Time On</th>
                            <th>Frequency</th>
                            <th>Operator</th>
                            <th>RST Sent</th>
                            <th>Status</th>
                            <th>Creation Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result_qsl)) {
                            echo "<tr>";
                            echo "<td>{$row['event_name']}</td>";
                            echo "<td>{$row['user_id']}</td>";
                            echo "<td>{$row['call']}</td>";
                            echo "<td>{$row['band']}</td>";
                            echo "<td>{$row['mode']}</td>";
                            echo "<td>{$row['qso_date']}</td>";
                            echo "<td>{$row['time_on']}</td>";
                            echo "<td>{$row['freq']}</td>";
                            echo "<td>{$row['operator']}</td>";
                            echo "<td>{$row['rst_sent']}</td>";
                            echo "<td>{$row['status']}</td>";
                            echo "<td>{$row['creat_date']}</td>";
                            echo "<td><a href='qso_update.php?id={$row['id']}' class='btn btn-primary'>Update</a></td>";
                            
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/datatables/datatables.min.js"></script>
    <script src="assets/js/initiate-datatables.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>
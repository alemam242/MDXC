<?php
ob_start();
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
// Include database connection file
require_once('../config.php');

// Fetch QSL records with event names from the database
$query_qsl = "SELECT user_qsl.*, events.event_name FROM user_qsl INNER JOIN events ON user_qsl.event_id = events.id";
$result_qsl = mysqli_query($conn, $query_qsl);
?>
<html lang="en"> 

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>QSL List | MDXC ADI Management System</title>
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
                            <h2 class="page-title">QSL List</h2>
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
                            <th>Event Name</th>
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result_qsl)) {
                            echo "<tr>";
                            echo "<td>{$row['event_name']}</td>";
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
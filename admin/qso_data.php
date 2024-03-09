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

$selected_event_id = $_POST['event_id'] ?? '';

// Fetch QSO data based on the selected event ID
$query = "SELECT * FROM user_qsl WHERE event_id = '$selected_event_id'";
$result = mysqli_query($conn, $query);

// Initialize an empty array to store QSO data
$qso_data = [];

// Fetch data rows from the result set
while ($row = mysqli_fetch_assoc($result)) {
    // Add each row to the QSO data array
    $qso_data[] = $row;
}

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
                            <th>Call</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Mode</th>
                            <th>Band</th>
                            <th>Operator</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($qso_data as $qso) : ?>
            <tr>
                <td><?php echo $qso['call']; ?></td>
                <td><?php echo $qso['qso_date']; ?></td>
                <td><?php echo $qso['time_on']; ?></td>
                <td><?php echo $qso['mode']; ?></td>
                <td><?php echo $qso['band']; ?></td>
                <td><?php echo $qso['operator']; ?></td>
            </tr>
        <?php endforeach; ?>
                </table>
                    <a class="btn btn-primary" href='get_adi.php?event_id=<?php echo $selected_event_id; ?>'> Download The Adi File</a> ||  <a class="btn btn-primary" href='get_txt.php?event_id=<?php echo $selected_event_id; ?>'> Download The TXT File</a>
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
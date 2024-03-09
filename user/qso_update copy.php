<?php
ob_start();
session_start();
require('../config.php'); // Assuming you have a config.php file for database connection

// Check if the user is not logged in, redirect to login screen
if (!isset($_SESSION['user_id']) || !isset($_SESSION['sitename']) || !isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit();
}

// Check if the QSL ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: view_qsl.php"); // Redirect to the QSL view page if ID is not provided
    exit();
}

// Fetch QSL record details based on the provided ID
$qsl_id = $_GET['id'];
$query_qsl = "SELECT * FROM user_qsl WHERE id = $qsl_id";
$result_qsl = mysqli_query($conn, $query_qsl);
$row = mysqli_fetch_assoc($result_qsl);

// Handle form submission to update QSL record
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $call = $_POST['call'];
    $band = $_POST['band'];
    $mode = $_POST['mode'];
    $qso_date = $_POST['qso_date'];
    $time_on = $_POST['time_on'];
    // $freq = $_POST['freq'];
    $operator = $_POST['operator'];
    $rst_sent = $_POST['rst_sent'];

    // Update the QSL record in the database
    $query_update = "UPDATE `user_qsl` 
                 SET `call` = '$call', `band` = '$band', `mode` = '$mode', `qso_date` = '$qso_date', `time_on` = '$time_on', 
                      `operator` = '$operator', `rst_sent` = '$rst_sent' 
                 WHERE `id` = $qsl_id";

    $result_update = mysqli_query($conn, $query_update);

    if ($result_update) {
        $success_message = "QSO record updated successfully!";
    } else {
        $error_message = "Error updating QSO record. Please try again.";
    }
}
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add QSO | MDXC ADI Management System</title>
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
                            <div class="page-pretitle">Dx-pedition</div>
                            <h2 class="page-title">Add QSO Record</h2>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            Add QSO Record
                        </div>
                        <div class="card-body">
                            <?php
                            if (isset($success_message)) {
                                echo '<div class="alert alert-success">' . $success_message . '</div>';
                            } elseif (isset($error_message)) {
                                echo '<div class="alert alert-danger">' . $error_message . '</div>';
                            }
                            ?>
                            <form method="post">
                                <div class="form-group">
                                    <label for="call">DXpeidtion Call:</label>
                                    <input type="text" class="form-control" id="call" name="call" value="<?php echo $row['call']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="band">Band:</label>
                                    <input type="text" class="form-control" id="band" name="band" value="<?php echo $row['band']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="mode">Mode:</label>
                                    <input type="text" class="form-control" id="mode" name="mode" value="<?php echo $row['mode']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="qso_date">QSO Date:</label>
                                    <input type="date" class="form-control" id="qso_date" name="qso_date" value="<?php echo $row['qso_date']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="time_on">Time On:</label>
                                    <input type="time" class="form-control" id="time_on" name="time_on" value="<?php echo $row['time_on']; ?>" required>
                                </div>
                                <!--<div class="form-group">-->
                                <!--    <label for="freq">Frequency:</label>-->
                                <!--    <input type="text" class="form-control" id="freq" name="freq" value="<?php //echo $row['freq']; 
                                                                                                                ?>" required>-->
                                <!--</div>-->
                                <div class="form-group">
                                    <label for="operator">Operator:</label>
                                    <input type="text" class="form-control" id="operator" name="operator" value="<?php echo $row['operator']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="rst_sent">RST Sent:</label>
                                    <input type="text" class="form-control" id="rst_sent" name="rst_sent" value="<?php echo $row['rst_sent']; ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update QSO Record</button>
                            </form>
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
<?php
ob_start();
session_start();
require('../config.php'); // Assuming you have a config.php file for database connection

// Check if the user is not logged in, redirect to login screen
if (!isset($_SESSION['user_id']) || !isset($_SESSION['sitename']) || !isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit();
}

// Fetch events from the database
$query_events = "SELECT * FROM `events`";
$result_events = mysqli_query($conn, $query_events);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $event_id = $_POST['event_id'];
    $call = $_POST['call'];
    $band = $_POST['band'];
    $mode = $_POST['mode'];
    $qso_date = $_POST['qso_date'];
    $time_on = $_POST['time_on'];
    //$freq = $_POST['freq'];
    $operator = $_POST['operator'];
    $rst_sent = $_POST['rst_sent'];
    $status = '1';

    $create_date = date("Y-m-d H:i:s");

    // Insert QSL record into the database
    $query_insert_qsl = "INSERT INTO `user_qsl` (`event_id`, `user_id`, `call`, `band`, `mode`, `qso_date`, `time_on`, `freq`, `operator`, `rst_sent`, `status`)
                         VALUES ('$event_id', '$user_id', '$call', '$band', '$mode', '$qso_date', '$time_on', '0000', '$operator', '$rst_sent', '$status')";
    $result_insert_qsl = mysqli_query($conn, $query_insert_qsl);

    if ($result_insert_qsl) {
        $success_message = "QSO record added successfully!";
    } else {
        $error_message = "Error adding QSO record. Please try again. ";
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
                            <div class="page-pretitle">DXpeidtion</div>
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
                        <label for="event_id">Select Dx-pedition:</label>
                        <select class="form-control" id="event_id" name="event_id" required>
                            <?php
                            while ($row = mysqli_fetch_assoc($result_events)) {
                                echo '<option value="' . $row['id'] . '">' . $row['event_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="call">DXpeidtion Call:</label>
                            <input type="text" class="form-control" id="call" name="call" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="band">Band:</label>
                            <select class="form-control" id="band" name="band" required>
                                <option>160m</option>
                                <option>80m</option>
                                <option>60m</option>
                                <option>40m</option>
                                <option>30m</option>
                                <option>20m</option>
                                <option>17m</option>
                                <option>15m</option>
                                <option>12m</option>
                                <option>10m</option>
                                <option>6m</option>
                                <option>4m</option>
                                <option>2m</option>
                                <option>70cm</option>
                                <option>23cm</option>
                                <!-- Add more bands as needed -->
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="mode">Mode:</label>
                            <select class="form-control" id="mode" name="mode" required>
                                <option>SSB</option>
                                <option>CW</option>
                                <option>AM</option>
                                <option>FM</option>
                                <option>RTTY</option>
                                <option>FT8</option>
                                <option>PSK31</option>
                                <option>JT65</option>
                                <option>JT9</option>
                                <!-- Add more modes as needed -->
                            </select>
                        </div>
                        <!--<div class="form-group col-md-6">-->
                        <!--    <label for="freq">Frequency:</label>-->
                        <!--    <input type="text" class="form-control" id="freq" name="freq" required>-->
                        <!--</div>-->
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="qso_date">QSO Date:</label>
                            <input type="date" class="form-control" id="qso_date" name="qso_date" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="time_on">Time On:</label>
                            <input type="time" class="form-control" id="time_on" name="time_on" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="rst_sent">RST Sent:</label>
                            <input type="text" class="form-control" id="rst_sent" name="rst_sent" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="operator">Your Call:</label>
                            <!-- Assuming you'll retrieve operator from the logged-in user -->
                            <input type="text" class="form-control" id="operator" name="operator" value="<?php echo $_SESSION['operator']; ?>" readonly>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Add QSO</button>
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
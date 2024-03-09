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
    $freq = $_POST['freq'];
    $operator = $_POST['operator'];
    $rst_sent = $_POST['rst_sent'];
    $status = $_POST['status'];

    $create_date = date("Y-m-d H:i:s");

    // Insert QSL record into the database
    $query_insert_qsl = "INSERT INTO `user_qsl` (`event_id`, `user_id`, `call`, `band`, `mode`, `qso_date`, `time_on`, `freq`, `operator`, `rst_sent`, `status`, `creat_date`)
                         VALUES ('$event_id', '$user_id', '$call', '$band', '$mode', '$qso_date', '$time_on', '$freq', '$operator', '$rst_sent', '$status', '$create_date')";
    $result_insert_qsl = mysqli_query($conn, $query_insert_qsl);

    if ($result_insert_qsl) {
        $success_message = "QSL record added successfully!";
    } else {
        $error_message = "Error adding QSL record. Please try again. ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add QSL | Mediterraneo Dx Club</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
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
            <a class="nav-link" href="logout.php" style="color: white;">Sign Out</a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-dark sidebar" style="width: 100px; height: calc(100vh - 56px); overflow-y: auto;">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    Dashboard 
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="upload_adi.php">
                    Upload ADI
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    Add QSL<span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="view_files.php">
                    Files
                </a>
            </li>
        </ul>
    </div>
</nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Add QSL</h1>
            </div>

            <!-- Your content here -->
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            Add QSL Record
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
                                    <label for="event_id">Select Event:</label>
                                    <select class="form-control" id="event_id" name="event_id" required>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result_events)) {
                                            echo '<option value="' . $row['id'] . '">' . $row['event_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="call">Call:</label>
                                    <input type="text" class="form-control" id="call" name="call" required>
                                </div>
                                <div class="form-group">
                                    <label for="band">Band:</label>
                                    <input type="text" class="form-control" id="band" name="band" required>
                                </div>
                                <div class="form-group">
                                    <label for="mode">Mode:</label>
                                    <input type="text" class="form-control" id="mode" name="mode" required>
                                </div>
                                <div class="form-group">
                                    <label for="qso_date">QSO Date:</label>
                                    <input type="date" class="form-control" id="qso_date" name="qso_date" required>
                                </div>
                                <div class="form-group">
                                    <label for="time_on">Time On:</label>
                                    <input type="time" class="form-control" id="time_on" name="time_on" required>
                                </div>
                                <div class="form-group">
                                    <label for="freq">Frequency:</label>
                                    <input type="text" class="form-control" id="freq" name="freq" required>
                                </div>
                                <div class="form-group">
                                    <label for="operator">Operator:</label>
                                    <input type="text" class="form-control" id="operator" name="operator" required>
                                </div>
                                <div class="form-group">
                                    <label for="rst_sent">RST Sent:</label>
                                    <input type="text" class="form-control" id="rst_sent" name="rst_sent" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Add QSL</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<footer class="footer" style="background-color: #343a40; color: white;">
    &copy; <?php echo date("Y"); ?> MDXC Developed by <a href="https://onirbanbd.com/">onirbanbd.com</a>
</footer>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="../../assets/js/vendor/popper.min.js"></script>
<script src="../../dist/js/bootstrap.min.js"></script>
</body>
</html>

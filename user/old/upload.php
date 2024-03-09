<?php
ob_start();
session_start();
require('../config.php'); // Assuming you have a config.php file for database connection

// Check if the user is not logged in, redirect to login screen
if (!isset($_SESSION['user_id']) || !isset($_SESSION['sitename']) || !isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit();
}

$upload_date = date("Y-m-d H:i:s");

// Fetch events from the database
$query_events = "SELECT * FROM `events`";
$result_events = mysqli_query($conn, $query_events);

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $event_id = $_POST['event_id'];

    $target_dir = "../uploads/";
    $file_name = basename($_FILES["adfi_file"]["name"]);
    
    // Fetch event name from database based on event_id
    $query_event_name = "SELECT `event_name` FROM `events` WHERE `id` = $event_id";
    $result_event_name = mysqli_query($conn, $query_event_name);
    $row_event_name = mysqli_fetch_assoc($result_event_name);
    $event_name = $row_event_name['event_name'];
    
    // Replace spaces in file name with underscores
    
    
    // Construct the new file name
    $new_file_name = $event_name . '_' . $file_name;
    $new_file_name = str_replace(' ', '_', $new_file_name);
    $target_file = $target_dir . $new_file_name;

    if (move_uploaded_file($_FILES["adfi_file"]["tmp_name"], $target_file)) {
        // File uploaded successfully, insert record into user_adfi_files table
        
        $status = 1; // Assuming 1 means success
        $comments = ""; // You can add comments if needed

        $query_insert = "INSERT INTO `user_adfi_files` (`user_id`, `file_name`, `event_id`, `upload_date`, `status`, `comments`)
                         VALUES ('$user_id', '$new_file_name', '$event_id', '$upload_date', '$status', '$comments')";
        $result_insert = mysqli_query($conn, $query_insert);

        if ($result_insert) {
            $success_message = "File uploaded successfully!";
        } else {
            $error_message = "Error uploading file. Please try again.";
        }
    } else {
        $error_message = "Error uploading file. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Upload ADI | Mediterraneo Dx Club</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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


    <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-dark sidebar" style="width: 100px; height: calc(100vh - 56px); overflow-y: auto;">
    <div class="sidebar-sticky">
    <div class="sidebar-sticky">
        <!-- Your sidebar content here -->
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <span data-feather="home"></span>
                    Dashboard 
                </a>
            </li>
            <!-- Add more menu items as needed -->
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <span data-feather="folder-plus"></span>
                    Upload ADI<span class="sr-only">(current)</span>
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
                <h1 class="h2"style="color: white;">Upload Event ADI File</h1>
            </div>

            <!-- Your content here -->
            <div class="row">
            <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-header"style="background-color: #313A38; color:white">
                            Upload Your ADI File
                        </div>
                        <div class="card-body">
                            <?php
    if (isset($success_message)) {
        echo '<div class="alert alert-success">' . $success_message . '</div>';
    } elseif (isset($error_message)) {
        echo '<div class="alert alert-danger">' . $error_message . '</div>';
    }
    ?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="event_id">Select Event:</label>
            <select class="form-control" id="event_id" name="event_id" required>
                <?php
                while ($row = mysqli_fetch_assoc($result_events)) {
                    echo"<option>Select One</option>";
                    echo '<option value="' . $row['id'] . '">' . $row['event_name'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="adfi_file">Choose ADFI File:</label>
            <input type="file" class="form-control-file" id="adfi_file" name="adfi_file" accept=".adi" required>

        </div>
        <button type="submit" class="btn btn-primary">Upload File</button>
    </form>
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

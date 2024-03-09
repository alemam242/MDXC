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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $event_id = $_POST["event_id"];
    $event_name = $_POST["event_name"];
    $event_details = $_POST["event_details"];
    $status = $_POST["status"];

    // Update event in database
    $sql = "UPDATE events SET event_name='$event_name', event_deteails='$event_details', status='$status' WHERE id='$event_id'";
    if (mysqli_query($conn, $sql)) {
         $success_message = "Admin details updated successfully.";
        // Event updated successfully, redirect to view all events page
        header("Location: event_list.php");
        exit();
    } else {
        $error_message = "Something Went Wrong. Try Again ";
        // Error occurred while updating event
       // echo "Error: " . mysqli_error($conn);
    }
}

// Check if event ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $event_id = $_GET['id'];

    // Fetch event data from the database based on the event ID
    $sql = "SELECT * FROM events WHERE id='$event_id'";
    $result = mysqli_query($conn, $sql);

    // Check if event exists
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $event_name = $row['event_name'];
        $event_details = $row['event_deteails'];
        $status = $row['status'];
    } else {
        $error_message = "Something Went Wrong. Try Again ";
        // Error occurred while updating event
       echo "Error: " . mysqli_error($conn);
    }
} else {
  $error_message = "Something Went Wrong. Try Again ";
        // Error occurred while updating event
       echo "Error: " . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add Event | MDXC ADI Management System</title>
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
            <nav class="navbar navbar-expand-lg navbar-white bg-white">
                <button type="button" id="sidebarCollapse" class="btn btn-light">
                    <i class="fas fa-bars"></i><span></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent"></div>
            </nav>
            <div class="content">
                <div class="container-fluid">
                    <div class="page-title">
                        <h3>Update Event to collect QSO File</h3>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="content">
                            <div class="head">
                                <h5 class="mb-0">Update Event</h5> 
                            </div>
                            <div class="canvas-wrapper">
                                <?php if(isset($success_message)) { ?>
                                    <div class="alert alert-success" role="alert">
                                        <?php echo $success_message; ?>
                                    </div>
                                <?php } ?>
                                <?php if(isset($error_message)) { ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $error_message; ?>
                                    </div>
                                <?php } ?>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                            <div class="form-group">
                                <label for="event_name">Event Name</label>
                                <input type="text" class="form-control" id="event_name" name="event_name" value="<?php echo $event_name; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="event_details">Event Details</label>
                                <textarea class="form-control" id="event_details" name="event_details" rows="5" required><?php echo $event_details; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="active" <?php if ($status == 'active') echo 'selected'; ?>>Active</option>
                                    <option value="inactive" <?php if ($status == 'inactive') echo 'selected'; ?>>Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
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


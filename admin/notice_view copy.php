<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Include database connection file
require_once('../config.php');

// Check if notice ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch notice data from the database based on the notice ID
    $sql = "SELECT * FROM admin_notices WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    // Check if notice exists
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
        $content = $row['content'];
        $create_date = $row['create_date'];
    } else {
        // Redirect to error page if notice doesn't exist
        header("Location: error.php");
        exit();
    }
} else {
    // Redirect to error page if notice ID is not provided or invalid
    header("Location: error.php");
    exit();
}

// Close database connection
mysqli_close($conn);
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Notice | MDXC ADI Management System</title>
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
                        <h3>Notice View</h3>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                        <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3><?php echo $title; ?></h3>
                    </div>
                    <div class="card-body">
                        <p><?php echo $content; ?></p>
                        <p><strong>Created Date:</strong> <?php echo $create_date; ?></p>
                    </div>
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
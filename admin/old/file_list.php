<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Include database connection file
require_once('../config.php');

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch file list data from the database
$sql = "SELECT uaf.id, e.event_name, u.call_sign, uaf.file_name, uaf.upload_date 
        FROM user_adfi_files uaf
        JOIN user u ON uaf.user_id = u.id
        JOIN events e ON uaf.event_id = e.id
        LIMIT $start, $limit";
$result = mysqli_query($conn, $sql);

// Fetch total records for pagination
$total_records = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user_adfi_files"));

// Close database connection
mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>File List | MDXC ADI Management System</title>
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/datatables/datatables.min.css" rel="stylesheet">
    <link href="assets/css/master.css" rel="stylesheet">
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
                <div class="collapse navbar-collapse" id="navbarSupportedContent"></div>
            </nav>
            <!-- end of navbar navigation -->
            <div class="content">
                <div class="container-fluid">
                    <div class="page-title">
                        <h2>File List uploaded by Users</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="content">
                            <div class="head">
                                <h5 class="mb-0">File List</h5> 
                            </div>
                            <table class="table table-hover" id="dataTables-example" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Event</th>
                    <th>Callsign</th>
                    <th>File</th>
                    <th>Upload Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $count = $start + 1;
                while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row['event_name']; ?></td>
                        <td><a href="view_user.php?id=<?php echo $row['user_id']; ?>"><?php echo $row['call_sign']; ?></a></td>
                        <td><?php echo $row['file_name']; ?></td>
                        <td><?php echo $row['upload_date']; ?></td>
                        <td><a href="../uploads/<?php echo $row['file_name']; ?>" class="btn btn-primary" download>Download</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
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


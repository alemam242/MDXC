<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Include your database connection file
require('../config.php');

// Check if admin ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $admin_id = $_GET['id'];

    // Fetch admin data from the database based on the admin ID
    $query = "SELECT * FROM `admin` WHERE `id` = $admin_id";
    $result = mysqli_query($conn, $query);

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Admin Details | MDXC ADI Management System</title>
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
                            <h3>Admin Details</h3>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="content">
                                <div class="head">
                                    <h5 class="mb-0">Admin Information</h5> 
                                </div>
                                <?php
                                if (mysqli_num_rows($result) == 1) {
                                    $admin_data = mysqli_fetch_assoc($result);
                                    ?>
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th>Username</th>
                                                <td><?php echo $admin_data['username']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Password</th>
                                                <td><?php echo $admin_data['password']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td><?php echo $admin_data['email']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Callsign</th>
                                                <td><?php echo $admin_data['callsign']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Name</th>
                                                <td><?php echo $admin_data['name']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td><?php echo $admin_data['address']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Country</th>
                                                <td><?php echo $admin_data['country']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td><?php echo $admin_data['phone']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td><?php echo $admin_data['status']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Comments</th>
                                                <td><?php echo $admin_data['comments']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Action</th>
                                                <td><a href='admin_list.php' class='btn btn-primary'>Go Back</a><a href='admin_update.php?id=<?php echo $admin_data['id']; ?>' class='btn btn-success'>Update</a></td>
                                            </tr>
                                             
                                        </tbody>
                                    </table>
                                <?php } else {
                                    echo '<div class="alert alert-danger mt-3" role="alert">Admin not found!</div>';
                                }
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Invalid admin ID!</div>';
                            }

                            // Close database connection
                            mysqli_close($conn);
                            ?>
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

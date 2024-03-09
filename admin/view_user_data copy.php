<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
// Include your database connection file
require('../config.php');

// Check if user ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch user data from the database based on the user ID
    $query = "SELECT * FROM `user` WHERE `id` = $user_id";
    $result = mysqli_query($conn, $query);

?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard | MDXC ADI Management System</title>
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
                        <h3>User Table</h3>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="content">
                                    <div class="head">
                                        <h5 class="mb-0"> User Information Table</h5> 
                                        <!--<p class="text-muted">Current year website visitor data</p>-->
                                    </div>
                                    <?php
                                        if (mysqli_num_rows($result) == 1) {
        $user_data = mysqli_fetch_assoc($result);
        ?>
                                   <table class="table table-striped">
                                            <thead class="success">
                                                <tr>
                    <th>Name</th>
                    <td><?php echo $user_data['name']; ?></td>
                </tr>
                <tr>
                    <th>Call Sign</th>
                    <td><?php echo $user_data['call_sign']; ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo $user_data['email']; ?></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><?php echo $user_data['phone']; ?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?php echo $user_data['address']; ?></td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td><?php echo $user_data['country']; ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><?php echo $user_data['status']; ?></td>
                </tr>
                <tr>
                    <th>Action</th>
                    <td> <a href="update_user.php?id=<?php echo $user_data['id']; ?>">Update</a></td>
                </tr>
                                            </thead>
                                        </table>
                                            <?php } else {
        echo '<div class="alert alert-danger mt-3" role="alert">User not found!</div>';
    }
} else {
    echo '<div class="alert alert-danger mt-3" role="alert">Invalid user ID!</div>';
}

// Close database connection
mysqli_close($conn);?>
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
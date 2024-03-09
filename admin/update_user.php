<?php
ob_start();
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Assuming you have established a database connection
require('../config.php');

// Check if user ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch user data from the database based on the user ID
    $query = "SELECT * FROM `user` WHERE `id` = $user_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user_data = mysqli_fetch_assoc($result);

        // Check if the update form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Escape user inputs for security
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $call_sign = mysqli_real_escape_string($conn, $_POST['call_sign']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $phone = mysqli_real_escape_string($conn, $_POST['phone']);
            $address = mysqli_real_escape_string($conn, $_POST['address']);
            $country = mysqli_real_escape_string($conn, $_POST['country']);
            $status = mysqli_real_escape_string($conn, $_POST['status']);

            // Update user data in the database
            $update_query = "UPDATE `user` SET
                             `name` = '$name',
                             `call_sign` = '$call_sign',
                             `email` = '$email',
                             `phone` = '$phone',
                             `address` = '$address',
                             `country` = '$country',
                             `status` = '$status'
                             WHERE `id` = $user_id";

            if (mysqli_query($conn, $update_query)) {
                echo '<div class="alert alert-success mt-3" role="alert">User information updated successfully!</div>';
                // Redirect to user view page after updating
                header("Location: view_user_data.php?id=$user_id");
                exit();
            } else {
                echo '<div class="alert alert-danger mt-3" role="alert">Error updating user information: ' . mysqli_error($conn) . '</div>';
            }
        }
    } else {
        echo '<div class="alert alert-danger mt-3" role="alert">User not found!</div>';
    }
} else {
    echo '<div class="alert alert-danger mt-3" role="alert">Invalid user ID!</div>';
}

// Close database connection
mysqli_close($conn);
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
                        <h3>Update User Information</h3>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="content">
                                    <div class="head">
                                        <h5 class="mb-0"> Update data of <?php echo $user_data['call_sign']; ?></h5> 
                                        <!--<p class="text-muted">Current year website visitor data</p>-->
                                    </div>
                                    <div class="canvas-wrapper">
                                        <form method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $user_data['name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="call_sign">Call Sign:</label>
            <input type="text" class="form-control" id="call_sign" name="call_sign" value="<?php echo $user_data['call_sign']; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user_data['email']; ?>" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user_data['phone']; ?>" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" name="address" value="<?php echo $user_data['address']; ?>" required>
        </div>
        <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" class="form-control" id="country" name="country" value="<?php echo $user_data['country']; ?>" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Active" <?php if ($user_data['status'] == 'Active') echo 'selected'; ?>>Active</option>
                <option value="Inactive" <?php if ($user_data['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
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
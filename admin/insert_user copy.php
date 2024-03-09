<?php
require_once '../config.php';
ob_start();
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
?>
<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $call_sign = mysqli_real_escape_string($conn, $_POST['call_sign']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $create_by = mysqli_real_escape_string($conn, $_SESSION['admin_id']);

    // Insert user data into the database
    $query = "INSERT INTO `user` (`name`, `call_sign`, `email`, `phone`, `address`, `country`, `password`, `status`, `create_by`)
              VALUES ('$name', '$call_sign', '$email', '$phone', '$address', '$country', '$password', '$status','$create_by')";
    if (mysqli_query($conn, $query)) {
        $msgg = '<div class="alert alert-success mt-3" role="alert">User added successfully!</div>';
        header("Location: view_users.php");
        exit();
    } else {
        $msgg = '<div class="alert alert-danger mt-3" role="alert">Something Went Wrong Try Again</div>';
    }

    // Close database connection
    mysqli_close($conn);
}
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
                        <h3>Add New User to the system</h3>
                    </div>
                </div>
            </div>
            <?php if (isset($msgg) && $msgg != '') {
                echo $msgg;
            } ?>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="content">
                            <div class="head">
                                <h5 class="mb-0"> Add New User</h5>
                                <!--<p class="text-muted">Current year website visitor data</p>-->
                            </div>
                            <div class="canvas-wrapper">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="call_sign">Call Sign:</label>
                                        <input type="text" class="form-control" id="call_sign" name="call_sign" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone:</label>
                                        <input type="text" class="form-control" id="phone" name="phone" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address:</label>
                                        <input type="text" class="form-control" id="address" name="address" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="country">Country:</label>
                                        <input type="text" class="form-control" id="country" name="country" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status:</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
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
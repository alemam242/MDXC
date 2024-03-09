<?php
require_once '../config.php';
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Check if admin ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$admin_id = $_GET['id'];

// Fetch admin details from the database
$sql = "SELECT * FROM admin WHERE id = '$admin_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    // If admin not found, redirect to admin_dashboard.php
    header("Location: admin_dashboard.php");
    exit();
}

$admin = mysqli_fetch_assoc($result);

// Update admin details in the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extracting form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $callsign = $_POST['callsign'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];
    $status = $_POST['status'];
    $comments = $_POST['comments'];

    // Updating data in the database
    $update_sql = "UPDATE admin SET 
                    username = '$username',
                    password = '$password',
                    email = '$email',
                    callsign = '$callsign',
                    name = '$name',
                    address = '$address',
                    country = '$country',
                    phone = '$phone',
                    status = '$status',
                    comments = '$comments'
                    WHERE id = '$admin_id'";

    if (mysqli_query($conn, $update_sql)) {
        $success_message = "Admin details updated successfully.";
    } else {
        $error_message = "Something Went Wrong. Try Again ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Update Admin | MDXC ADI Management System</title>
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
                        <h3>Update Admin Details</h3>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="content">
                            <div class="head">
                                <h5 class="mb-0">Update Admin</h5> 
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
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $admin_id; ?>" method="POST">
                                    <div class="form-group">
                                        <label for="username">Username:</label>
                                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $admin['username']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <input type="password" class="form-control" id="password" name="password" value="<?php echo $admin['password']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $admin['email']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="callsign">Callsign:</label>
                                        <input type="text" class="form-control" id="callsign" name="callsign" value="<?php echo $admin['callsign']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $admin['name']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address:</label>
                                        <input type="text" class="form-control" id="address" name="address" value="<?php echo $admin['address']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="country">Country:</label>
                                        <input type="text" class="form-control" id="country" name="country" value="<?php echo $admin['country']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone:</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $admin['phone']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status:</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="active" <?php if($admin['status'] == 'active') echo 'selected'; ?>>Active</option>
                                            <option value="inactive" <?php if($admin['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="comments">Comments:</label>
                                        <input type="text" class="form-control" id="comments" name="comments" value="<?php echo $admin['comments']; ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="submit">Update</button>
                                    <a href='admin_view_data.php?id=<?php echo $admin['id']?>' class='btn btn-primary'>Go Back</a>
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

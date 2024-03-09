<?php
session_start();

if (isset($_SESSION['admin_id'])) {
    header("Location: ./admin_dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    require('../config.php');

    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute query
    $query = "SELECT * FROM `admin` WHERE `username` = '$username' AND `password` = '$password'";
    $result = mysqli_query($conn, $query);

    // Check if a matching admin is found
    if (mysqli_num_rows($result) == 1) {
        // Admin found, set session variables
        $admin = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];

        // Redirect to admin dashboard or any other page
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // No matching admin found, show error message
        $error_message = "Invalid username or password";
    }

    // Close database connection
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin | Login | MDXC</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/animate.min.css" rel="stylesheet" />
    <link href="../assets/css/fontawesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link href="../assets/css/toastify.min.css" rel="stylesheet" />
    <script src="../assets/js/toastify-js.js"></script>
    <script src="../assets/js/axios.min.js"></script>
    <script src="../assets/js/config.js"></script>
</head>

<body style="background: #E5FCFF;">

    <div id="loader" class="LoadingOverlay d-none">
        <div class="Line-Progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <div>
        <!-- Main Content -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
                    <div class="card w-90  p-4">
                        <div class="card-body">
                            <?php if (isset($error_message)) { ?>
                                <div class="alert alert-danger fade show" role="alert">
                                    <h6 class="text-light">Invalid username or password!</h6>
                                </div>
                            <?php } ?>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="FALSE">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h4>ADMIN PANEL | LOGIN</h4>
                                    </div>
                                </div>
                                <br />
                                <input id="username" name="username" placeholder="username" class="form-control input-field" type="text" required />
                                <br />
                                <input placeholder="Password" class="form-control input-field" type="password" id="password" name="password" required />
                                <br />
                                <button class="btn w-100 bg-gradient-info">Login</button>
                                <hr />
                            </form>
                        </div>
                        <div class="row text-muted">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        &copy; <?php echo date('Y'); ?> MDXC
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 text-center">
                                        <spqan>Developed by </spqan>
                                        <a href="https://onirbanbd.com/" style="color: white;">
                                            <img src="../images/logo-dark.png" style="height:25px" alt="Onirban Bangladesh Technology"> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>

    <script src="../assets/js/bootstrap.bundle.js"></script>

</body>

</html>
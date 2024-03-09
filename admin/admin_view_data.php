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


<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>View Admin | MDXC ADI Management System</title>

    <!-- <link rel="icon" type="image/x-icon" href="../assets//favicon.ico" /> -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/animate.min.css" rel="stylesheet" />
    <link href="../assets/css/fontawesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link href="../assets/css/toastify.min.css" rel="stylesheet" />


    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <link href="../assets/css/jquery.dataTables.min.css" rel="stylesheet" />
    <script src="../assets/js/jquery-3.7.0.min.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>


    <script src="../assets/js/toastify-js.js"></script>
    <script src="../assets/js/axios.min.js"></script>
    <script src="../assets/js/config.js"></script>
    <script src="../assets/js/bootstrap.bundle.js"></script>
</head>

<body>

    <div id="loader" class="LoadingOverlay d-none">
        <div class="Line-Progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <!-- Header -->
    <?php
    include('include/header.php')
    ?>


    <!-- Navbar -->
    <?php include('menu.php') ?>

    <div id="contentRef" class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box align-items-center justify-content-between p-2">
                        <h4 class="mb-sm-0">View Admin</h4>
                        <div class="">
                            <span class="mb-sm-0"></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-4">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="h6 card-header text-uppercase">
                            Admin Information
                        </div>
                        <div class="card-body">
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
                                                <td><a href='admin_list.php' class='btn btn-primary me-2'>Go Back</a><a href='admin_update.php?id=<?php echo $admin_data['id']; ?>' class='btn btn-success'>Update</a></td>
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
    </div>



    <script>
        showLoader();

        function MenuBarClickHandler() {
            let sideNav = document.getElementById('sideNavRef');
            let content = document.getElementById('contentRef');
            if (sideNav.classList.contains("side-nav-open")) {
                sideNav.classList.add("side-nav-close");
                sideNav.classList.remove("side-nav-open");
                content.classList.add("content-expand");
                content.classList.remove("content");
            } else {
                sideNav.classList.remove("side-nav-close");
                sideNav.classList.add("side-nav-open");
                content.classList.remove("content-expand");
                content.classList.add("content");
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            hideLoader();

            // Reset the form
            $("#resetButton").click(function(e) {
                e.preventDefault();
                $("#successAlert").addClass('d-none');
                $("#errorAlert").addClass('d-none');
                $("#myForm")[0].reset();
            });




        });
    </script>

</body>

</html>
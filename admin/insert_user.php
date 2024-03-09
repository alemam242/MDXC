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
    $create_by= mysqli_real_escape_string($conn, $_SESSION['admin_id']);

                // Insert user data into the database
    $query = "INSERT INTO `user` (`name`, `call_sign`, `email`, `phone`, `address`, `country`, `password`, `status`, `create_by`)
              VALUES ('$name', '$call_sign', '$email', '$phone', '$address', '$country', '$password', '$status','$create_by')";
    if (mysqli_query($conn, $query)) {
        $success_message = "New user added successfully.";
        header("Location: view_users.php");
        exit();
    } else {
        $error_message = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}
?>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add New User | MDXC ADI Management System</title>

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
                        <h4 class="mb-sm-0">User List</h4>
                        <div class="">
                            <span class="mb-sm-0">Add New User</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-4">
                <div class="col-md-10 mx-auto">
                    <div class="card">
                        <div class="h6 card-header text-uppercase">
                            Add New Record
                        </div>
                        <div class="card-body">
                            <?php
                            if (isset($success_message)) {
                                echo '<div class="alert alert-success text-light" id="successAlert">' . $success_message . '</div>';
                            } elseif (isset($error_message)) {
                                echo '<div class="alert alert-danger text-light" is="errorAlert">' . $error_message . '</div>';
                            }
                            ?>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="row">
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="name">Name:</label>
                                        <input type="text" class="form-control input-field" id="name" name="name" required>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="call_sign">Call Sign:</label>
                                        <input type="text" class="form-control input-field" id="call_sign" name="call_sign" required>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control input-field" id="email" name="email" required>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="phone">Phone:</label>
                                        <input type="text" class="form-control input-field" id="phone" name="phone" required>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="address">Address:</label>
                                        <input type="text" class="form-control input-field" id="address" name="address" required>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="country">Country:</label>
                                        <input type="text" class="form-control input-field" id="country" name="country" required>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="password">Password:</label>
                                        <input type="password" class="form-control input-field" id="password" name="password" required>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="status">Status:</label>
                                        <select class="form-control input-field" id="status" name="status" required>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                </form>
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

            // Checking form input
            $("#submitBtn").click(function(e) {
                e.preventDefault();
                const call = $('#call').val();
                const qso_date = $('#qso_date').val();
                const time_on = $('#time_on').val();
                const rst_sent = $('#rst_sent').val();
                if(call === ""){
                    $('#call').addClass('border-danger');
                    $('#call').focus();
                    errorToast("DXpeidtion Call is required");
                }
                else if(!isNaN(call)){
                    $('#call').addClass('border-danger');
                    $('#call').focus();
                    errorToast("DXpeidtion Call should be string");
                }
                else if(qso_date === ""){
                    $('#qso_date').addClass('border-danger');
                    $('#qso_date').focus();
                    errorToast("QSO date is required");
                }
                else if(time_on === ""){
                    $('#time_on').addClass('border-danger');
                    $('#time_on').focus();
                    errorToast("Time on is required");
                }
                else if (isNaN(rst_sent)) {
                    $('#rst_sent').addClass('border-danger');
                    $('#rst_sent').focus();
                    errorToast("RST Sent should be a valid and positive number");
                }
                else if (rst_sent < 0) {
                    $('#rst_sent').addClass('border-danger');
                    $('#rst_sent').focus();
                    errorToast("RST Sent should be a positive number");
                } 
                else {
                    showLoader();
                    $("#myForm").submit();
                }
            });


            $('#call').on('keyup',function(){
                $(this).removeClass('border-danger');
            })
            $('#qso_date').on('blur',function(){
                if($(this).val() !== ''){
                $(this).removeClass('border-danger');
                }
            })
            $('#time_on').on('blur',function(){
                if($(this).val() !== ''){
                $(this).removeClass('border-danger');
                }
            })
            $('#rst_sent').on('keyup',function(){
                $(this).removeClass('border-danger');
            })
        });
    </script>

</body>

</html>
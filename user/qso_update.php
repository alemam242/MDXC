<?php
ob_start();
session_start();
require('../config.php'); // Assuming you have a config.php file for database connection

// Check if the user is not logged in, redirect to login screen
if (!isset($_SESSION['user_id']) || !isset($_SESSION['sitename']) || !isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit();
}
$user_id = $_SESSION['user_id'];

// Check if the QSL ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: view_qsl.php"); // Redirect to the QSL view page if ID is not provided
    exit();
}

// Fetch QSL record details based on the provided ID
$qsl_id = $_GET['id'];

// Handle form submission to update QSL record
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $call = $_POST['call'];
    $band = $_POST['band'];
    $mode = $_POST['mode'];
    $qso_date = $_POST['qso_date'];
    $time_on = $_POST['time_on'];
    // $freq = $_POST['freq'];
    $operator = $_POST['operator'];
    $rst_sent = $_POST['rst_sent'];

    // Update the QSL record in the database
    $query_update = "UPDATE `user_qsl` 
                 SET `call` = '$call', `band` = '$band', `mode` = '$mode', `qso_date` = '$qso_date', `time_on` = '$time_on', 
                      `operator` = '$operator', `rst_sent` = '$rst_sent' 
                 WHERE `id` = $qsl_id";

    $result_update = mysqli_query($conn, $query_update);

    if ($result_update) {
        $success_message = "QSO record updated successfully!";
    } else {
        $error_message = "Error updating QSO record. Please try again.";
    }
}


// Fillup the form by getting data from database
$query_qsl = "SELECT * FROM user_qsl WHERE id = $qsl_id";
$result_qsl = mysqli_query($conn, $query_qsl);
$row = mysqli_fetch_assoc($result_qsl);


?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add QSO | MDXC ADI Management System</title>
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
                        <h4 class="mb-sm-0">DX-peidtion</h4>
                        <div class="">
                            <span class="mb-sm-0">Edit QSO Record</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="container">

            <div class="row mt-4">
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <div class="h6 card-header text-uppercase">
                            Edit QSO Record
                        </div>
                        <div class="card-body">
                            <?php
                            if (isset($success_message)) {
                                echo '<div class="alert alert-success text-light" id="successAlert">' . $success_message . '</div>';
                            } elseif (isset($error_message)) {
                                echo '<div class="alert alert-danger text-light" is="errorAlert">' . $error_message . '</div>';
                            }
                            ?>
                            <form method="post" id="myForm">
                                <div class="row">
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="call">DXpeidtion Call:</label>
                                        <input type="text" class="form-control" id="call" name="call" value="<?php echo $row['call']; ?>" required>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                    <label for="band">Band:</label>
                                        <select class="form-control" id="band" name="band" required>
                                        <option <?php echo ($row['band'] == '160m' ? 'selected' : ''); ?> >160m</option>
                                            <option <?php echo ($row['band'] == '80m' ? 'selected': '') ?>>80m</option>
                                            <option <?php echo ($row['band'] == '60m' ? 'selected': '') ?>>60m</option>
                                            <option <?php echo ($row['band'] == '40m' ? 'selected': '') ?>>40m</option>
                                            <option <?php echo ($row['band'] == '30m' ? 'selected': '') ?>>30m</option>
                                            <option <?php echo ($row['band'] == '20m' ? 'selected': '') ?>>20m</option>
                                            <option <?php echo ($row['band'] == '17m' ? 'selected': '') ?>>17m</option>
                                            <option <?php echo ($row['band'] == '15m' ? 'selected': '') ?>>15m</option>
                                            <option <?php echo ($row['band'] == '12m' ? 'selected': '') ?>>12m</option>
                                            <option <?php echo ($row['band'] == '10m' ? 'selected': '') ?>>10m</option>
                                            <option <?php echo ($row['band'] == '6m' ? 'selected': '' )?>>6m</option>
                                            <option <?php echo ($row['band'] == '4m' ? 'selected': '' )?>>4m</option>
                                            <option <?php echo ($row['band'] == '2m' ? 'selected': '' )?>>2m</option>
                                            <option <?php echo ($row['band'] == '70cm' ? 'selected': '') ?>>70cm</option>
                                            <option <?php echo ($row['band'] == '23cm' ? 'selected': '') ?>>23cm</option>
                                            <!-- Add more bands as needed -->
                                        </select>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="mode">Mode:</label>
                                        <select class="form-control" id="mode" name="mode" required>
                                            <option <?php echo ($row['mode'] == 'SSB' ? 'selected': '') ?>>SSB</option>
                                            <option <?php echo ($row['mode'] == 'CW' ? 'selected': '') ?>>CW</option>
                                            <option <?php echo ($row['mode'] == 'AM' ? 'selected': '') ?>>AM</option>
                                            <option <?php echo ($row['mode'] == 'FM' ? 'selected': '') ?>>FM</option>
                                            <option <?php echo ($row['mode'] == 'RTTY' ? 'selected': '') ?>>RTTY</option>
                                            <option <?php echo ($row['mode'] == 'FT8' ? 'selected': '') ?>>FT8</option>
                                            <option <?php echo ($row['mode'] == 'PSK31' ? 'selected': '') ?>>PSK31</option>
                                            <option <?php echo ($row['mode'] == 'JT65' ? 'selected': '') ?>>JT65</option>
                                            <option <?php echo ($row['mode'] == 'JT9' ? 'selected': '') ?>>JT9</option>
                                            <!-- Add more modes as needed -->
                                        </select>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="qso_date">QSO Date:</label>
                                        <input type="date" class="form-control" id="qso_date" name="qso_date" value="<?php echo $row['qso_date']; ?>" required>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="time_on">Time On:</label>
                                        <input type="time" class="form-control" id="time_on" name="time_on" value="<?php echo $row['time_on']; ?>" required>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="operator">Operator:</label>
                                        <input type="text" class="form-control" id="operator" name="operator" value="<?php echo $row['operator']; ?>" required>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="rst_sent">RST Sent:</label>
                                        <input type="text" class="form-control" id="rst_sent" name="rst_sent" value="<?php echo $row['rst_sent']; ?>" required>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-sm btn-success" id="submitBtn">Update</button>
                                </div>

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
                const band = $('#band').val();
                const mode = $('#mode').val();
                const qso_date = $('#qso_date').val();
                const time_on = $('#time_on').val();
                const operator = $('#operator').val();
                const rst_sent = $('#rst_sent').val();
                if(call === ""){
                    errorToast("DXpeidtion Call is required");
                }
                else if(!isNaN(call)){
                    errorToast("DXpeidtion Call should be string");
                }
                else if(band === ""){
                    errorToast("Band is required");
                }
                else if(mode === ""){
                    errorToast("Mode is required");
                }
                else if(qso_date === ""){
                    errorToast("QSO date is required");
                }
                else if(time_on === ""){
                    errorToast("Time on is required");
                }
                else if(operator === ""){
                    errorToast("Operator is required");
                }
                else if (isNaN(rst_sent)) {
                    errorToast("RST Sent should be a valid and positive number");
                } else if (rst_sent < 0) {
                    errorToast("RST Sent should be a positive number");
                } else {
                    showLoader();
                    $("#myForm").submit();
                }
            });
        });
    </script>

</body>

</html>
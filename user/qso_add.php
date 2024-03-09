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

// Fetch events from the database
$query_events = "SELECT * FROM `events`";
$result_events = mysqli_query($conn, $query_events);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $event_id = $_POST['event_id'];
    $call = $_POST['call'];
    $band = $_POST['band'];
    $mode = $_POST['mode'];
    $qso_date = $_POST['qso_date'];
    $time_on = $_POST['time_on'];
    //$freq = $_POST['freq'];
    $operator = $_POST['operator'];
    $rst_sent = $_POST['rst_sent'];
    $status = '1';

    $create_date = date("Y-m-d H:i:s");

    // Insert QSL record into the database
    $query_insert_qsl = "INSERT INTO `user_qsl` (`event_id`, `user_id`, `call`, `band`, `mode`, `qso_date`, `time_on`, `freq`, `operator`, `rst_sent`, `status`)
                         VALUES ('$event_id', '$user_id', '$call', '$band', '$mode', '$qso_date', '$time_on', '0000', '$operator', '$rst_sent', '$status')";
    $result_insert_qsl = mysqli_query($conn, $query_insert_qsl);

    if ($result_insert_qsl) {
        $success_message = "QSO record added successfully!";
    } else {
        $error_message = "Error adding QSO record. Please try again. ";
    }
}
?>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>User Dashboard | MDXC ADI Management System</title>

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
                        <h4 class="mb-sm-0">DXpeidtion</h4>
                        <div class="">
                            <span class="mb-sm-0">Add QSO Record</span>
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
                            Add QSO Record
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
                                        <label for="event_id">Select Dx-pedition: *</label>
                                        <select class="form-control input-field" id="event_id" name="event_id" required>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($result_events)) {
                                                echo '<option value="' . $row['id'] . '">' . $row['event_name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="call">DXpeidtion Call: *</label>
                                        <input type="text" class="form-control input-field" id="call" name="call" required>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="band">Band:</label>
                                        <select class="form-control input-field" id="band" name="band" required>
                                            <option>160m</option>
                                            <option>80m</option>
                                            <option>60m</option>
                                            <option>40m</option>
                                            <option>30m</option>
                                            <option>20m</option>
                                            <option>17m</option>
                                            <option>15m</option>
                                            <option>12m</option>
                                            <option>10m</option>
                                            <option>6m</option>
                                            <option>4m</option>
                                            <option>2m</option>
                                            <option>70cm</option>
                                            <option>23cm</option>
                                            <!-- Add more bands as needed -->
                                        </select>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="mode">Mode: *</label>
                                        <select class="form-control input-field" id="mode" name="mode" required>
                                            <option>SSB</option>
                                            <option>CW</option>
                                            <option>AM</option>
                                            <option>FM</option>
                                            <option>RTTY</option>
                                            <option>FT8</option>
                                            <option>PSK31</option>
                                            <option>JT65</option>
                                            <option>JT9</option>
                                            <!-- Add more modes as needed -->
                                        </select>
                                    </div>
                                    <!--<div class="form-group col-md-6">-->
                                    <!--    <label for="freq">Frequency:</label>-->
                                    <!--    <input type="text" class="form-control" id="freq" name="freq" required>-->
                                    <!--</div>-->
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="qso_date">QSO Date: *</label>
                                        <input type="date" class="form-control input-field" id="qso_date" name="qso_date" required>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="time_on">Time On: *</label>
                                        <input type="time" class="form-control input-field" id="time_on" name="time_on" required>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="rst_sent">RST Sent:</label>
                                        <input type="text" class="form-control input-field" id="rst_sent" name="rst_sent">
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
                                        <label for="operator">Your Call:</label>
                                        <!-- Assuming you'll retrieve operator from the logged-in user -->
                                        <input type="text" class="form-control input-field" id="operator" name="operator" value="<?php echo $_SESSION['operator']; ?>" readonly>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-sm btn-danger me-2 " id="resetButton">Reset</button>
                                    <button type="submit" class="btn btn-sm btn-success" id="submitBtn">Add QSO</button>
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
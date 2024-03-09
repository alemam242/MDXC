<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
// Assuming you have established a database connection
require('../config.php');

// Get admin details from the database
$admin_id = $_SESSION['admin_id'];
$query_user = "SELECT * FROM `admin` WHERE `id` = $admin_id";
$result_user = mysqli_query($conn, $query_user);

// Extract admins;
if ($result_user && mysqli_num_rows($result_user) > 0) {
    $user_details = mysqli_fetch_assoc($result_user);
    $username = $user_details['name'];
} else {
    $user_details = null;
    $username = "";
}

// Fetch total user count
$query_total_users = "SELECT COUNT(*) AS total_users FROM `user`";
$result_total_users = mysqli_query($conn, $query_total_users);
$row_total_users = mysqli_fetch_assoc($result_total_users);
$total_users = $row_total_users['total_users'];

// Fetch total event count
$query_total_events = "SELECT COUNT(*) AS total_events FROM `events`";
$result_total_events = mysqli_query($conn, $query_total_events);
$row_total_events = mysqli_fetch_assoc($result_total_events);
$total_events = $row_total_events['total_events'];

// Fetch total adi file count
$query_total_files = "SELECT COUNT(*) AS total_files FROM `user_adfi_files`";
$result_total_files = mysqli_query($conn, $query_total_files);
$row_total_files = mysqli_fetch_assoc($result_total_files);
$total_files = $row_total_files['total_files'];

// Fetch total user QSO count
$query_total_qso = "SELECT COUNT(*) AS total_qso FROM `user_qsl`";
$result_total_qso = mysqli_query($conn, $query_total_qso);
$row_total_qso = mysqli_fetch_assoc($result_total_qso);
$total_qso = $row_total_qso['total_qso'];

// Fetch total notice count
$query_total_notices = "SELECT COUNT(*) AS total_notices FROM `admin_notices`";
$result_total_notices = mysqli_query($conn, $query_total_notices);
$row_total_notices = mysqli_fetch_assoc($result_total_notices);
$total_notices = $row_total_notices['total_notices'];

// Fetch last 10 users
$query_last_users = "SELECT `call_sign`, `name`, `country` FROM `user` ORDER BY `create_date` DESC LIMIT 10";
$result_last_users = mysqli_query($conn, $query_last_users);

// Fetch last 10 events
$query_last_events = "SELECT `event_name` FROM `events` ORDER BY `create_date` DESC LIMIT 10";
$result_last_events = mysqli_query($conn, $query_last_events);

// Fetch last 10 uploaded adi files
$query_last_files = "SELECT `u`.`call_sign`, `e`.`event_name`, `uaf`.`file_name`
                     FROM `user_adfi_files` AS `uaf`
                     INNER JOIN `user` AS `u` ON `u`.`id` = `uaf`.`user_id`
                     INNER JOIN `events` AS `e` ON `e`.`id` = `uaf`.`event_id`
                     ORDER BY `uaf`.`upload_date` DESC LIMIT 10";
$result_last_files = mysqli_query($conn, $query_last_files);

// Fetch last 10 notices
$query_last_notices = "SELECT `title` FROM `admin_notices` ORDER BY `create_date` DESC LIMIT 10";
$result_last_notices = mysqli_query($conn, $query_last_notices);

$query_qsl = "SELECT user_qsl.*, events.event_name 
              FROM user_qsl 
              INNER JOIN events ON user_qsl.event_id = events.id 
              ORDER BY user_qsl.id DESC 
              LIMIT 10";

$result_qsl = mysqli_query($conn, $query_qsl);

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Dashboard | MDXC ADI Management System</title>

    <!-- <link rel="icon" type="image/x-icon" href="../assets//favicon.ico" /> -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/animate.min.css" rel="stylesheet" />
    <link href="../assets/css/fontawesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link href="../assets/css/toastify.min.css" rel="stylesheet" />


    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <link href="../assets/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="assets/css/master.css" rel="stylesheet">
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
                        <h4 class="mb-sm-0">Dashboard</h4>
                        <div class="">
                            <span class="mb-sm-0">Welcome <?php echo $username; ?>!</span>
                        </div>

                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <!-- card -->
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                        Total Users
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                        <span class="counter-value" data-target="<?php echo $total_users; ?>"><?php echo $total_users; ?></span>
                                    </h4>
                                    <span class="link-secondary text-decoration-underline">Registered to this system</span>
                                </div>
                                <div class="icon-big text-center">
                                                <i class="teal fas fa-user"></i>
                                            </div>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <!-- card -->
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                        Total Events
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                        <span class="counter-value" data-target="<?php echo $total_events; ?>"><?php echo $total_events; ?></span>
                                    </h4>
                                    <span class="link-secondary text-decoration-underline">Hosted by MDXC</span>
                                </div>
                                <div class="icon-big text-center">
                                                <i class="olive fas fa-calendar"></i>
                                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <!-- card -->
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                        Total QSO
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                        <span class="counter-value" data-target="<?php echo $total_qso; ?>"><?php echo $total_qso; ?></span>
                                    </h4>
                                    <span class="link-secondary text-decoration-underline">Uploaded By User</span>
                                </div>
                                <div class="icon-big text-center">
                                                <i class="violet fas fa-file"></i>
                                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <!-- card -->
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                        Total Notices
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                        <span class="counter-value" data-target="<?php echo $total_notices; ?>"><?php echo $total_notices; ?></span>
                                    </h4>
                                    <span class="link-secondary text-decoration-underline">Sent by Admin</span>
                                </div>
                                <div class="icon-big text-center">
                                                <i class="orange fas fa-envelope"></i>
                                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row-->

            <div class="row mt-4">
                <div class="col-md-6 mt-4">
                    <div class="card">
                        <div class="h6 card-header text-uppercase">
                            Last 10 Users
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-card mb-1">
                                <table id="tableData" class="table table-nowrap align-middle table-striped" style="width:100%">
                                    <thead class="thead-dark">
                                        <tr class="text-uppercase">
                                            <th>#</th>
                                            <th>Callsign</th>
                                            <th>Name</th>
                                            <th>Country</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableList">
                                        <?php
                                        $count = 1;
                                        while ($row = mysqli_fetch_assoc($result_last_users)) {
                                            $callsign = $row['call_sign'];
                                            $name = $row['name'];
                                            $country = $row['country'];
                                            echo "<tr>
                            <td>" . $count++ . "</td>
                            <td>$callsign</td>
                            <td>$name</td>
                            <td>$country</td>
                            </tr>
                            ";
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 mt-4">
                    <div class="card">
                        <div class="h6 card-header text-uppercase">
                            Last 10 Events
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-card mb-1">
                                <table id="tableData" class="table table-nowrap align-middle table-striped" style="width:100%">
                                    <thead>
                                        <tr class="text-uppercase">
                                            <th>#</th>
                                            <th>event_name</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableList">
                                        <?php
                                        $count = 1;
                                        while ($row = mysqli_fetch_assoc($result_last_events)) {
                                            echo '<tr>
                            <td>' . $count++ . '</td>
                            <td>' . $row['event_name'] . '</td>
                            </tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 mt-4">
                    <div class="card">
                        <div class="h6 card-header text-uppercase">
                            Last 10 Uploaded ADI Files
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-card mb-1">
                                <table id="tableData" class="table table-nowrap align-middle table-striped" style="width:100%">
                                    <thead>
                                        <tr class="text-uppercase">
                                            <th>#</th>
                                            <th>Event Name</th>
                                            <th>Call</th>
                                            <th>Band</th>
                                            <th>Mode</th>
                                            <th>QSO Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableList">
                                        <?php
                                        $count = 1;
                                        while ($row_2 = mysqli_fetch_assoc($result_qsl)) {
                                            echo "<tr>";
                                            echo "<td>" . $count++ . "</td>";
                                            echo "<td>{$row_2['event_name']}</td>";
                                            echo "<td>{$row_2['call']}</td>";
                                            echo "<td>{$row_2['band']}</td>";
                                            echo "<td>{$row_2['mode']}</td>";
                                            echo "<td>{$row_2['qso_date']}</td>";


                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>
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
        $().ready(function() {
            hideLoader();
        });
    </script>

</body>

</html>
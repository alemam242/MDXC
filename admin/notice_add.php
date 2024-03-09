<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Include your database connection file
require('../config.php');

// Define variables and initialize with empty values
$title = $content = '';
$title_err = $content_err = '';

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate title
    if (empty(trim($_POST["title"]))) {
        $title_err = "Please enter a title.";
    } else {
        $title = trim($_POST["title"]);
    }

    // Validate content
    if (empty(trim($_POST["content"]))) {
        $content_err = "Please enter the content.";
    } else {
        $content = trim($_POST["content"]);
    }

    // Check input errors before inserting into database
    if (empty($title_err) && empty($content_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO admin_notices (title, content) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_title, $param_content);

            // Set parameters
            $param_title = $title;
            $param_content = $content;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to view all notices page after successful creation
                //header("location: view_all_notices.php");
                //exit();
                $success_message = "Notice added successfully.";
            } else {
                $success_message =  "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add New Notice | MDXC ADI Management System</title>

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
                        <h4 class="mb-sm-0">Notice List</h4>
                        <div class="">
                            <span class="mb-sm-0">Add New Notice</span>
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
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <div class="form-group col-12">
                                        <label for="title">Title</label>
                                <input type="text" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" id="title" name="title" value="<?php echo $title; ?>">
                                <span class="invalid-feedback"><?php echo $title_err; ?></span>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="content">Content</label>
                                <textarea class="form-control <?php echo (!empty($content_err)) ? 'is-invalid' : ''; ?>" id="content" name="content" rows="5"><?php echo $content; ?></textarea>
                                <span class="invalid-feedback"><?php echo $content_err; ?></span>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Submit</button>
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




        });
    </script>

</body>

</html>
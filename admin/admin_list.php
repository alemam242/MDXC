<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Include your database connection file
require('../config.php');

// Fetch all admins from the database
$query = "SELECT * FROM `admin`";
$result = mysqli_query($conn, $query);
?>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin List | MDXC ADI Management System</title>
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


    <!-- Delete Modal -->
    <div class="modal animated zoomIn" id="delete-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h3 class=" mt-3 text-warning">Delete !</h3>
                    <p class="mb-3">You are going to delete a record. Once delete, you can't get it back.</p>
                    <form id="deleteForm">
                        <input class="d-none" id="deleteID" name="deleteID" />
                    </form>
                </div>
                <div class="modal-footer justify-content-end">
                    <div>
                        <button type="button" id="delete-modal-close" class="btn bg-gradient-success mx-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="confirmDelete" class="btn bg-gradient-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="contentRef" class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box align-items-center justify-content-between p-2">
                        <h4 class="mb-sm-0">Admin List</h4>
                        <div class="">
                            <span class="mb-sm-0">List of admins</span>
                        </div>

                    </div>
                </div>
            </div>


            <div class="row mt-4">
                <div class="col-md-12 mx-auto">
                    <div class="card">
                        <div class="h6 card-header text-uppercase">
                            Admin List
                                <a href="admin_insert.php" class="float-end btn m-0 bg-gradient-info">Add new admin</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-card mb-1">
                                <table id="tableData" class="table table-nowrap align-middle hover" style="width:100%">
                                    <thead>
                                        <tr class="text-uppercase">
                                            <th>Name</th>
                                        <th>Callsign</th>
                                        <th>Username</th>
                                        <th>Country</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableList">
                                        <?php 
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>{$row['name']}</td>";
                                            echo "<td>{$row['callsign']}</td>";
                                            echo "<td>{$row['username']}</td>";
                                            echo "<td>{$row['country']}</td>";
                                            echo "<td>{$row['email']}</td>";
                                            echo "<td>
<a href='admin_update.php?id=".$row["id"]."' class='text-info me-3'>
<i class='fas fa-pencil-alt'></i>
</a>
<a href='admin_view_data.php?id=".$row["id"]."' class='text-secondary viewBtn'>
<i class='fas fa-eye'></i>
</a>
</td>";
                                            echo "</tr>";
                                            

                                        } ?>
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
        $(document).ready(function() {
            hideLoader();
                new DataTable('#tableData', {
                order: [
                    [0, 'asc']
                ],
                lengthMenu: [10, 25, 50, 100]
            });
            

            $(document).on('mouseover','.deleteBtn',function() {
                $(this).css('cursor', 'pointer');
            });

            $(document).on('click','.deleteBtn', async function() {
                let id = $(this).data('id');
                $('#deleteID').val(id);
                $("#delete-modal").modal('show');
            });

            $('#confirmDelete').on('click', function() {
                deleteRecord($('#deleteID').val());
                $("#delete-modal-close").click();
            });

            async function deleteRecord(id) {
                showLoader();
                console.log(id)
                try {
                    const res = await axios.post('/user/qso_delete.php' + '?deleteID=' + id);
                    console.log(res);

                    if (res.data.status === 'success') {
                        successToast(res.data.message);
                        get_qso_list();
                    } else {
                        errorToast(res.data.message);
                    }
                } catch (error) {
                    console.log(error);
                    errorToast(error.message);
                } finally {
                    hideLoader();
                }
            }

        });
    </script>

</body>

</html>
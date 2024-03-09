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
$message = "Request failed!";
$status = "failed";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['deleteID'])) {
        $deleteId = $_GET['deleteID'];

        // Delete the QSL record from the database
        $query_delete = "DELETE from `user_qsl` WHERE `user_id` = $user_id AND `id` = $deleteId";

        $result_delete = mysqli_query($conn, $query_delete);

        if ($result_delete) {
            $status = "success";
            $message = "QSO record deleted successfully!";
        } else {
            $message = "Error deleting QSO record. Please try again.";
        }
    }
}
echo json_encode([
    "message" => $message,
    "status" => $status
]);

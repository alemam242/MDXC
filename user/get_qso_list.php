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
// Fetch QSL records with event names from the database
$query_qsl = "SELECT q.*, e.event_name 
              FROM user_qsl q 
              INNER JOIN events e ON q.event_id = e.id 
              WHERE q.user_id = '$user_id'";
$result_qsl = mysqli_query($conn, $query_qsl);
if ($result_qsl) {
    // Initialize an array to store all fetched rows
    $records = [];

    // Fetch each row and add it to the array
    while ($row = mysqli_fetch_assoc($result_qsl)) {
        $records[] = $row;
    }

    // Encode the array into JSON format and echo the result
    echo json_encode([
        "status"=>"success",
        "records"=>$records
    ]);
} else {
    // If there are no rows returned or if there's an error, return an empty array
    echo json_encode([
        "status"=>"error",
        "records"=>[]
    ]);
}
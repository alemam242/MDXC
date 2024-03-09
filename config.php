<?php
// Database connection details
$servername = "localhost";
// $username = "mdxconirbanbd_qsl";
$username = "root";
// $password = "Not4all~";
$password = "";
// $database = "mdxconirbanbd_qsl";
$database = "mdxc";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// else{
//     echo "Connected";
// }
?>

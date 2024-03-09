<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
// Include your database connection file
require('../config.php');



// Fetch users from the database
$query = "SELECT * FROM `user`";
$result = mysqli_query($conn, $query);

// Check if users exist
if (mysqli_num_rows($result) > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User List</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>

    <div class="container mt-5">
        <h2>User List</h2>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Call Sign</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Country</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["call_sign"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td>" . $row["address"] . "</td>";
                echo "<td>" . $row["country"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "<td><a href='update_user.php?id=".$row["id"]."'>Update</a></td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    </body>
    </html>
    <?php
} else {
    echo '<div class="alert alert-info mt-3" role="alert">No users found!</div>';
}

// Close database connection
mysqli_close($conn);
?>

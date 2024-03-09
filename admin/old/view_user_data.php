<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
// Include your database connection file
require('../config.php');

// Check if user ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch user data from the database based on the user ID
    $query = "SELECT * FROM `user` WHERE `id` = $user_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user_data = mysqli_fetch_assoc($result);
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>User Details</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        <body>

        <div class="container mt-5">
            <h2>User Details</h2>
            <table class="table">
                <tbody>
                <tr>
                    <th>Name</th>
                    <td><?php echo $user_data['name']; ?></td>
                </tr>
                <tr>
                    <th>Call Sign</th>
                    <td><?php echo $user_data['call_sign']; ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo $user_data['email']; ?></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><?php echo $user_data['phone']; ?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?php echo $user_data['address']; ?></td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td><?php echo $user_data['country']; ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><?php echo $user_data['status']; ?></td>
                </tr>
                <tr>
                    <th>Action</th>
                    <td> <a href="update_user.php?id=<?php echo $user_data['id']; ?>">Update</a></td>
                </tr>
                </tbody>
            </table>
        </div>

        </body>
        </html>
        <?php
    } else {
        echo '<div class="alert alert-danger mt-3" role="alert">User not found!</div>';
    }
} else {
    echo '<div class="alert alert-danger mt-3" role="alert">Invalid user ID!</div>';
}

// Close database connection
mysqli_close($conn);
?>

<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Fetch user information from the database using $_SESSION['username']
// Your database connection code goes here
$servername = "localhost"; // Host name
$username = "root"; // Mysql username
$password = ""; // Mysql password
$dbName = "lirikalogin"; // Database name

$conn = new mysqli($servername, $username, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Display the user's information
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>

<body>
    <?php
    // Display user information
    ?>
    <h1>User Profile Page</h1>
    <p>Username:
        <?php echo $_SESSION['username']; ?>
    </p>
    <!-- Display other user information as needed -->

    <a href="index.html">Back to Home</a>
</body>

</html>
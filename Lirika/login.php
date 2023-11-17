<?php
$servername = "localhost"; // Host name
$username = "root"; // Mysql username
$password = ""; // Mysql password
$dbName = "lirikalogin"; // Database name
$conn = new mysqli($servername, $username, $password, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$myusername = $_POST['myusername'];
$mypassword = $_POST['mypassword'];
$sql = "SELECT username, psw FROM lirikaadmin WHERE username='$myusername' and
psw='$mypassword'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    header("location:adminMenu.php");
} else {
    echo "Wrong Username or Password. Please try again.";
}
$conn->close();
?>
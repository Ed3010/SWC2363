<?php
// Include your database connection code here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lirikalogin";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Fetch lyrics from the database
$sql = "SELECT * FROM lyrics";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Title: " . $row['title'] . "<br>";
        echo "Artist: " . $row['artist'] . "<br>";
        echo "Lyrics: " . $row['content'] . "<br><br>";
    }
} else {
    echo "No lyrics found.";
}

// Close the database connection
$conn->close();
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lirikalogin";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lyricsId = $_POST['lyricsId'];
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $lyrics = $_POST['lyrics'];

    // Update the lyrics in the database
    $sqlUpdate = "UPDATE lyrics SET title = '$title', artist = '$artist', lyrics = '$lyrics' WHERE id = $lyricsId";
    if ($conn->query($sqlUpdate) === TRUE) {
        header("location:viewLyrics.php");
    } else {
        echo "Error updating lyrics: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lirikalogin";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['id'])) {
    $lyricsId = $_GET['id'];

    // Fetch the lyrics based on the $lyricsId
    $sql = "SELECT * FROM lyrics WHERE id = $lyricsId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display a form with the existing data
        ?>
        <form action="updateLyricsForm.php" method="post">
            <input type="hidden" name="lyricsId" value="<?php echo $row['id']; ?>">
            Title: <input type="text" name="title" value="<?php echo $row['title']; ?>"><br>
            Artist: <input type="text" name="artist" value="<?php echo $row['artist']; ?>"><br>
            Lyrics: <textarea name="content"><?php echo $row['content']; ?></textarea><br>
            <input type="submit" value="Update Lyrics">
        </form>
        <?php
    } else {
        echo "Lyrics not found.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
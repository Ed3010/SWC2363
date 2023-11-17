<?php
// editLyrics.php

// Establish a database connection (replace these with your actual database credentials)
$host = 'localhost';
$dbname = 'lirikalogin';
$db_username = 'root';
$db_password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Check if the form is submitted for updating the lyrics
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $newTitle = $_POST['title'];
    $newArtist = $_POST['artist'];
    $newLyrics = $_POST['content'];

    // Update the lyrics details in the database
    $stmtUpdateLyrics = $pdo->prepare("UPDATE lyrics SET title = ?, artist = ?, content = ? WHERE id = ?");
    $stmtUpdateLyrics->execute([$newTitle, $newArtist, $newLyrics, $id]);

    // Redirect to admin page after updating
    header("Location: adminMenu.php");
    exit();
}

// Retrieve the lyrics details based on the provided ID
if (isset($_GET['id'])) {
    $lyricsId = $_GET['id'];

    // Fetch lyrics details
    $stmtGetLyrics = $pdo->prepare("SELECT * FROM lyrics WHERE id = ?");
    $stmtGetLyrics->execute([$lyricsId]);
    $lyrics = $stmtGetLyrics->fetch(PDO::FETCH_ASSOC);
} else {
    // Redirect to admin page if no lyrics ID is provided
    header("Location: adminMenu.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lyrics</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }

        h2 {
            color: #333;
        }

        form {
            max-width: 500px;
            margin: 20px 0;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            display: block;
            margin-top: 20px;
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h2>Edit Lyrics</h2>
    <form action="editLyrics.php" method="post">
        <input type="hidden" name="id" value="<?= $lyrics['id']; ?>">

        <label for="newTitle">New Title:</label>
        <input type="text" name="newTitle" value="<?= $lyrics['title']; ?>" required>

        <label for="newArtist">New Artist:</label>
        <input type="text" name="newArtist" value="<?= $lyrics['artist']; ?>" required>

        <label for="newLyrics">New Lyrics:</label>
        <textarea name="newLyrics" rows="8" required><?= $lyrics['content']; ?></textarea>

        <input type="submit" value="Update Lyrics">
    </form>

    <a href="adminMenu.php">Back to Admin Page</a>
</body>

</html>
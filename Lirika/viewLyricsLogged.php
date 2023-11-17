<?php
// Include the database connection file
require_once 'db.php';

// Start the session to get the user ID
session_start();

// Get the ID from the URL parameter
$id = $_GET['id'];

// Use a prepared statement to prevent SQL injection
$stmt = $pdo->prepare("SELECT * FROM lyrics WHERE id = ?");
$stmt->execute([$id]);
$lyric = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if a lyric with the given ID exists
if (!$lyric) {
    die("Lyric not found");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lyric Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h2 {
            background-color: #333;
            color: #fff;
            padding: 15px;
            margin: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h2 img {
            width: 120px;
            height: 40px;
        }

        div {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #333;
            margin-bottom: 10px;
        }

        p {
            margin: 0;
            line-height: 1.6;
        }

        form {
            margin-top: 15px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>

    <h2>
        <a href="userMenu.html"><img src="images/Lirika.png" alt="Lirika Logo"></a>

    </h2>

    <div>
        <h3>Title:
            <?php echo htmlspecialchars($lyric['title']); ?>
        </h3>
        <p>Artist:
            <?php echo htmlspecialchars($lyric['artist']); ?>
        </p>
        <p>Lyrics:
            <?php echo nl2br(htmlspecialchars($lyric['content'])); ?>
        </p>
    </div>

</body>

</html>
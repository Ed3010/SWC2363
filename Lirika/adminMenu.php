<?php
ob_start(); // Start output buffering
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h1 {
            margin: 0;
        }

        h2,
        h3 {
            color: #333;
            margin-top: 20px;
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

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        a {
            display: block;
            margin-top: 20px;
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            background-color: #111;
        }

        .question-box {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .lyrics-box {
            white-space: pre-line;
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
        }

        table {
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        a.edit-button,
        a.delete-button {
            display: inline-block;
            padding: 8px 12px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        a.edit-button:hover,
        a.delete-button:hover {
            background-color: #2980b9;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        header .logout-button {
            background-color: #e74c3c;
            color: #fff;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        header .logout-button:hover {
            background-color: #c0392b;
        }
    </style>
</head>

<body>
    <header>
        <ul>
            <li><a href="index.html"><img src="images/Lirika.png" width="120" height="40"></a></li>
            <li><a href="login.html" class="logout-button">Logout</a></li>
        </ul>
    </header>
</body>

</html>

<?php
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

// Handle lyrics submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];    // Define $title
    $artist = $_POST['artist'];  // Define $artist
    $lyrics = $_POST['content'];  // Define $lyrics

    // Insert lyrics into the database
    $stmt = $pdo->prepare("INSERT INTO lyrics (title, artist, content) VALUES (?, ?, ?)");
    $stmt->execute([$title, $artist, $lyrics]);

    // Redirect to the same page with a success message
    header("Location: adminMenu.php?success=1");
    exit();
}

// Retrieve created lyrics from the database
$stmt = $pdo->prepare("SELECT * FROM lyrics");
$stmt->execute();
$lyrics = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h3>Add New Lyrics</h3>
<form action="adminMenu.php" method="post">
    <label for="title">Title:</label>
    <input type="text" name="title" required>

    <label for="artist">Artist:</label>
    <input type="text" name="artist" required>

    <label for="content">Lyrics:</label>
    <textarea name="content" rows="8" required></textarea>

    <input type="submit" value="Add Lyrics">
</form>

<h3>Manage Lyrics</h3>
<?php
if (empty($lyrics)) {
    echo "<p>No lyrics found.</p>";
} else {
    foreach ($lyrics as $lyric) {
        echo '<div class="question-box">';
        echo '<strong>Title:</strong> ' . $lyric['title'] . '<br>';
        echo '<strong>Artist:</strong> ' . $lyric['artist'] . '<br>';
        echo '<strong>Lyrics:</strong>';
        echo '<div class="lyrics-box">' . $lyric['content'] . '</div><br>';
        echo '<a href="editLyrics.php?id=' . $lyric['id'] . '" class="edit-button">Edit</a>';
        echo '<a href="?delete=' . $lyric['id'] . '" class="delete-button" onclick="return confirmDelete()">Delete</a>';
        echo '</div>';
    }
}
ob_start(); // Start output buffering

// Your existing PHP code here

// Handle lyrics deletion
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    $deleteLyricId = $_GET['delete'];

    try {
        // Start a transaction
        $pdo->beginTransaction();

        // Now delete the lyric
        $deleteLyricStmt = $pdo->prepare("DELETE FROM lyrics WHERE id = ?");
        $deleteLyricStmt->execute([$deleteLyricId]);

        // Commit the transaction
        $pdo->commit();

        header("Location: adminMenu.php?success=deleted");
        exit();
    } catch (PDOException $e) {
        // An error occurred, rollback the transaction
        $pdo->rollBack();
        die("Error: " . $e->getMessage());
    }
}
ob_end_flush();
?>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this lyric?");
    }
</script>
</body>

</html>
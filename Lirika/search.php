<?php
define("DB_HOST", "localhost");
define("DB_NAME", "lirikalogin");
define("DB_CHARSET", "utf8");
define("DB_USER", "root");
define("DB_PASSWORD", "");

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASSWORD,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    // SEARCH
    $stmt = $pdo->prepare("SELECT * FROM `lyrics` WHERE `title` LIKE ? OR `artist` LIKE ?");
    $stmt->execute([
        "%" . $_POST['search'] . "%",
        "%" . $_POST["search"] . "%"
    ]);
    $results = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
</head>

<body>

    <h2>Search Results</h2>

    <?php
    if (isset($results)) {
        if ($results) {
            foreach ($results as $result) {
                echo "<div>";
                echo "<h3>Title: " . htmlspecialchars($result['title']) . "</h3>";
                echo "<p>Artist: " . htmlspecialchars($result['artist']) . "</p>";
                echo "<p>Lyrics: " . nl2br(htmlspecialchars($result['content'])) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No results found.</p>";
        }
    }
    ?>

</body>

</html>
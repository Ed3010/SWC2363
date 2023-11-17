<?php
// Connect to your database
require_once 'db.php';

// Get the search query from the URL parameter
$query = $_GET['query'];

// Use a prepared statement to prevent SQL injection
$stmt = $pdo->prepare("SELECT * FROM lyrics WHERE title LIKE ? OR artist LIKE ?");
$stmt->execute(["%$query%", "%$query%"]);
$suggestions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return the suggestions as JSON
header('Content-Type: application/json');
echo json_encode($suggestions);

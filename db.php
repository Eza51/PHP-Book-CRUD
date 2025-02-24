<?php
// db.php - Database Connection

$host = 'localhost'; // your database host
$username = 'root';  // your database username
$password = '';      // your database password
$dbname = 'book_manager'; // database name

try {
    // Create PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set error mode
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection errors
    echo 'Connection failed: ' . $e->getMessage();
}
?>

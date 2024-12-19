<?php
// Database connection details
$host = 'localhost'; // Database host
$dbname = 'student_info_db'; // Name of the database
$username = 'root'; // MySQL username
$password = ''; // MySQL password

try {
    // Create a PDO instance and establish a connection to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set error mode to exception for easier error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection failure
    echo "Connection failed: " . $e->getMessage();
}
?>

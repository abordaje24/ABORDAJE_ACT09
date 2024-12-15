<?php
// Database Configuration
$dbHost = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "sample_db";

// PDO Variable, will be used outside this PHP script
$pdo = null;

// Create PDO Connection
try {
	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}
?>
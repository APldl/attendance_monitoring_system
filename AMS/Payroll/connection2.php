<?php
// Connect to MySQL database
session_start();
$servername = "localhost";
$db_username = "root"; // XAMPP default
$db_password = "root"; // XAMPP default
$database = "attendance_monitoring_system";

try {
  $pdo = new PDO("mysql:host=$servername;dbname=$database", $db_username, $db_password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}
?>
<?php
// Connect to MySQL database
session_start();
$servername = "localhost";
$db_username = "root"; //xampp default
$db_password = "";  //xampp default
$database = "attendance_monitoring_system";

  $conn = mysqli_connect($servername, $db_username, $db_password, $database);

?>
<?php
// viewed.php

// Include the database connection file

// Get the user ID from the URL parameter
$user_id = $_GET['id'];

// Update the 'new' column to 0 for the user with the specified ID
$queryUpdateNewColumn = "UPDATE faculty_attendance SET `new` = 0 WHERE user_id = $user_id";
mysqli_query($conn, $queryUpdateNewColumn);

?>
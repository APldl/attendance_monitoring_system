<?php
// Include the connection.php file
require 'connection.php';

// Fetch substitute data from the database
$substituteQuery = "SELECT user_fullname FROM user WHERE role_id = 1 AND school_department = 'School of Engineering'";
$substituteResult = mysqli_query($conn, $substituteQuery);

// Generate HTML options for the substitutes
$options = "";
while ($substituteRow = mysqli_fetch_assoc($substituteResult)) {
    $substituteFullName = $substituteRow['user_fullname'];
    $options .= "<option value='$substituteFullName'>$substituteFullName</option>";
}

// Close the database connection (if not already closed in connection.php)
mysqli_close($conn);

// Return the HTML options
echo $options;
?>
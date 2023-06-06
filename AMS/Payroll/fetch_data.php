<?php
require_once 'connection.php';

// Check if filter parameters are provided
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;
$month = $_GET['month'] ?? null;

// Prepare the SQL query
$sql = "
SELECT u.user_fullname, u.employee_no, COUNT(fa.status) AS absences
FROM user u
LEFT JOIN faculty_attendance fa ON u.user_id = fa.user_id AND fa.status = 'Absent'
WHERE u.role_id = 1 AND u.school_department = 'School of Engineering'
";

// Apply filter conditions if provided
if ($startDate && $endDate) {
    // Filter by weekly date range
    $sql .= "AND fa.date >= '$startDate' AND fa.date <= '$endDate'";
} elseif ($month) {
    // Filter by month
    $sql .= "AND MONTH(fa.date) = $month";
}

// Group the results
$sql .= " GROUP BY u.user_id";

// Execute the SQL query
$result = mysqli_query($conn, $sql);

// Fetch the data and store it in an array
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Close the database connection
mysqli_close($conn);

// Set the response headers to indicate JSON content type
header('Content-Type: application/json');

// Send the JSON-encoded data back to the JavaScript code
echo json_encode($data);
?>
<?php
require_once 'connection2.php';

// Check if the AJAX request was made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the start and end dates from the AJAX request
  $requestData = json_decode(file_get_contents('php://input'), true);
  $startDate = $requestData['startDate'];
  $endDate = $requestData['endDate'];
  $userId = $requestData['user_id'];

  // Prepare the SQL query to count the number of rows with the status "Absent" for the given date range and user_id
  $query = "SELECT COUNT(*) as absence_count FROM faculty_attendance WHERE user_id = :userId AND date BETWEEN :startDate AND :endDate AND status = 'Absent'";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':userId', $userId);
  $stmt->bindParam(':startDate', $startDate);
  $stmt->bindParam(':endDate', $endDate);
  $stmt->execute();
  // Fetch the count from the database result
  $result = $stmt->fetch();
  $absenceCount = $result['absence_count'];

  // Return the count as a response
  echo $absenceCount;
}
?>
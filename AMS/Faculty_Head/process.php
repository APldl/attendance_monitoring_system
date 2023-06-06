<?php
require 'connection.php';

if (isset($_POST['btn_submit'])) {
  $attendanceIds = $_POST['attendance_id'];
  $statuses = $_POST['status'];
  $notes = $_POST['notes'];

  // Perform the necessary database update operation to save the changes for each row
  for ($i = 0; $i < count($attendanceIds); $i++) {
    $attendanceId = mysqli_real_escape_string($conn, $attendanceIds[$i]);
    $status = mysqli_real_escape_string($conn, $statuses[$i]);
    $note = mysqli_real_escape_string($conn, $notes[$i]);

    $updateSql = "UPDATE faculty_attendance SET status = '$status', notes = '$note' WHERE attendance_id = '$attendanceId'";
    mysqli_query($conn, $updateSql);
  }

  // Redirect the user back to the page where they made the changes (adjust the URL accordingly)
  header('Location: view_attendance.php');
  exit();
}
?>
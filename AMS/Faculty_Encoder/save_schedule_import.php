<?php
error_log('save_schedule_import.php script executed');
// Include database connection file
require_once "connection.php";

// Get form data
$user_id = $_GET['id'];
$subject_codes = $_POST['subject_code'];
$subject_units = $_POST['subject_units'];
$schedule_days = $_POST['schedule_day'];
$sections = $_POST['section'];
$schedule_time_starts = $_POST['schedule_time_start'];
$schedule_time_ends = $_POST['schedule_time_end'];
$rooms = $_POST['room'];

// Prepare the database insertion statement
$sql = "INSERT INTO schedule (user_id, subject_code, subject_units, schedule_day, section, schedule_time_start, schedule_time_end, room) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

// Bind parameters to the prepared statement
mysqli_stmt_bind_param($stmt, 'ssssssss', $user_id, $subject_code, $subject_units, $schedule_day, $section, $schedule_time_start, $schedule_time_end, $room);

// Perform the database insertion
for ($i = 0; $i < count($subject_codes); $i++) {
  // Get the current values from the arrays
  $subject_code = $subject_codes[$i];
  $subject_units = $subject_units[$i];
  $schedule_day = $schedule_days[$i];
  $section = $sections[$i];
  $schedule_time_start = $schedule_time_starts[$i];
  $schedule_time_end = $schedule_time_ends[$i];
  $room = $rooms[$i];

  // Execute the prepared statement
  mysqli_stmt_execute($stmt);
}

// Redirect back to the original page or perform any necessary actions
header("Location: edit_sched_function.php?id=$user_id");
exit();
?>
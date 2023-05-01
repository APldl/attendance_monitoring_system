<?php
  // Include database connection file
  require_once "connection.php";

  $user_id = $_GET['id'];

  // Get form data
  $schedule_ids = $_POST['schedule_id'];
  $subject_codes = $_POST['subject_code'];
  $subject_units = $_POST['subject_units'];
  $schedule_days = $_POST['schedule_day'];
  $sections = $_POST['section'];
  $schedule_time_starts = $_POST['schedule_time_start'];
  $schedule_time_ends = $_POST['schedule_time_end'];
  $rooms = $_POST['room'];

  // Loop through the form data and update the database
  for ($i = 0; $i < count($schedule_ids); $i++) {
    $sql = "UPDATE schedule SET subject_code='".$subject_codes[$i]."', subject_units='".$subject_units[$i]."', schedule_day='".$schedule_days[$i]."', section='".$sections[$i]."', schedule_time_start='".$schedule_time_starts[$i]."', schedule_time_end='".$schedule_time_ends[$i]."', room='".$rooms[$i]."' WHERE schedule_id=".$schedule_ids[$i];
    mysqli_query($conn, $sql);
  }


  // Redirect back to the schedule page
header("Location: edit_sched.php?id=$user_id");
  exit();
?>
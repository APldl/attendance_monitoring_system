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

  // Update or insert rows in the database
  for ($i = 0; $i < count($schedule_ids); $i++) {
    if (!empty($schedule_ids[$i])) {
      // Update existing row in the database
      $sql = "UPDATE schedule SET subject_code='".$subject_codes[$i]."', subject_units='".$subject_units[$i]."', schedule_day='".$schedule_days[$i]."', section='".$sections[$i]."', schedule_time_start='".$schedule_time_starts[$i]."', schedule_time_end='".$schedule_time_ends[$i]."', room='".$rooms[$i]."' WHERE schedule_id=".$schedule_ids[$i];
      mysqli_query($conn, $sql);
      $message = "Schedule updated successfully.";
    } else {
      // Insert new row in the database
      $sql = "INSERT INTO schedule (user_id, subject_code, subject_units, schedule_day, section, schedule_time_start, schedule_time_end, room) VALUES ('".$user_id."', '".$subject_codes[$i]."', '".$subject_units[$i]."', '".$schedule_days[$i]."', '".$sections[$i]."', '".$schedule_time_starts[$i]."', '".$schedule_time_ends[$i]."', '".$rooms[$i]."')";
      mysqli_query($conn, $sql);
      $message = "Schedule added successfully.";
    }
  }

  // Set error message if there was an issue with the database
  if (mysqli_error($conn)) {
    $error_message = "Error updating schedule: " . mysqli_error($conn);
  }

  // Redirect back to the schedule page
  if (isset($error_message)) {
    header("Location: edit_sched.php?id=$user_id&error_message=$error_message");
  } else {
    header("Location: edit_sched.php?id=$user_id&message=$message");
  }
  exit();
?> 
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
  $academic_year = $_POST['academic_year'];

  $error_messages = array();

  // Update or insert rows in the database
  for ($i = 0; $i < count($schedule_ids); $i++) {
    // Validate form data
    if (empty($subject_codes[$i]) || empty($subject_units[$i]) || empty($schedule_days[$i]) || empty($sections[$i]) || empty($schedule_time_starts[$i]) || empty($schedule_time_ends[$i]) || empty($rooms[$i])) {
      $error_messages[] = "All fields are required.";
      continue;
    }

    if (!in_array($schedule_days[$i], array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"))) {
      $error_messages[] = "Invalid schedule day: " . $schedule_days[$i];
      continue;
    }

    if (!preg_match("/^\d{2}:\d{2}(:\d{2})?$/", $schedule_time_starts[$i]) || !preg_match("/^\d{2}:\d{2}(:\d{2})?$/", $schedule_time_ends[$i])) {
      $error_messages[] = "Invalid time format.";
      continue;
    }

    if (!empty($schedule_ids[$i])) {
      // Update existing row in the database
      $sql = "UPDATE schedule SET academic_year='".$academic_year."', subject_code='".$subject_codes[$i]."', subject_units='".$subject_units[$i]."', schedule_day='".$schedule_days[$i]."', section='".$sections[$i]."', schedule_time_start='".$schedule_time_starts[$i]."', schedule_time_end='".$schedule_time_ends[$i]."', room='".$rooms[$i]."' WHERE schedule_id=".$schedule_ids[$i];
      mysqli_query($conn, $sql);
      $message = "Schedule updated successfully.";
    } else {
      // Insert new row in the database
      $sql = "INSERT INTO schedule (user_id, academic_year, subject_code, subject_units, schedule_day, section, schedule_time_start, schedule_time_end, room) VALUES ('".$user_id."', '".$academic_year."', '".$subject_codes[$i]."', '".$subject_units[$i]."', '".$schedule_days[$i]."', '".$sections[$i]."', '".$schedule_time_starts[$i]."', '".$schedule_time_ends[$i]."', '".$rooms[$i]."')";
      mysqli_query($conn, $sql);
      $message = "Schedule added successfully.";
    }
  }

  // Set error message if there were issues with the form data
  if (!empty($error_messages)) {
    $error_message = implode("<br>", $error_messages);
  }

  // Set message if there were no errors
  if (empty($error_messages)) {
    $message = $message ?? "No changes made.";
  }


  // Set error message if there was an issue with the database
  if (mysqli_error($conn)) {
    $error_message = "Error updating schedule: " . mysqli_error($conn);
  }

if (isset($error_message)) {
  header("Location: edit_sched.php?id=$user_id&error_message=$error_message&show_alert=1");
} else {
  header("Location: edit_sched.php?id=$user_id&message=$message");
}
exit();
?> 
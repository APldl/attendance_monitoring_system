<?php
// Include database connection file
require_once "connection.php";

// Get user ID from query parameter
$user_id = $_GET['id'];

// Get form data
$request_ids = $_POST['request_id'];
$subject_codes = $_POST['subject_code'];
$subject_units = $_POST['subject_units'];
$schedule_dates = $_POST['schedule_date'];
$sections = $_POST['section'];
$schedule_time_starts = $_POST['schedule_time_start'];
$schedule_time_ends = $_POST['schedule_time_end'];
$rooms = $_POST['room'];
$reasons = $_POST['reason'];

$error_messages = array();

// Update or insert rows in the database
for ($i = 0; $i < count($subject_codes); $i++) {
  // Skip the row if all fields are empty
  if (empty($subject_codes[$i]) && empty($subject_units[$i]) && empty($schedule_dates[$i]) && empty($sections[$i]) && empty($schedule_time_starts[$i]) && empty($schedule_time_ends[$i]) && empty($rooms[$i])) {
    continue;
  }

  // Validate form data
  if (empty($subject_codes[$i]) || empty($subject_units[$i]) || empty($schedule_dates[$i]) || empty($sections[$i]) || empty($schedule_time_starts[$i]) || empty($schedule_time_ends[$i]) || empty($rooms[$i])) {
    $error_messages[] = "All fields are required.";
    continue;
  }

  if (!preg_match("/^\d{2}:\d{2}(:\d{2})?$/", $schedule_time_starts[$i]) || !preg_match("/^\d{2}:\d{2}(:\d{2})?$/", $schedule_time_ends[$i])) {
    $error_messages[] = "Invalid time format.";
    continue;
  }

  if (!empty($request_ids[$i])) {
    // Update existing row in the database
    $sql = "UPDATE request SET subject_code='".$subject_codes[$i]."', subject_units='".$subject_units[$i]."', schedule_date='".$schedule_dates[$i]."', section='".$sections[$i]."', schedule_time_start='".$schedule_time_starts[$i]."', schedule_time_end='".$schedule_time_ends[$i]."', room='".$rooms[$i]."', reason='".$reasons[$i]."' WHERE request_id=".$request_ids[$i];
    mysqli_query($conn, $sql);
    $message = "Schedule updated successfully.";
  } else {
    // Insert new row in the database
    $sql = "INSERT INTO request (user_id, subject_code, subject_units, schedule_date, section, schedule_time_start, schedule_time_end, room, reason) VALUES ('".$user_id."', '".$subject_codes[$i]."', '".$subject_units[$i]."', '".$schedule_dates[$i]."', '".$sections[$i]."', '".$schedule_time_starts[$i]."', '".$schedule_time_ends[$i]."', '".$rooms[$i]."', '".$reasons[$i]."')";
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

$redirectURL = "make_request.php?id=$user_id";
if (isset($error_message)) {
  $redirectURL .= "&error_message=" . urlencode($error_message) . "&show_alert=1";
} else {
  $redirectURL .= "&message=" . urlencode($message);
}

// Redirect to the appropriate URL
header("Location: $redirectURL");
exit();
?>
<?php
  // Include database connection file
  require_once "connection.php";

  $user_id = $_GET['id'];

  // Get form data
  $request_ids = $_POST['request_id'];
  $schedule_dates = $_POST['schedule_date'];
  $sections = $_POST['section'];
  $schedule_time_starts = $_POST['schedule_time_start'];
  $schedule_time_ends = $_POST['schedule_time_end'];
  $rooms = $_POST['room'];
  $statuses = $_POST['status'];
  $notes = $_POST['notes'];

  $error_messages = array();

  // Update or insert rows in the database
  for ($i = 0; $i < count($request_ids); $i++) {
    // Validate form data
    if (empty($schedule_dates[$i]) || empty($sections[$i]) || empty($schedule_time_starts[$i]) || empty($schedule_time_ends[$i]) || empty($rooms[$i])) {
      $error_messages[] = "All fields are required.";
      continue;
    }

    if (!preg_match("/^\d{2}:\d{2}(:\d{2})?$/", $schedule_time_starts[$i]) || !preg_match("/^\d{2}:\d{2}(:\d{2})?$/", $schedule_time_ends[$i])) {
      $error_messages[] = "Invalid time format.";
      continue;
    }

    if (!empty($request_ids[$i])) {
      // Update existing row in the database
      $sql = "UPDATE request SET schedule_date='".$schedule_dates[$i]."', section='".$sections[$i]."', schedule_time_start='".$schedule_time_starts[$i]."', schedule_time_end='".$schedule_time_ends[$i]."', room='".$rooms[$i]."', status='".$statuses[$i]."', notes='".(!empty($notes[$i]) ? $notes[$i] : "")."' WHERE request_id=".$request_ids[$i];
      mysqli_query($conn, $sql);
      $message = "Schedule updated successfully.";
    } else {
      // Insert new row in the database
      $sql = "INSERT INTO request (user_id, schedule_date, section, schedule_time_start, schedule_time_end, room, status, notes) VALUES ('".$user_id."', '".$schedule_dates[$i]."', '".$sections[$i]."', '".$schedule_time_starts[$i]."', '".$schedule_time_ends[$i]."', '".$rooms[$i]."', '".$statuses[$i]."', '".(!empty($notes[$i]) ? $notes[$i] : "")."')";
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
    header("Location: make_request.php?id=$user_id&error_message=$error_message&show_alert=1");
  } else {
    header("Location: make_request.php?id=$user_id&message=$message");
  }
  exit();
?>
<?php
require_once "connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $subject_code = mysqli_real_escape_string($conn, $_POST['subject_code']);
    $subject_units = mysqli_real_escape_string($conn, $_POST['subject_units']);
    $schedule_day = mysqli_real_escape_string($conn, $_POST['schedule_day']);
    $section = mysqli_real_escape_string($conn, $_POST['section']);
    $schedule_time_start = formatTime($_POST['schedule_time_start']); // Format time
    $schedule_time_end = formatTime($_POST['schedule_time_end']); // Format time
    $room = mysqli_real_escape_string($conn, $_POST['room']);

    // Update the SQL query to correctly handle time values
    $sql = "INSERT INTO schedule (user_id, subject_code, subject_units, schedule_day, section, schedule_time_start, schedule_time_end, room) 
            VALUES ('$user_id', '$subject_code', '$subject_units', '$schedule_day', '$section', '$schedule_time_start', '$schedule_time_end', '$room')";

    // Log the SQL query
    error_log("SQL Query: " . $sql);

    if ($conn->query($sql) === TRUE) {
        echo 'Data saved successfully.';
    } else {
        echo 'Error: ' . $sql . '<br>' . mysqli_error($conn);
    }
} else {
    echo 'Invalid request.';
}

function formatTime($time) {
    return date('H:i:s', strtotime($time)); // Format time as HH:MM:SS
}

$conn->close();
?>
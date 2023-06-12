<?php
date_default_timezone_set('Asia/Manila');
// Include the connection file
require_once 'connection.php';

// Get the current date
$currentDate = date('Y-m-d');

// Get the current time in the desired format
$currentTime = date('H:i');

// Script 1: Insert rows from schedule table
$sql = "SELECT * FROM schedule WHERE schedule_day = '$currentDay' AND TIME_FORMAT(schedule_time_start, '%H:%i') >= TIME_FORMAT('$currentTime', '%H:%i')";
$result = $conn->query($sql);

// Check if any rows are returned
if ($result->num_rows > 0) {
    // Iterate over the rows
    while ($row = $result->fetch_assoc()) {
        // Get the necessary values from the schedule table
        $subjectCode = $row['subject_code'];
        $userID = $row['user_id'];
        $scheduleTimeStart = $row['schedule_time_start'];
        $scheduleTimeEnd = $row['schedule_time_end'];
        $room = $row['room'];

        // Combine the start and end time into the desired format
        $scheduleTime = date('H:i', strtotime($scheduleTimeStart)) . ' - ' . date('H:i', strtotime($scheduleTimeEnd));

        // Insert a new row into the faculty_attendance table
        $insertSql = "INSERT INTO faculty_attendance (subject_code, user_id, date, room, schedule_time) VALUES ('$subjectCode', '$userID', '$currentDate', '$room', '$scheduleTime')";

        if ($conn->query($insertSql) === TRUE) {
            echo "New row added to faculty_attendance table successfully.\n";
        } else {
            echo "Error inserting row: " . $conn->error . "\n";
        }
    }
} else {
    echo "No schedules found in time interval.\n";
}

// Script 2: Insert rows from request table
$sql = "SELECT * FROM request WHERE schedule_date = '$currentDate' AND generate = 'active' AND TIME_FORMAT(schedule_time_start, '%H:%i') >= TIME_FORMAT('$currentTime', '%H:%i')";
$result = $conn->query($sql);

// Check if any rows are returned
if ($result->num_rows > 0) {
    // Iterate over the rows
    while ($row = $result->fetch_assoc()) {
        // Get the necessary values from the request table
        $subjectCode = $row['subject_code'];
        $scheduleTimeStart = $row['schedule_time_start'];
        $scheduleTimeEnd = $row['schedule_time_end'];
        $room = $row['room'];
        $subProfessor = $row['sub_professor'];
        $userID = $row['user_id'];

        // Combine the start and end time into the desired format
        $scheduleTime = date('H:i', strtotime($scheduleTimeStart)) . ' - ' . date('H:i', strtotime($scheduleTimeEnd));

        // Check if sub_professor is null
        if ($subProfessor === null) {
            // Use the user_id from the request table
            $professorID = $userID;
        } else {
            // Look for the user_id in the user table based on sub_professor value
            $professorSql = "SELECT user_id FROM user WHERE user_fullname = '$subProfessor'";
            $professorResult = $conn->query($professorSql);
            
            if ($professorResult->num_rows > 0) {
                $professorRow = $professorResult->fetch_assoc();
                $professorID = $professorRow['user_id'];
            } else {
                echo "Sub professor not found in user table.\n";
                continue;
            }
        }

        // Insert a new row into the faculty_attendance table
        $insertSql = "INSERT INTO faculty_attendance (subject_code, user_id, date, room, schedule_time) VALUES ('$subjectCode', '$professorID', '$currentDate', '$room', '$scheduleTime')";

        if ($conn->query($insertSql) === TRUE) {
            // Change the 'generate' column to 'inactive'
            $requestID = $row['request_id'];
            $updateSql = "UPDATE request SET generate = 'inactive' WHERE request_id = '$requestID'";
            $conn->query($updateSql);

            echo "New row added to faculty_attendance table and 'generate' column updated successfully.\n";
        } else {
            echo "Error inserting row: " . $conn->error . "\n";
        }
    }
} else {
    echo "No requests found in time interval or with 'generate' column set to 'active'.\n";
}

// Script 3: Update rows in faculty_attendance table
$updateSql = "UPDATE faculty_attendance SET status = 'Absent' WHERE Time_In IS NULL AND status = 'Pending' AND CAST(ADDTIME(SUBSTRING_INDEX(schedule_time, ' - ', 1), '00:30:00') AS TIME) <= CAST(NOW() AS TIME) COLLATE utf8_general_ci";

if ($conn->query($updateSql) === TRUE) {
    $updatedRows = $conn->affected_rows;
    echo "$updatedRows row(s) updated in faculty_attendance table.\n";
} else {
    echo "Error updating rows: " . $conn->error . "\n";
}

// Close the database connection
$conn->close();
// Close the database connection
$conn->close();
?>
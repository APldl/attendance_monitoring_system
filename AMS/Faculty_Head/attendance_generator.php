<?php
date_default_timezone_set('Asia/Manila');
require 'connection.php';

// Get the current date
$currentDate = date('Y-m-d');
//echo "Current Date: " . $currentDate . "\n";

$currentTime = date('H:i');
//echo "Current Time: " . $currentTime . "\n";

$currentDayOfWeek = date('l');
//echo "Current Day of the Week: " . $currentDayOfWeek . "\n";

// Script 1: Insert rows from schedule table
$sql = "SELECT * FROM schedule WHERE schedule_day = '$currentDayOfWeek' AND TIME_FORMAT(schedule_time_start, '%H:%i') <= TIME_FORMAT('$currentTime', '%H:%i') AND (cooldown > '$currentTime' OR cooldown IS NULL)";
$result = $conn->query($sql);

// Check if any rows are returned
if ($result->num_rows > 0) {
    // Iterate over the rows
    while ($row = $result->fetch_assoc()) {
        // Get the necessary values from the schedule table
        $scheduleId = $row['schedule_id'];
        $subjectCode = $row['subject_code'];
        $userID = $row['user_id'];
        $scheduleTimeStart = $row['schedule_time_start'];
        $scheduleTimeEnd = $row['schedule_time_end'];
        $room = $row['room'];
        $scheduleDay = $row['schedule_day'];
        $section = $row['section']; // Added section value

        // Combine the start and end time into the desired format
        $scheduleTime = date('H:i', strtotime($scheduleTimeStart)) . ' - ' . date('H:i', strtotime($scheduleTimeEnd));

        // Update the cooldown column in the schedule table only for the executed schedule
        $updateSql = "UPDATE schedule SET cooldown = '$currentTime' WHERE schedule_id = '$scheduleId' AND user_id = '$userID' AND (cooldown > '$currentTime' OR cooldown IS NULL)";

        if ($conn->query($updateSql) === TRUE) {
            //echo "Cooldown updated for schedule: schedule_id='$scheduleId'\n";

            // Insert a new row into the faculty_attendance table
            $insertSql = "INSERT INTO faculty_attendance (subject_code, user_id, date, room, schedule_time, day, section) VALUES ('$subjectCode', '$userID', '$currentDate', '$room', '$scheduleTime', '$scheduleDay', '$section')";

            if ($conn->query($insertSql) === TRUE) {
                //echo "New row added to faculty_attendance table successfully.\n";
            } else {
                //echo "Error inserting row: " . $conn->error . "\n";
            }
        } else {
            //echo "Error updating cooldown: " . $conn->error . "\n";
        }
    }
} else {
    //echo "No schedules found with passed time and cooldown for today.\n";
}

// Script 2: Insert rows from request table
$sql = "SELECT * FROM request WHERE schedule_date <= '$currentDate' AND generate = 'active' AND TIME_FORMAT(schedule_time_start, '%H:%i') <= TIME_FORMAT('$currentTime', '%H:%i')";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subjectCode = $row['subject_code'];
        $scheduleTimeStart = $row['schedule_time_start'];
        $scheduleTimeEnd = $row['schedule_time_end'];
        $room = $row['room'];
        $subProfessor = $row['sub_professor'];
        $userID = $row['user_id'];
        $scheduleDate = $row['schedule_date'];
        $requestID = $row['request_id'];
        $section = $row['section'];

        $scheduleTime = date('H:i', strtotime($scheduleTimeStart)) . ' - ' . date('H:i', strtotime($scheduleTimeEnd));

        if ($subProfessor === null) {
            $subID = 'NULL';
        } else {
            // Retrieve the user_id based on the sub_professor's user_fullname
            $professorSql = "SELECT user_id FROM user WHERE user_fullname = '$subProfessor'";
            $professorResult = $conn->query($professorSql);

            if ($professorResult->num_rows > 0) {
                $professorRow = $professorResult->fetch_assoc();
                $subID = $professorRow['user_id'];
            } else {
                continue;
            }
        }

        $dayOfWeek = date('l', strtotime($scheduleDate)); // Get the day of the week

        $insertSql = "INSERT INTO faculty_attendance (subject_code, user_id, date, room, schedule_time, day, request_id, section, sub_id) VALUES ('$subjectCode', '$userID', '$scheduleDate', '$room', '$scheduleTime', '$dayOfWeek', '$requestID', '$section', $subID)";

        if ($conn->query($insertSql) === TRUE) {
            $requestID = $row['request_id'];
            $updateSql = "UPDATE request SET generate = 'inactive' WHERE request_id = '$requestID'";
            $conn->query($updateSql);
        }
    }
} else {
    
}

// Script 3: Update rows in faculty_attendance table
$updateSql = "UPDATE faculty_attendance SET status = 'Absent' WHERE Time_In IS NULL AND status = 'Pending' AND CAST(ADDTIME(SUBSTRING_INDEX(schedule_time, ' - ', 1), '00:30:00') AS TIME) <= CAST(NOW() AS TIME) COLLATE utf8_general_ci";

if ($conn->query($updateSql) === TRUE) {
    $updatedRows = $conn->affected_rows;
   // echo "$updatedRows row(s) updated in faculty_attendance table.\n";
} else {
   // echo "Error updating rows: " . $conn->error . "\n";
}


?>
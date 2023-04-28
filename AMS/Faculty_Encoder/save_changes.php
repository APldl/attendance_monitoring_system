<?php
require_once 'connection.php';
// Retrieve table data from POST request
$tableData = json_decode(file_get_contents("php://input"), true);

// Update database with new data
foreach ($tableData as $row) {
  $sql = "UPDATE schedule SET
    subject_code = '".$row["subject_code"]."',
    subject_units = '".$row["subject_units"]."',
    schedule_day = '".$row["schedule_day"]."',
    section = '".$row["section"]."',
    schedule_time_start = '".$row["schedule_time_start"]."',
    schedule_time_end = '".$row["schedule_time_end"]."',
    room = '".$row["room"]."'
    WHERE schedule_id = ".$row["schedule_id"];
  mysqli_query($conn, $sql);
}

// Send response back to client
$response = array("status" => "success");
echo json_encode($response);
?>
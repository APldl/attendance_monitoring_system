<?php
// Retrieve the status and year from the request
$status = $_POST['status'];
$year = $_POST['year'];

// Construct the filename
$currentDate = date('Y-m-d');
$filename = ($status !== '' ? $status . '_' : '') . $year . '_' . $currentDate . '.csv';

// Perform your database queries to fetch the necessary data here
// Example: Assuming you have a database connection established

// Prepare the SQL query based on the selected status and year
$query = "SELECT date, subject_code, room, Time_In, Time_Out, schedule_time, notes, status FROM faculty_attendance WHERE user_id = '$user_id'";

if (!empty($status)) {
  $query .= " AND status = '$status'";
}

if (!empty($year)) {
  $query .= " AND YEAR(date) = '$year'";
}

$query .= " ORDER BY date DESC";

$result = mysqli_query($conn, $query);

// Check if there are any records
if (mysqli_num_rows($result) > 0) {
  // Create a temporary file handle
  $tempFile = fopen('php://temp', 'w');

  // Write the CSV header row
  $headerRow = array('Date', 'Subject Code', 'Room', 'Time In', 'Time Out', 'Schedule Time', 'Notes', 'Status');
  fputcsv($tempFile, $headerRow);

  // Write the data rows to the temporary file handle
  while ($row = mysqli_fetch_assoc($result)) {
    $dataRow = array(
      $row['date'],
      $row['subject_code'],
      $row['room'],
      $row['Time_In'],
      $row['Time_Out'],
      $row['schedule_time'],
      $row['notes'],
      $row['status']
    );
    fputcsv($tempFile, $dataRow);
  }

  // Set the file headers
  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="' . $filename . '"');

  // Move the temporary file pointer to the beginning
  rewind($tempFile);

  // Output the contents of the temporary file
  fpassthru($tempFile);

  // Close the file handle
  fclose($tempFile);
} else {
  // No records found, handle the error or display a message
  echo "No attendance records found for the selected month and year.";
}
?>
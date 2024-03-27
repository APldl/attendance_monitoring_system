<?php
require_once "connection.php";
include "attendance_generator.php";

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM request WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="FMStyle.css">
  <title>Here is your class Schedule</title>
  <style>
    .container {
      max-width: 878px;
      margin: 0 auto;
      padding: 10px;
      font-family: Arial, sans-serif;
      margin-left: 370px; /* add margin to move the container to the right */
    }

    .table {
      border-collapse: collapse;
      width: 130%;
      margin-top: 20px;
    }

    .table th,
    .table td {
      padding: 10px;
      text-align: left;
      border: 1px solid #ccc;
    }

    .table th {
      background-color: #f2f2f2;
      font-weight: bold;
    }

    .table tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    .add-button {
      margin-top: 10px;
    }
    .short-input {
    width: 70px;
  }
    .short-input2 {
    width: 80px;
  }
    .short-input3 {
    width: 30px;
  }
  </style>
</head>
<body>
  <nav>
    <div class="d-flex justify-content-centerlogo">
      <img class="logo" src="https://signin.apc.edu.ph/images/logo.png" width="60px"/>
    </div>
    <label class="logo">Attendance Monitoring System</label>

    <ul>
      <li class="logout-link">
        <a href="#">
          <?php echo $_SESSION['user_fullname']; ?>
          <div class="dropdown-menu">
            <div class="logout-box">
              <span id="user_full_name" name="full_name" class="log-out-name" onselectstart="return false;" onclick="collapse_logout()"></span>
              <span id="user_role_type" name="role_type" class="role-type" onselectstart="return false;"></span>
            </div>
            <ul id="btn_logout" class="log-out">
              <form name="logout-form" method="post">
                <button class="logout-button" type="button" onclick="logout()">
                  <span class="fas fa-power-off"></span>
                  Log Out
                </button>
              </form>
            </ul>
          </div>
        </a>
      </li>
    </ul>
  </nav>

  <div class="wrapper">
    <div class="sidebar">
      <h2>Viewing</h2>
      <ul>
        <li><a href="dashboard_FM.php">View Class Schedule</a></li>
        <li><a href="view_attendance.php">View Attendance Records</a></li>
        <li><a href="view_approved.php">View Approved Requests</a></li>
      </ul>
      <h2>Make Request</h2>
      <ul>
        <li><a href="make_request.php">Make Up Class</a></li>
        <li><a href="make_sub.php">Substitution</a></li>
      </ul>
    </div>
    <div class="main_content">
      <div class="info">
        <div>lorem lorem</div>
      </div>
    </div>
  </div>


<div class="container">
  <h1>Approved Requests</h1>

  <table id="scheduleTable" class="table">
    <thead>
      <tr>
        <th>Subject Code</th>
        <th>Subject Units</th>
        <th>Schedule Date</th>
        <th>Section</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Room</th>
        <th>Academic Year</th>
        <th>Substitute</th>
        <th>Remarks</th>
        <th>Reason</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $status = $row['status'];
    if ($status !== 'approved' && $status !== 'elapsed') {
      continue; // Skip the row if status is not 'approved' or 'elapsed'
    }
    
    // Rest of your code for displaying the row
    echo "<tr>";
    echo "<td>" . $row['subject_code'] . "</td>";
    echo "<td>" . $row['subject_units'] . "</td>";
    echo "<td>" . $row['schedule_date'] . "</td>";
    echo "<td>" . $row['section'] . "</td>";
    echo "<td>" . $row['schedule_time_start'] . "</td>";
    echo "<td>" . $row['schedule_time_end'] . "</td>";
    echo "<td>" . $row['room'] . "</td>";
    echo "<td>" . $row['academic_year'] . "</td>";
    echo "<td>" . $row['sub_professor'] . "</td>";
    echo "<td>" . $row['notes'] . "</td>";
    echo "<td>" . $row['reason'] . "</td>";
    echo "<td>" . $row['status'] . "</td>";
    echo "</tr>";
    echo "<input type='hidden' name='request_id[]' value='" . $row['request_id'] . "'>";
  }
} else {
  echo "<tr><td colspan='10'>No records found.</td></tr>";
}      ?>
    </tbody>
  </table>
</div>



</body>
</html>
<?php
require_once "connection.php";

$user_id = $_GET['id'];
$query = "SELECT * FROM request WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

// Update the 'new' column to 0 for rows with an empty value or NULL in the 'sub_professor' column
$queryUpdateNewColumn = "UPDATE request SET `new` = 0 WHERE user_id = $user_id AND (sub_professor = '' OR sub_professor IS NULL)";
mysqli_query($conn, $queryUpdateNewColumn);
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
      margin-right: 160px; /* add margin to move the container to the right */
    }

    .table {
      border-collapse: collapse;
      width: 110%;
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
            <h2>Schools</h2>
            <ul>
                <li><a href="dashboard_FH.php">School of Engineering</a></li>
            </ul>
        
        </div>
        <div class="main_content">
            <div class="info">
                <div>lorem lorem</div>
            </div>
        </div>
    </div>

<div class="container">
  <h1>Make up class</h1>

  <form method="post" action="save_schedule.php?id=<?php echo $user_id; ?>">
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
          <th>Notes</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
                if (!empty($row['sub_professor'])) {
                continue; // Skip the row if 'sub_professor' is not empty
                }
            echo "<tr>";
            echo "<td>" . $row['subject_code'] . "</td>";
            echo "<td>" . $row['subject_units'] . "</td>";
            echo "<td><input type='text' name='schedule_date[]' value='" . $row['schedule_date'] . "' class='short-input2'></td>";
            echo "<td><input type='text' name='section[]' value='" . $row['section'] . "' class='short-input'></td>";
            echo "<td><input type='text' name='schedule_time_start[]' value='" . $row['schedule_time_start'] . "' class='short-input'></td>";
            echo "<td><input type='text' name='schedule_time_end[]' value='" . $row['schedule_time_end'] . "' class='short-input'></td>";
            echo "<td><input type='text' name='room[]' value='" . $row['room'] . "' class='short-input3'></td>";
            echo "<td>" . $row['academic_year'] . "</td>";
            echo "<td><textarea name='notes[]' class='short-input'>" . $row['notes'] . "</textarea></td>";
            echo "<td>
              <select name='status[]'>
                <option value='pending'". ($row['status'] == 'pending' ? " selected" : "") .">Pending</option>
                <option value='approved'". ($row['status'] == 'approved' ? " selected" : "") .">Approved</option>
                <option value='denied'". ($row['status'] == 'denied' ? " selected" : "") .">Denied</option>
              </select>
            </td>";
            echo "</tr>";
            echo "<input type='hidden' name='request_id[]' value='" . $row['request_id'] . "'>";
          }
        } else {
          echo "<tr><td colspan='11'>No records found.</td></tr>";
        }
        ?>
      </tbody>
    </table>

    <button type="submit">Submit</button>
  </form>
</div>


<script>

</script>

</html>
</body>
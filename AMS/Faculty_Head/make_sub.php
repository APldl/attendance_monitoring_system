<?php
require_once "connection.php";

$user_id = $_GET['id'];
$query = "SELECT * FROM request WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

$queryUpdateNewColumn = "UPDATE request SET `new` = 0 WHERE user_id = $user_id AND sub_professor <> ''";
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
  <h1>Substitution</h1>

  <form method="post" action="save_sub.php?id=<?php echo $user_id; ?>">
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
      <th>Notes</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
<?php
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    // Skip the row if 'sub_professor' column is empty
    if (empty($row['sub_professor'])) {
      continue;
    }

    echo "<tr>";
    echo "<td><input type='text' name='subject_code[]' value='" . $row['subject_code'] . "' class='short-input'></td>";
    echo "<td><input type='text' name='subject_units[]' value='" . $row['subject_units'] . "' class='short-input3'></td>";
    echo "<td><input type='text' name='schedule_date[]' value='" . $row['schedule_date'] . "' class='short-input2'></td>";
    echo "<td><input type='text' name='section[]' value='" . $row['section'] . "' class='short-input'></td>";
    echo "<td><input type='text' name='schedule_time_start[]' value='" . $row['schedule_time_start'] . "' class='short-input'></td>";
    echo "<td><input type='text' name='schedule_time_end[]' value='" . $row['schedule_time_end'] . "' class='short-input'></td>";
    echo "<td><input type='text' name='room[]' value='" . $row['room'] . "' class='short-input3'></td>";
    echo "<td>" . $row['academic_year'] . "</td>";
    echo "<td>";
    echo "<select name='substitute[]' class='short-input' onchange='adjustDropdownHeight(this)'>";

    // Fetch substitute options from the user table
    $substituteQuery = "SELECT user_fullname FROM user WHERE role_id = 1 AND school_department = 'School of Engineering'";
    $substituteResult = mysqli_query($conn, $substituteQuery);

    // Create an array to store the substitute options
    $substituteOptions = array();

    while ($substituteRow = mysqli_fetch_assoc($substituteResult)) {
      $substituteOptions[] = $substituteRow['user_fullname'];
    }

    // Get the current value from the database
    $currentSubstitute = $row['sub_professor'];

    // Check if the current substitute is empty
    if (empty($currentSubstitute)) {
      // Set a default value or handle it according to your requirements
      $currentSubstitute = "Default Value";
      // You can also set the first option as selected if no current substitute value is available
      // echo "<option value='' selected>Default Value</option>";
    }

    // Output the current value as the first option
    echo "<option value='" . $currentSubstitute . "' selected>" . $currentSubstitute . "</option>";

    // Output the remaining options
    foreach ($substituteOptions as $substituteOption) {
      if ($substituteOption !== $currentSubstitute) {
        echo "<option value='" . $substituteOption . "'>" . $substituteOption . "</option>";
      }
    }

    echo "</select>";
    echo "</td>";
    echo "<td><textarea name='notes[]'>" . $row['notes'] . "</textarea></td>";
    echo "<td>
      <select name='status[]'>
        <option value='pending'" . ($row['status'] == 'pending' ? " selected" : "") . ">Pending</option>
        <option value='approved'" . ($row['status'] == 'approved' ? " selected" : "") . ">Approved</option>
        <option value='denied'" . ($row['status'] == 'denied' ? " selected" : "") . ">Denied</option>
      </select>
    </td>";
    echo "<td><button type='button' class='delete-button' onclick='deleteRow(this)'>Delete</button></td>";
    echo "</tr>";
    echo "<input type='hidden' name='request_id[]' value='" . $row['request_id'] . "'>";
  }
} else {
  echo "<tr><td colspan='12'>No records found.</td></tr>";
}
?>
  </tbody>
</table>

    <button type="submit">Submit</button>
  </form>
</div>


<script>
function deleteRequest(request_id) {
  if (confirm("Are you sure you want to delete this request?")) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var response = this.responseText;
        if (response == 'success') {
          var requestRow = document.querySelector("#scheduleTable tr[data-request-id='" + request_id + "']");
          if (requestRow) {
            requestRow.remove();
            window.location.reload(); // Reload the page after successful deletion
          }
        } else {
          alert('Error deleting request');
        }
      }
    };
    xhr.open("POST", "delete_request.php", true); // Replace "delete_request.php" with your server-side script URL
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("request_id=" + request_id);
    window.location.reload(); // Reload the page after successful deletion
  }
}

</script>

</body>
</html>
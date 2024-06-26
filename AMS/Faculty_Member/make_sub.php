<?php
require_once "connection.php";


$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM request WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

$queryUpdateNewColumn = "UPDATE request SET `new` = 1 WHERE user_id = $user_id AND sub_professor <> ''";
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
      max-width: 888px;
      margin: 0 auto;
      padding: 10px;
      font-family: Arial, sans-serif;
      margin-right: 260px; /* add margin to move the container to the right */
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
          <th>Remarks</th>
          <th>Reason</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $status = $row['status'];
            if ($status !== 'pending' && $status !== 'denied') {
              continue; // Skip the row if status is not 'pending' or 'denied'
            }

            // Skip the row if 'sub_professor' column is empty
            if (empty($row['sub_professor'])) {
              continue;
            }

            $readonly = ($row['status'] !== 'pending') ? 'readonly' : '';

            echo "<tr>";
            echo "<td><input type='text' name='subject_code[]' value='" . $row['subject_code'] . "' class='short-input' " . $readonly . "></td>";
            echo "<td><input type='text' name='subject_units[]' value='" . $row['subject_units'] . "' class='short-input3' " . $readonly . "></td>";
            echo "<td><input type='text' name='schedule_date[]' value='" . $row['schedule_date'] . "' class='short-input2' " . $readonly . "></td>";
            echo "<td><input type='text' name='section[]' value='" . $row['section'] . "' class='short-input' " . $readonly . "></td>";
            echo "<td><input type='text' name='schedule_time_start[]' value='" . $row['schedule_time_start'] . "' class='short-input' " . $readonly . "></td>";
            echo "<td><input type='text' name='schedule_time_end[]' value='" . $row['schedule_time_end'] . "' class='short-input' " . $readonly . "></td>";
            echo "<td><input type='text' name='room[]' value='" . $row['room'] . "' class='short-input3' " . $readonly . "></td>";
            echo "<td>" . $row['academic_year'] . "</td>";

            echo "<td>";
            echo "<select name='substitute[]' class='short-input' onchange='adjustDropdownHeight(this)'";

            if ($row['status'] !== 'pending') {
              echo " onchange='return false;'"; // Disable the onchange event handler
            }

            echo ">";

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

            echo "<td><textarea name='notes[]' readonly>" . $row['notes'] . "</textarea></td>";
            echo "<td><textarea name='reason[]' " . $readonly . ">" . $row['reason'] . "</textarea></td>";
            echo "<td>" . $row['status'] . "</td>";
              echo "<td><button class='delete-button' onclick='deleteRequest(" . $row['request_id'] . ")'>Delete</button></td>";
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
    <button type="button" onclick="addRow()">Add</button>
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

  function addRow() {
    var table = document.querySelector(".table");
    var tbody = table.querySelector("tbody");
    var row = document.createElement("tr");
    var cell1 = document.createElement("td");
    var cell2 = document.createElement("td");
    var cell3 = document.createElement("td");
    var cell4 = document.createElement("td");
    var cell5 = document.createElement("td");
    var cell6 = document.createElement("td");
    var cell7 = document.createElement("td");
    var cell8 = document.createElement("td");
    var cell9 = document.createElement("td");
    var cell10 = document.createElement("td");
    var cell11 = document.createElement("td");
    var cell12 = document.createElement("td");
    var cell13 = document.createElement("td");

    cell1.innerHTML = "<input type='text' name='subject_code[]' class='short-input'>";
    cell2.innerHTML = "<input type='text' name='subject_units[]' class='short-input3'>";
    cell3.innerHTML = "<input type='text' name='schedule_date[]' class='short-input2'>";
    cell4.innerHTML = "<input type='text' name='section[]' class='short-input'>";
    cell5.innerHTML = "<input type='text' name='schedule_time_start[]' class='short-input'>";
    cell6.innerHTML = "<input type='text' name='schedule_time_end[]' class='short-input'>";
    cell7.innerHTML = "<input type='text' name='room[]' class='short-input3'>";
    cell8.innerHTML = ""; // Placeholder for academic year (to be filled dynamically)
    cell9.innerHTML = "<select name='substitute[]' class='short-input' id='substitute-select'></select>";
    cell10.innerHTML = "<textarea name='notes[]' readonly></textarea>";
    cell11.innerHTML = "<textarea name='reason[]'></textarea>";
    cell12.innerHTML = ""; // Placeholder for status (to be filled dynamically)
    cell13.innerHTML = "<button class='delete-button' onclick='deleteRow(this.parentNode.parentNode)'>Delete</button>";

    row.appendChild(cell1);
    row.appendChild(cell2);
    row.appendChild(cell3);
    row.appendChild(cell4);
    row.appendChild(cell5);
    row.appendChild(cell6);
    row.appendChild(cell7);
    row.appendChild(cell8);
    row.appendChild(cell9);
    row.appendChild(cell10);
    row.appendChild(cell11);
    row.appendChild(cell12);
    row.appendChild(cell13);

    tbody.appendChild(row);

    // Fetch substitute data dynamically using AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var substituteSelect = document.getElementById("substitute-select");
        substituteSelect.innerHTML = this.responseText;
      }
    };
    xhr.open("GET", "fetch_substitutes.php", true); // Replace "fetch_substitutes.php" with your server-side script URL
    xhr.send();
  }
</script>

</body>
</html>
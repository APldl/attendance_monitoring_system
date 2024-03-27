<?php
include "connection.php";
include "attendance_generator.php";


// Update the 'new' column to 0 for the user with the specified ID
$queryUpdateNewColumn = "UPDATE faculty_attendance SET `new` = 0 WHERE user_id = $user_id";
mysqli_query($conn, $queryUpdateNewColumn);

?>


<script type="text/javascript">
  function logout(){
    if (confirm("Are you sure you want to log out?")) {
      window.location.href = "../login.php";
    }
} 
</script>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="attendanceStyle.css">
  <title>

  </title>
  </head>
    <body>
      <nav>
         <div class="d-flex justify-content-centerlogo">
             <img class="logo" src="https://signin.apc.edu.ph/images/logo.png" width="60px"/>
         </div>
         <label class = "logo">Attendance Monitoring System</label>

        <ul>
    

       
      <li class="logout-link">
         <a href="#">
          <?php echo $_SESSION['user_fullname'];
        ?>
          <div class="dropdown-menu">
            <div class="logout-box">
              <span id="user_full_name" name="full_name" class="log-out-name" onselectstart="return false;" onclick="collapse_logout()">
              
              </span>
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
            <li class="dropdown">
                <a href="dashboard_PR.php" class="dropdown-toggle">School of Engineering</a>
                <div class="dropdown-content">
                    <a href="overall.php">Overall Absences</a>
                </div>
            </li>
        </ul>
    </div>
    <div class="main_content">
        <div class="info">
            <div>lorem lorem</div>
        </div>
    </div>
</div>

<div class="report_type">
  <a>Overall Report</a>
</div>

<div class="wrapper2">
  <div class="main_content">
    <div class="info">
        <div class="details">
        </div>
      </div>
    </div>

    <!-- Button to open search tab -->
    <button id="search-button">Filter Search</button>

    <!-- Search tab -->
<div id="search-tab" style="display: none;">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
    <label for="date-input">Select Exact Date:</label>
    <input type="date" id="date-input" name="search_date">
    <br>
    <label for="month-input">Search by Month Only:</label>
    <input type="month" id="month-input" name="search_month">
    <br>
    <label for="week-input">Search by Week:</label>
    <input type="week" id="week-input" name="search_week">
    <br>
    <label for="absent-checkbox">Absent:</label>
    <input type="checkbox" id="absent-checkbox" name="absent" checked>
    <br>
    <label for="substituted-checkbox">Substituted:</label>
    <input type="checkbox" id="substituted-checkbox" name="substituted">
    <br>
    <input type="hidden" name="id" value="<?php echo $user_id; ?>">
    <button type="submit" id="search-submit">Search</button>

  </form>
</div>
  </div>
</div>

<?php
$currentDate = date('Y-m-d');
$userId = $user_id; // Replace this with the appropriate variable that holds the user ID

// Check if a specific date is submitted via the search form
if (isset($_GET['search_date']) && !empty($_GET['search_date'])) {
    // Get the submitted date
    $searchDate = $_GET['search_date'];

    // Update the query to retrieve rows for the selected date
    $sql = "SELECT attendance_id, date, subject_code, room, Time_In, Time_Out, schedule_time, notes, status, section, day, faculty_attendance.user_id, employee_no
            FROM faculty_attendance 
            JOIN user ON faculty_attendance.user_id = user.user_id
            WHERE faculty_attendance.user_id IN (SELECT user_id FROM user WHERE school_department = 'School of Engineering') 
            AND date = '$searchDate' ";

    // Check if "Absent" checkbox is checked
    if (isset($_GET['absent']) && !empty($_GET['absent'])) {
        $sql .= "AND status = 'Absent' ";
    }

    // Check if "Substitute" checkbox is checked
    if (isset($_GET['substituted']) && !empty($_GET['substituted'])) {
        $sql .= "AND status = 'Substituted' ";
    }

} elseif (isset($_GET['search_month']) && !empty($_GET['search_month'])) {
    // Get the submitted month
    $searchMonth = $_GET['search_month'];

    // Get the start and end dates of the month
    $startMonth = date('Y-m-01', strtotime($searchMonth));
    $endMonth = date('Y-m-t', strtotime($searchMonth));

    // Update the query to retrieve rows for the selected month
    $sql = "SELECT attendance_id, date, subject_code, room, Time_In, Time_Out, schedule_time, notes, status, section, day, faculty_attendance.user_id, employee_no
            FROM faculty_attendance 
            JOIN user ON faculty_attendance.user_id = user.user_id
            WHERE faculty_attendance.user_id IN (SELECT user_id FROM user WHERE school_department = 'School of Engineering') 
            AND date BETWEEN '$startMonth' AND '$endMonth' ";

    // Check if "Absent" checkbox is checked
    if (isset($_GET['absent']) && !empty($_GET['absent'])) {
        $sql .= "AND status = 'Absent' ";
    }

    // Check if "Substitute" checkbox is checked
    if (isset($_GET['substituted']) && !empty($_GET['substituted'])) {
        $sql .= "AND status = 'Substituted' ";
    }

} elseif (isset($_GET['search_week']) && !empty($_GET['search_week'])) {
    // Get the submitted week
    $searchWeek = $_GET['search_week'];

    // Extract the year and week number from the submitted value
    $year = date('Y', strtotime($searchWeek));
    $week = date('W', strtotime($searchWeek));

    // Calculate the start and end dates of the week
    $startDate = date('Y-m-d', strtotime($year . 'W' . $week));
    $endDate = date('Y-m-d', strtotime($year . 'W' . $week . '7'));

    // Update the query to retrieve rows for the selected week
    $sql = "SELECT attendance_id, date, subject_code, room, Time_In, Time_Out, schedule_time, notes, status, section, day, faculty_attendance.user_id, employee_no
            FROM faculty_attendance 
            JOIN user ON faculty_attendance.user_id = user.user_id
            WHERE faculty_attendance.user_id IN (SELECT user_id FROM user WHERE school_department = 'School of Engineering') 
            AND date BETWEEN '$startDate' AND '$endDate' ";

    // Check if "Absent" checkbox is checked
    if (isset($_GET['absent']) && !empty($_GET['absent'])) {
        $sql .= "AND status = 'Absent' ";
    }

    // Check if "Substitute" checkbox is checked
    if (isset($_GET['substituted']) && !empty($_GET['substituted'])) {
        $sql .= "AND status = 'Substituted' ";
    }

} else {
    // Get the start and end dates of the current month
    $startMonth = date('Y-m-01');
    $endMonth = date('Y-m-t');

    // Check if "Substitute" checkbox is checked
    if (isset($_GET['substituted']) && !empty($_GET['substituted'])) {
        // Update the query to retrieve substitute rows for the current month
        $sql = "SELECT attendance_id, date, subject_code, room, Time_In, Time_Out, schedule_time, notes, status, section, day, faculty_attendance.user_id, employee_no
                FROM faculty_attendance 
                JOIN user ON faculty_attendance.user_id = user.user_id
                WHERE faculty_attendance.user_id IN (SELECT user_id FROM user WHERE school_department = 'School of Engineering') 
                AND date BETWEEN '$startMonth' AND '$endMonth' 
                AND status = 'Substituted' ";
    } else {
        // Update the query to retrieve rows for the current month with a status of 'Absent'
        $sql = "SELECT attendance_id, date, subject_code, room, Time_In, Time_Out, schedule_time, notes, status, section, day, faculty_attendance.user_id, employee_no
                FROM faculty_attendance 
                JOIN user ON faculty_attendance.user_id = user.user_id
                WHERE faculty_attendance.user_id IN (SELECT user_id FROM user WHERE school_department = 'School of Engineering') 
                AND date BETWEEN '$startMonth' AND '$endMonth' 
                AND status = 'Absent' ";
    }

    // Check if "Absent" checkbox is checked
    if (isset($_GET['absent']) && !empty($_GET['absent'])) {
        $sql .= "AND status = 'Absent' ";
    }

    // Check if "Substitute" checkbox is checked
    if (isset($_GET['substituted']) && !empty($_GET['substituted'])) {
        $sql .= "AND status = 'Substituted' ";
    }
}

$sql .= "ORDER BY date DESC";

$result = mysqli_query($conn, $sql);


if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}
?>

<form action="" method="POST" id="attendance-form">
    <button id="download-button" download="attendance.csv">Download</button>
    <table id="attendance-table">
        <thead>
            <tr>
                <th class="sortable" data-column="0">Employee ID</th>
                <th class="sortable" data-column="1">Faculty</th>
                <th class="sortable" data-column="2">Department</th>
                <?php

                // Check if "Substitute" checkbox is checked
                if (isset($_GET['substituted']) && !empty($_GET['substituted'])) {
                    echo '<th class="sortable" data-column="4">Total Substitutes</th>';
                } else{
                  echo '<th class="sortable" data-column="3">Total Absences</th>';
                }
                ?>
                <th class="sortable" data-column="3">Total Hours</th>

            </tr>
        </thead>
        <tbody>
            <?php
            // Associative array to keep track of faculty data
            $facultyData = array();

while ($row = mysqli_fetch_assoc($result)) {
    $userId = $row['user_id'];

    // Query to fetch the user details for the current row
    $userQuery = "SELECT user_fullname, school_department FROM user WHERE user_id = '$userId'";
    $userResult = mysqli_query($conn, $userQuery);

    if (!$userResult) {
        die('User query failed: ' . mysqli_error($conn));
    }

    $userRow = mysqli_fetch_assoc($userResult);
    $fullname = $userRow['user_fullname'];
    $school_department = $userRow['school_department'];

    // Initialize the counters for absences and substitutes if not already set
    if (!isset($facultyData[$userId])) {
        $facultyData[$userId] = array(
            'fullname' => $fullname,
            'school_department' => $school_department,
            'employee_no' => $row['employee_no'],
            'totalAbsences' => 0,
            'totalSubstitutes' => 0,
            'totalHours' => 0, // Initialize totalHours to 0
        );
    }

    // Extract the start and end times from the "schedule_time" value
    $scheduleTime = $row['schedule_time'];
    list($startTime, $endTime) = explode(' - ', $scheduleTime);

    // Calculate the difference in time
    $start = strtotime($startTime);
    $end = strtotime($endTime);
    $timeDiffInSeconds = $end - $start;

    // Calculate total hours in 30-minute intervals
    $totalHours = ($timeDiffInSeconds / 60) / 30 * 0.5;

    // Add the "Total Hours" to the faculty data
    $facultyData[$userId]['totalHours'] += $totalHours;
    
    // Round the "Total Hours" to 2 decimal places
    $facultyData[$userId]['totalHours'] = round($facultyData[$userId]['totalHours'], 2);

    // Update absence and substitute counts
    if ($row['status'] === 'Absent') {
        $facultyData[$userId]['totalAbsences']++;
    } elseif ($row['status'] === 'Substituted') {
        $facultyData[$userId]['totalSubstitutes']++;
    }
}






            // Display faculty data
            foreach ($facultyData as $faculty) {
                echo "<tr>";
                echo "<td>{$faculty['employee_no']}</td>"; // Display Employee Id
                echo "<td>{$faculty['fullname']}</td>";
                echo "<td>{$faculty['school_department']}</td>";

                if (isset($_GET['substituted']) && !empty($_GET['substituted'])) {
                    echo "<td>{$faculty['totalSubstitutes']}</td>";
                } else{
                  echo "<td>{$faculty['totalAbsences']}</td>";
                }
                echo "<td>{$faculty['totalHours']}</td>"; // Display Total Hours

                echo "</tr>";
            }

            // Check if no rows were retrieved
            if (mysqli_num_rows($result) === 0) {
                echo "<tr><td colspan='5'>NO ATTENDANCE FOUND</td></tr>";
            }
            ?>
        </tbody>
    </table>
</form>

<script>
  // Add event listener to the download button
  document.getElementById('download-button').addEventListener('click', function() {
    // Retrieve the table element
    const table = document.getElementById('attendance-table');

    // Create a CSV string
    let csvContent = '';

    // Loop through each row in the table
    for (const row of table.rows) {
      // Loop through each cell in the row
      for (const cell of row.cells) {
        // Add the cell value to the CSV string
        csvContent += cell.innerText + ',';
      }

      // Add a new line character after each row
      csvContent += '\n';
    }

    // Create a Blob object with the CSV content
    const blob = new Blob([csvContent], { type: 'text/csv' });

    // Create a temporary URL for the Blob
    const url = URL.createObjectURL(blob);

    // Create a link element
    const link = document.createElement('a');

    // Set the href and download attributes
    link.href = url;
    link.download = 'attendance.csv';

    // Simulate a click event to trigger the download
    link.click();

    // Clean up the temporary URL object
    URL.revokeObjectURL(url);
  });
</script>

<script>
  // JavaScript code to show/hide the search tab
  const searchButton = document.getElementById('search-button');
  const searchTab = document.getElementById('search-tab');

  searchButton.addEventListener('click', function() {
    searchTab.style.display = 'block';
  });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('.sortable').click(function() {
      const column = $(this).data('column');
      sortTable(column);
    });
  });

  function sortTable(column) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("attendance-table");
    switching = true;
    dir = "asc";
    while (switching) {
      switching = false;
      rows = table.rows;
      for (i = 1; i < (rows.length - 1); i++) {
        shouldSwitch = false;
        x = rows[i].getElementsByTagName("td")[column];
        y = rows[i + 1].getElementsByTagName("td")[column];
        if (dir == "asc") {
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            shouldSwitch = true;
            break;
          }
        } else if (dir == "desc") {
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            shouldSwitch = true;
            break;
          }
        }
      }
      if (shouldSwitch) {
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        switchcount++;
      } else {
        if (switchcount == 0 && dir == "asc") {
          dir = "desc";
          switching = true;
        }
      }
    }
  }

</script>

<script>
  // Get the checkbox elements
  var absentCheckbox = document.getElementById('absent-checkbox');
  var substitutedCheckbox = document.getElementById('substituted-checkbox');

  // Add event listeners to handle checkbox changes
  absentCheckbox.addEventListener('change', function() {
    if (absentCheckbox.checked) {
      substitutedCheckbox.checked = false;
    }
  });

  substitutedCheckbox.addEventListener('change', function() {
    if (substitutedCheckbox.checked) {
      absentCheckbox.checked = false;
    }
  });
</script>

</body>




  <title>Attendance</title>
  <style>

  </style>
</head>
<body>


</body>
</html>
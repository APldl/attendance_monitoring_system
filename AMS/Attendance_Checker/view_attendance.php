<?php
include "connection.php";

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // retrieve the user details from the user table
    $query_user = "SELECT * FROM user WHERE user_id = $user_id";
    $result_user = mysqli_query($conn, $query_user);

    if (mysqli_num_rows($result_user) > 0) {
        $row_user = mysqli_fetch_assoc($result_user);
        $fullname = $row_user['user_fullname'];
        $school_department = $row_user['school_department'];
        // add more user details here as needed
    } else {
        // handle user not found error here
    }

    // retrieve the schedule details from the schedule table
    $query_schedule = "SELECT * FROM schedule WHERE user_id = $user_id";
    $result_schedule = mysqli_query($conn, $query_schedule);

    if (mysqli_num_rows($result_schedule) > 0) {
        $row_schedule = mysqli_fetch_assoc($result_schedule);
        $academic_year = $row_schedule['academic_year'];
        // add more schedule details here as needed

    } else {
        if (empty($academic_year)) {
        $academic_year = "No Academic Year is Set";
    }
    }
} else {
    // handle missing user_id parameter error here
}


    // retrieve the user details from the user table
    $query_user = "SELECT * FROM user WHERE user_id = $user_id";
    $result_user = mysqli_query($conn, $query_user);

    if (mysqli_num_rows($result_user) > 0) {
        $row_user = mysqli_fetch_assoc($result_user);
        $fullname = $row_user['user_fullname'];
        $school_department = $row_user['school_department'];
        // add more user details here as needed
    } else {
        // handle user not found error here
    }

    // retrieve the schedule details from the schedule table
    $query_schedule = "SELECT * FROM schedule WHERE user_id = $user_id";
    $result_schedule = mysqli_query($conn, $query_schedule);

    if (mysqli_num_rows($result_schedule) > 0) {
        $row_schedule = mysqli_fetch_assoc($result_schedule);
        $academic_year = $row_schedule['academic_year'];
        // add more schedule details here as needed
    } else {
        // handle schedule not found error here
    }

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
                <li><a href="dashboard_AC.php">School of Engineering</a></li>
            </ul>
        
        </div>
        <div class="main_content">
            <div class="info">
                <div>lorem lorem</div>
            </div>
        </div>
    </div>

<div class="wrapper2">
  <div class="main_content">
    <div class="info">
      <div class="profile-container">
        <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="User Profile Picture">
        <div class="details">
          <p><span class="not-bold">Faculty Name:</span> <span><?php echo $fullname; ?></span></p>
          <p><span class="not-bold">Academic Year:</span> <span><?php echo $academic_year; ?></span></p>
          <p><span class="not-bold">School Department:</span> <span><?php echo $school_department; ?></span></p>
        </div>
        <form method="POST">
        <label for="status">Month:</label>
        <select id="status" name="status">
          <option value=""></option>
          <option value="January">January</option>
          <option value="February">February</option>
          <option value="March">March</option>
          <option value="April">April</option>
          <option value="May">May</option>
          <option value="June">June</option>
          <option value="July">July</option>
          <option value="August">August</option>
          <option value="September">September</option>
          <option value="October">October</option>
          <option value="November">November</option>
          <option value="December">December</option>
        </select>
        <br>
        <label for="date">Year</label>
        <input type="text" id="year" name="year" size="2">
        <br>
        <button name="btn_search" type="submit">Search</button>

      </form>
      </div>
    </div>
  </div>
</div>


<?php
if (isset($_POST['btn_search'])) {
  $month = mysqli_real_escape_string($conn, $_POST['status']);
  $year = mysqli_real_escape_string($conn, $_POST['year']);

  if (empty($month) && empty($year)) {
    $sql = "SELECT date, subject_code, room, Time_In, Time_Out, schedule_time, notes, status FROM faculty_attendance WHERE user_id = '$user_id' ORDER BY date DESC";
  } elseif(empty($year)){
    // Convert month string to numeric value
    $month_num = date_parse($month)['month'];


    $sql = "SELECT date, subject_code, room, Time_In, Time_Out, schedule_time, notes, status FROM faculty_attendance WHERE user_id = '$user_id' AND MONTH(date) = '$month_num' ORDER BY date DESC";
  } else {
    // Convert month string to numeric value
    $month_num = date_parse($month)['month'];

    // Convert year string to numeric value
    $year_num = intval($year);

    $sql = "SELECT date, subject_code, room, Time_In, Time_Out, schedule_time, notes, status FROM faculty_attendance WHERE user_id = '$user_id' AND MONTH(date) = '$month_num' AND YEAR(date) = '$year_num' ORDER BY date DESC";
  }

  $table = mysqli_query($conn, $sql);
  if (mysqli_num_rows($table) > 0) {
    echo "<table>";
    echo "<tr><th>Date</th><th>Subject Code</th><th>Room</th><th>Time In</th><th>Time Out</th><th>Schedule Time</th><th>Notes</th><th>Status</th></tr>";
    while($row = mysqli_fetch_assoc($table)) {
      echo "<tr>";
      echo "<td class='table__cell'>" . $row["date"] . "</td>";
      echo "<td class='table__cell'>" . $row["subject_code"] . "</td>";
      echo "<td class='table__cell'>" . $row["room"] . "</td>";
      echo "<td class='table__cell'>" . $row["Time_In"] . "</td>";
      echo "<td class='table__cell'>" . $row["Time_Out"] . "</td>";
      echo "<td class='table__cell'>" . $row["schedule_time"] . "</td>";
      echo "<td class='table__cell'>" . $row["notes"] . "</td>";
      echo "<td class='table__cell'>" . $row["status"] . "</td>";
      echo "</tr>";
    }
    echo "</table>";
  } else {
    echo "<p class='attendance-not-found'>No attendance found for the selected month and year.</p>";
  }

}elseif(true){
$sql = "SELECT date, subject_code, room, Time_In, Time_Out, schedule_time, notes, status FROM faculty_attendance WHERE user_id = '".$user_id."' ORDER BY date DESC";
    $table = mysqli_query($conn, $sql);

// Display data in table
if (mysqli_num_rows($table) > 0) {
  echo "<table>";
  echo "<tr><th>Date</th><th>Subject Code</th><th>Room</th><th>Time In</th><th>Time Out</th><th>Schedule Time</th><th>Notes</th><th>Status</th></tr>";
  while($row = mysqli_fetch_assoc($table)) {
    echo "<tr>";
    echo "<td class='table__cell'>" . $row["date"] . "</td>";
    echo "<td class='table__cell'>" . $row["subject_code"] . "</td>";
    echo "<td class='table__cell'>" . $row["room"] . "</td>";
    echo "<td class='table__cell'>" . $row["Time_In"] . "</td>";
    echo "<td class='table__cell'>" . $row["Time_Out"] . "</td>";
    echo "<td class='table__cell'>" . $row["schedule_time"] . "</td>";
    echo "<td class='table__cell'>" . $row["notes"] . "</td>";
    echo "<td class='table__cell'>" . $row["status"] . "</td>";
    echo "</tr>";
  }
  echo "</table>";
} else {
  echo "<p class='attendance-not-found'>No attendance found.</p>";
}
} else {
  echo "<p class='attendance-not-found'>No attendance found.</p>";;
}

?>



</body>




  <title>Attendance</title>
  <style>

  </style>
</head>
<body>





</body>
</html>
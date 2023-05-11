<?php
require_once 'connection.php';


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
    <title>Attendance Monitoring System</title>

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
                <li><a href="dashboard_FE.php">School of Engineering</a></li>
            </ul>
        
        </div>
        <div class="main_content">
            <div class="info">
                <div>lorem lorem</div>
            </div>
        </div>
    </div>

</head>
<body>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="FEStyle.css">
</head>
<body>

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
                    </div> 
                </div>
            </div>
        </div>
    </div>
</body>

<?php if (isset($_GET['show_alert']) && $_GET['show_alert'] == 1): ?>
  <script>
    alert("<?php echo $_GET['error_message']; ?>");
  </script>
<?php endif; ?>



<div class="container-tb">
  <table class="table">
    <thead>
      <tr>
        <th>Subject Code</th>
        <th>Subject Units</th>
        <th>Schedule Day</th>
        <th>Section</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Room</th>
      </tr>
    </thead>
    <tbody>
      <?php
        // Include database connection file

        // Retrieve data from database
        $sql = "SELECT * FROM schedule WHERE user_id = '".$user_id."'";
        $result = mysqli_query($conn, $sql);

        // Display data in table
        if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td class='table__cell'>" . $row["subject_code"] . "</td>";
            echo "<td class='table__cell'>" . $row["subject_units"] . "</td>";
            echo "<td class='table__cell'>" . $row["schedule_day"] . "</td>";
            echo "<td class='table__cell'>" . $row["section"] . "</td>";
            echo "<td class='table__cell'>" . $row["schedule_time_start"] . "</td>";
            echo "<td class='table__cell'>" . $row["schedule_time_end"] . "</td>";
            echo "<td class='table__cell'>" . $row["room"] . "</td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td class='table__cell' colspan='7'>No schedule found.</td></tr>";
        }



        // Close database connection
        mysqli_close($conn);
      ?>
    </tbody>
  </table>
</div>




  <div class="edit-icon">
    <a href="edit_sched_function.php?id=<?php echo $user_id; ?>">
      <img src="https://www.clipartmax.com/png/small/121-1212430_white-edit-11-icon-edit-icon-bootstrap-png.png" alt="White Edit 11 Icon - Edit Icon Bootstrap Png @clipartmax.com" alt="Edit Icon">
      Edit
    </a>
  </div>

</body>
</html>

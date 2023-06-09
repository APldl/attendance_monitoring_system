<?php
require_once "connection.php";

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
  <link rel="stylesheet" href="FMStyle.css">
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
      <h2>Viewing</h2>
      <ul>
        <li><a href="dashboard_FM.php">View Class Schedule</a></li>
        <li><a href="view_attendance.php">View Attendance Records</a></li>
        <li><a href="#">View Approved Requests</a></li>
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


  <title>Here is your class Schedule</title>
  <style>
    .container {
      max-width: 870px;
      margin: 0 auto;
      padding: 10px;
      font-family: Arial, sans-serif;
      margin-right: 200px; /* add margin to move the container to the right */
    }

    .table {
      border-collapse: collapse;
      width: 100%;
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
  </style>
</head>
<body>
  <div class="container">
    <h1>Class Schedule</h1>
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
          $user_id = $_SESSION['user_id'];
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

</body>
</html>
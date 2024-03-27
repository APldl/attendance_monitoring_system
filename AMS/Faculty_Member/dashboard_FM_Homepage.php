<?php
require_once "connection.php";

include "attendance_generator.php";

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
<ul>

  <?php
    // Retrieve user_id from the session
$user_id = $_SESSION['user_id'];

// Fetch 'alert' value for the given user_id from the schedule table
$sql = "SELECT alert FROM schedule WHERE user_id = '$user_id' AND alert = 'True'";
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
  $alert_query_result = $result->fetch_assoc();

  if ($alert_query_result['alert'] === "True") {
    echo '<ul><li><a href="dashboard_FM.php">View Class Schedule <span class="red-circle">!</span></a></li></ul>';
  } else {
    echo '<ul><li><a href="dashboard_FM.php">View Class Schedule</a></li></ul>';
  }
} else {
  echo 'Error executing query: ' . $conn->error;
}
  ?>
</ul>


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
      max-width: 800px;
      margin: 0 auto;
      padding: 10px;
      font-family: Arial, sans-serif;
      margin-right: 70px; /* add margin to move the container to the right */
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
            .user-fullname {
            margin-left: 300px;
            font-size: 35px;
            color: black;
            font-weight: bold;
        }
  </style>
</head>
<body>
  

    <div id="unique-identifier">
        <span class="user-fullname">
<?php
            date_default_timezone_set('Asia/Manila');
            $currentTime = date('H:i:s');
            $greeting = '';

            if ($currentTime >= '06:00:00' && $currentTime < '12:00:00') {
                $greeting = 'Good morning';
            } elseif ($currentTime >= '12:00:00' && $currentTime < '18:00:00') {
                $greeting = 'Good afternoon';
            } else {
                $greeting = 'Good evening';
            }

            echo $greeting . ', ' . $_SESSION['user_fullname'];
            ?>
        </span>
    </div>

</body>
</html>
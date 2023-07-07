<?php
    require 'connection.php';
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
    <link rel="stylesheet" href="AdminStyle.css">
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
  
            <h2>Filter users</h2>
            <ul>
            <li><a href="dashboard_Admin2.php">Attendance Checker</a></li>
            </ul>
                        <ul>
            <li><a href="dashboard_Admin3.php">Faculty Encoder</a></li>
            </ul>
                        <ul>
            <li><a href="dashboard_Admin4.php">Faculty Head</a></li>
            </ul>
                        <ul>
            <li><a href="dashboard_Admin5.php">Payroll</a></li>
            </ul>
            <h2>Schools</h2>
            <ul>
                <li><a href="dashboard_AdminE.php">School of Engineering</a></li>
            </ul>
        
        </div>
        <div class="main_content">
            <div class="info">
                <div>lorem lorem</div>
            </div>
        </div>
    </div>

    <div id="unique-identifier">
        <span class="user-fullname">
            <?php
            date_default_timezone_set('Your_Timezone'); // Replace 'Your_Timezone' with the desired timezone
            $currentTime = date('H:i:s');
            $greeting = '';

            if ($currentTime >= '06:00:00' && $currentTime < '12:00:00') {
                $greeting = 'Good afternoon';
            } elseif ($currentTime >= '12:00:00' && $currentTime < '18:00:00') {
                $greeting = 'Good morning';
            } else {
                $greeting = 'Good evening';
            }

            echo $greeting . ', ' . $_SESSION['user_fullname'];
            ?>
        </span>
    </div>

</body>
</html>

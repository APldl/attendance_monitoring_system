<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="FC.css">
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
      <!-- <li><a href="#"> <b><?php echo $_SESSION['user_fullname'];?></b> </a></li> -->
        <li class="logout-link">
        <a href="#">
          I am Faculty Head
          <div class="dropdown-menu">
            <div class="logout-box">
              <span id="user_full_name" name="full_name" class="log-out-name" onselectstart="return false;" onclick="collapse_logout()">
              
              </span>
              <span id="user_role_type" name="role_type" class="role-type" onselectstart="return false;">
                          </span>
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
			<h2>Faculty Member</h2>
			<ul>
				<li><a href="#">Select Faculty Member</a></li>
			</ul>
		
		</div>
		<div class="main_content">
			<div class="info">
				<
			</div>
		</div>
	</div>

</body>
</html>
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
			<li><a href="#"><b>

        <?php echo $_SESSION['user_fullname'];
        ?>

      </b></a></li>
		</ul>
	 
	</nav>

	<div class="wrapper">
		<div class="sidebar">
			<h2>Faculty Members</h2>
			<ul>
				<li><a href="#">Select Faculty Member</a></li>
			</ul>
		
		</div>
		<div class="main_content">
			<div class="info">
				<div>lorem lorem</div>
			</div>
		</div>
	</div>

</body>
</html>
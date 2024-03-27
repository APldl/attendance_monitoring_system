
<?php
include "connection.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="EXPStyle.css">
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
          I am Attendance Checker
          <div class="dropdown-menu">
            <div class="logout-box">
              <span id="user_full_name" name="full_name" class="log-out-name" onselectstart="return false;" onclick="collapse_logout()">
                <?php include 'admin_name.php';?>
              </span>
              <span id="user_role_type" name="role_type" class="role-type" onselectstart="return false;">
                <?php include 'admin_role.php';?>
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
			<h2>Schools</h2>
			<ul>
				<li><a href="#">School of Engineering</a></li>
			</ul>
		
		</div>
		<div class="main_content">
			<div class="info">
				<
			</div>
		</div>
	</div>
	<div class="attendance-form">
		<div class="profile-picture">
  <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="Profile Picture">
</div> 
  <h1>Faculty Member Record</h1>
  	<form action="submit.php" method="post">
		<label for="name">Name:</label>
		<input type="text" id="name" name="name" value="Einstein D. Yong" readonly>
		<br>
		<label for="subject">Subject:</label>
		<input type="text" id="subject" name="subbject" required>
		<br>
		<label for="date">Date:</label>
		<input type="date" id="date" name="date" required>
		<br>

		<label for="status">Attendance:</label>
		<select id="status" name="status" required>
			<option value="">Select</option>
			<option value="Present">Present</option>
			<option value="Absent">Absent</option>
		</select>
		<br>
		<input type="button" value="Submit" onclick="recordAttendance()">
	</form>
	<script>
		function recordAttendance() {
			// Get the values from the form
			var name = document.getElementById("name").value;
				var subject = document.getElementById("subject").value;
			var date = document.getElementById("date").value;
			var status = document.getElementById("status").value;

			// Create a new table row
			// Create a new table row
var table = document.getElementById("attendanceTable");
var row = table.insertRow(-1);

// Add the data to the row
var nameCell = row.insertCell(0);
var subCell = row.insertCell(1);
var dateCell = row.insertCell(2);
var statusCell = row.insertCell(3);
nameCell.innerHTML = name;
subCell.innerHTML = subject;
dateCell.innerHTML = date;
statusCell.innerHTML = status;


			// Reset the form
			document.getElementById("name").value = nameValue;
			document.getElementById("subject").value = "";
			document.getElementById("date").value = "";
			document.getElementById("status").value = "";
		}
	</script>

	<h2>Attendance Record</h2>
		<table class="table">
  		<tr>
    		<th>Name</th>
    		<th>Subject</th>
    		<th>Date</th>
    		<th>Attendance</th>
  		</tr>
  		 <tbody id="attendanceTable">
    <!-- table rows will be inserted here -->
  </tbody>
</table>
</div>


</body>
</html>
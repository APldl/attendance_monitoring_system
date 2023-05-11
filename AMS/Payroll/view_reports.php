<?php
    require_once 'connection.php';
    require 'connection2.php';



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
    <link rel="stylesheet" href="payphone.css">
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
        <form method="POST" id="searchForm">
        <label for="status">Month:</label>
        <select id="status" name="status">
          <option value="current_month">Current Month</option>
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
        <button name="btn_search" type="submit">Search</button>
      </form>
        </div>


    <div class="weekTable">
        <table>
            <thead>
                <tr>
                    <th>Week</th>
                    <th>Days</th>
                    <th>Absences</th>
                </tr>
            </thead>
            <tbody id="tableBody">
            </tbody>
        </table>
    </div>

    <script>
// Function to calculate the start and end dates of each week in a given month
function calculateWeeks() {
  var currentDate = new Date();
  var currentYear = currentDate.getFullYear();
  var tableBody = document.getElementById("tableBody");

  var selectedMonth = document.getElementById("status").value;
  var monthIndex;

  if (selectedMonth === "current_month") {
    monthIndex = currentDate.getMonth();
  } else {
    monthIndex = new Date(selectedMonth + " 1, " + currentYear).getMonth();
  }

  var firstDayOfMonth = new Date(currentYear, monthIndex, 1);
  var lastDayOfMonth = new Date(currentYear, monthIndex + 1, 0);
  var currentDay = new Date(firstDayOfMonth);

  tableBody.innerHTML = ""; // Clear previous table rows

  var weekCounter = 0; // Counter to limit to four weeks

  while (currentDay <= lastDayOfMonth && weekCounter < 4) {
    (function () {
      var user_id = <?php echo isset($_GET['id']) ? $_GET['id'] : 'null'; ?>;
      var weekRow = document.createElement("tr");
      var weekCell = document.createElement("td");
      var daysCell = document.createElement("td");
      var absencesCell = document.createElement("td");

      var weekNumber = Math.ceil((currentDay.getDate() + firstDayOfMonth.getDay() + 1) / 7); // Add 1 day to start 1 day ahead

      weekCell.textContent = "Week " + weekNumber;

      var startOfWeek = new Date(currentDay);
      startOfWeek.setDate(startOfWeek.getDate() - startOfWeek.getDay() + 1); // Add 1 day to start 1 day ahead
      var endOfWeek = new Date(startOfWeek);
      endOfWeek.setDate(endOfWeek.getDate() + 6);

      var startDate = startOfWeek.toISOString().slice(0, 10);
      var endDate = endOfWeek.toISOString().slice(0, 10);
      daysCell.textContent = startDate + " to " + endDate;

      // Make an AJAX request to count the absences for the current date range
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            var absencesCount = xhr.responseText;
            absencesCell.textContent = absencesCount;
          } else {
            absencesCell.textContent = "Error";
          }
        }
      };

      xhr.open("POST", "check_absences.php", true);
      xhr.setRequestHeader("Content-Type", "application/json");

  var requestData = {
    startDate: startDate,
    endDate: endDate,
    user_id: user_id
  };

      xhr.send(JSON.stringify(requestData));

      weekRow.appendChild(weekCell);
      weekRow.appendChild(daysCell);
      weekRow.appendChild(absencesCell);
      tableBody.appendChild(weekRow);

      currentDay.setDate(currentDay.getDate() + 7);
      weekCounter++;
    })();
  }
}

// Event listener for form submission
document.getElementById("searchForm").addEventListener("submit", function(event) {
  event.preventDefault(); // Prevent form submission

  calculateWeeks(); // Generate the table based on the selected month
});
calculateWeeks();
    </script>

    <a href="#" class="download-button">Download</a>




</body>
</html>
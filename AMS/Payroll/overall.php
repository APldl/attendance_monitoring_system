<?php
    require_once 'connection.php';
    require 'connection2.php';

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


<div class="report_type">
  <a>School of Engineering</a>
  <div class="dropdown2">
    <button class="dropbtn">Filter</button>
    <div class="dropdown-content2">
      <a href="#" onclick="filterData('weekly')">Weekly</a>
      <a href="#" onclick="filterData('monthly')">Monthly</a>
    </div>
  </div>
</div>

<div class="report_type">
  <a> <span id="currentWeekDates" style="display: none;"></span></a>
</div>


<div class="weekTable">
  <table>
    <thead>
      <tr>
        <th>Faculty Member</th>
        <th>Employee ID</th>
        <th>Absences</th>
      </tr>
    </thead>
    <tbody id="tableBody">
    </tbody>
  </table>
</div>

<div class="report_type">
  <a>Total Absences: <span id="totalAbsences"></span></a>
</div>

<script>
  // Fetch data from server-side PHP script using AJAX
  function fetchData() {
    const xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {
        const data = JSON.parse(this.responseText);
        populateTable(data);
      }
    };

    xhttp.open("GET", "fetch_data.php", true);
    xhttp.send();

    // Hide current week dates initially
    hideCurrentWeekDates();
  }

  // Populate table with fetched data
  function populateTable(data) {
    const tableBody = document.getElementById('tableBody');
    let totalAbsences = 0;

    data.forEach(user => {
      const row = tableBody.insertRow();
      const nameCell = row.insertCell(0);
      const employeeIdCell = row.insertCell(1); // Updated column index
      const absencesCell = row.insertCell(2); // Updated column index
      nameCell.innerHTML = user.user_fullname;
      employeeIdCell.innerHTML = user.employee_no; // Updated property name
      absencesCell.innerHTML = user.absences;
      totalAbsences += parseInt(user.absences);
    });

    // Display total absences
    document.getElementById('totalAbsences').innerHTML = totalAbsences.toString();
  }

  // Filter data based on selection
  function filterData(filterType) {
    const xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {
        const data = JSON.parse(this.responseText);
        clearTable();
        populateTable(data);

        if (filterType === 'weekly') {
          updateCurrentWeekDates();
        } else {
          hideCurrentWeekDates();
        }
      }
    };

    let url = 'fetch_data.php';
    if (filterType === 'weekly') {
      const startDate = getWeekStartDate();
      const endDate = getWeekEndDate();
      url += '?startDate=' + startDate + '&endDate=' + endDate;
    } else if (filterType === 'monthly') {
      const currentMonth = new Date().getMonth() + 1;
      url += '?month=' + currentMonth;
    }

    xhttp.open("GET", url, true);
    xhttp.send();
  }

  // Clear table body
  function clearTable() {
    const tableBody = document.getElementById('tableBody');
    while (tableBody.firstChild) {
      tableBody.removeChild(tableBody.firstChild);
    }
  }

  // Get the start date of the current week
  function getWeekStartDate() {
    const today = new Date();
    const startOfWeek = today.getDate() - today.getDay();
    const startDate = new Date(today.setDate(startOfWeek));
    return formatDate(startDate);
  }

  // Get the end date of the current week
  function getWeekEndDate() {
    const today = new Date();
    const endOfWeek = today.getDate() + (6 - today.getDay());
    const endDate = new Date(today.setDate(endOfWeek));
    return formatDate(endDate);
  }

  // Format date as "YYYY-MM-DD"
  function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  }

  // Call the function to fetch data
  fetchData();

  // Update current week dates
  function updateCurrentWeekDates() {
    const startDate = getWeekStartDate();
    const endDate = getWeekEndDate();
    const currentWeekDates = document.getElementById('currentWeekDates');
    currentWeekDates.textContent = startDate + ' to ' + endDate;
    showCurrentWeekDates();
  }

  // Show the current week dates
  function showCurrentWeekDates() {
    document.getElementById('currentWeekDates').style.display = 'inline';
  }

  // Hide the current week dates
  function hideCurrentWeekDates() {
    document.getElementById('currentWeekDates').style.display = 'none';
  }
</script>
    <a href="#" class="download-button">Download</a>


</body>
</html>
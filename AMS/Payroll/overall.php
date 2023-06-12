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
  <div class="filter_type">
    <button onclick="toggleSearchTab()">Search</button>
  </div>
</div>

<div id="searchTab" style="display: none;">
  <select id="monthDropdown">
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
  <select id="weekDropdown">
    <option value=""></option>
    <option value="1">Week 1</option>
    <option value="2">Week 2</option>
    <option value="3">Week 3</option>
    <option value="4">Week 4</option>
  </select>
  <button onclick="search()">Apply</button>
</div>

<div class="report_type">
  <a><span id="currentWeekDates" style="display: none;"></span></a>
</div>

<div class="weekTable">
  <table>
    <thead>
      <tr>
        <th>Employee Name</th>
        <th>Faculty Member</th>
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


<a href="#" class="download-button" onclick="downloadTable()">Download</a>
<script>
  // Declare the monthNames array globally
  const monthNames = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
  ];

  // Hide current week dates initially
  function hideCurrentWeekDates() {
    const currentWeekDates = document.getElementById('currentWeekDates');
    currentWeekDates.style.display = 'none';
  }

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

function populateTable(data) {
  const tableBody = document.getElementById('tableBody');
  let totalAbsences = 0;

  // Clear the table body
  clearTable();

  if (data.length === 0) {
    // Show a message if there are no results
    const messageRow = tableBody.insertRow();
    const messageCell = messageRow.insertCell(0);
    messageCell.colSpan = 3; // Span the cell across all columns
    messageCell.innerHTML = 'No results found.';

    // Hide the table header
    const tableHeader = document.getElementById('tableHeader');
    tableHeader.style.display = 'none';

    // Hide the total absences
    document.getElementById('totalAbsences').innerHTML = '';
    
    // Update the value of currentWeekDates even if there are no results
    const currentWeekDates = document.getElementById('currentWeekDates');
    const monthDropdown = document.getElementById('monthDropdown');
    const selectedMonth = monthDropdown.value;
    const weekDropdown = document.getElementById('weekDropdown');
    const selectedWeek = weekDropdown.value;
    if (selectedWeek === '') {
      // If the selected week is blank, display the month dates
      const monthNumber = convertMonthToNumber(selectedMonth);
      const startDate = getWeekStartDate(monthNumber, 1);
      const endDate = getWeekEndDate(monthNumber, getLastWeekNumber(monthNumber));
      currentWeekDates.innerHTML = `${startDate} to ${endDate}`;
    } else {
      // Display the dates for the selected week
      const monthNumber = convertMonthToNumber(selectedMonth);
      const startDate = getWeekStartDate(monthNumber, selectedWeek);
      const endDate = getWeekEndDate(monthNumber, selectedWeek);
      currentWeekDates.innerHTML = `${startDate} to ${endDate}`;
    }
    
    currentWeekDates.style.display = 'block';
    return;
  }

  data.forEach((user) => {
    const row = tableBody.insertRow();
    const employeeIdCell = row.insertCell(0);
    const nameCell = row.insertCell(1);
    const absencesCell = row.insertCell(2);
    employeeIdCell.innerHTML = user.employee_no;
    nameCell.innerHTML = user.user_fullname;
    absencesCell.innerHTML = user.absences;
    totalAbsences += parseInt(user.absences);
  });

  // Display total absences
  document.getElementById('totalAbsences').innerHTML = totalAbsences.toString();
}

  // Clear table body
  function clearTable() {
    const tableBody = document.getElementById('tableBody');
    while (tableBody.firstChild) {
      tableBody.removeChild(tableBody.firstChild);
    }
  }

 // Filter data based on selection
function filterData(filterType, month, weekNumber) {
  const xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      const data = JSON.parse(this.responseText);
      clearTable();
      populateTable(data);

      // Set the content of the currentWeekDates span element
      const currentWeekDates = document.getElementById('currentWeekDates');

      if (weekNumber === '') {
        // If the selected week is empty, display the dates for the entire month
        const startDate = getMonthStartDate(month);
        const endDate = getMonthEndDate(month);
        currentWeekDates.innerHTML = `${startDate} to ${endDate}`;
      } else {
        // Display the dates for the selected week
        const startDate = getWeekStartDate(month, weekNumber);
        const endDate = getWeekEndDate(month, weekNumber);
        currentWeekDates.innerHTML = `${startDate} to ${endDate}`;
      }

      currentWeekDates.style.display = 'block'; // Show the currentWeekDates span element
    }
  };

  let url = 'fetch_data.php';

  if (filterType === 'custom' && month && weekNumber) {
    if (weekNumber === '') {
      // If the selected week is empty, query the entire month
      const startDate = getMonthStartDate(month);
      const endDate = getMonthEndDate(month);
      url += '?startDate=' + startDate + '&endDate=' + endDate;
    } else {
      // Query the selected week
      const startDate = getWeekStartDate(month, weekNumber);
      const endDate = getWeekEndDate(month, weekNumber);
      url += '?startDate=' + startDate + '&endDate=' + endDate;
    }
  }

  xhttp.open('GET', url, true);
  xhttp.send();
}

// Get the start date of the selected week within the selected month
function getWeekStartDate(month, weekNumber) {
  const startDate = new Date(new Date().getFullYear(), month - 1, 1); // Set the month
  const startDayOfWeek = startDate.getDay(); // Get the day of the week (0-6, where 0 is Sunday)
  const offset = (startDayOfWeek > 0 ? startDayOfWeek : 7); // Calculate the offset from Sunday

  startDate.setDate(startDate.getDate() + (weekNumber - 1) * 7 - offset);
  return formatDate(startDate);
}

// Get the end date of the selected week within the selected month
function getWeekEndDate(month, weekNumber) {
  const endDate = new Date(new Date().getFullYear(), month - 1, 1); // Set the month
  const startDayOfWeek = endDate.getDay(); // Get the day of the week (0-6, where 0 is Sunday)
  const offset = (startDayOfWeek > 0 ? startDayOfWeek : 7); // Calculate the offset from Sunday

  endDate.setDate(endDate.getDate() + weekNumber * 7 - offset - 1);
  return formatDate(endDate);
}

// Filter data based on selection
function filterData(filterType, month, weekNumber) {
  const xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      const data = JSON.parse(this.responseText);
      clearTable();
      populateTable(data);

      // Set the content of the currentWeekDates span element
      let startDate, endDate;
      if (weekNumber === "") {
        startDate = getMonthStartDate(month);
        endDate = getMonthEndDate(month);
      } else {
        startDate = getWeekStartDate(month, weekNumber);
        endDate = getWeekEndDate(month, weekNumber);
      }
      document.getElementById('currentWeekDates').innerHTML = `${startDate} to ${endDate}`;
      document.getElementById('currentWeekDates').style.display = 'block'; // Show the currentWeekDates span element
    }
  };

  let url = 'fetch_data.php';

  if (filterType === 'custom' && month) {
    if (weekNumber === "") {
      const startDate = getMonthStartDate(month);
      const endDate = getMonthEndDate(month);
      url += '?startDate=' + startDate + '&endDate=' + endDate;
    } else {
      const startDate = getWeekStartDate(month, weekNumber);
      const endDate = getWeekEndDate(month, weekNumber);
      url += '?startDate=' + startDate + '&endDate=' + endDate;
    }
  }

  xhttp.open('GET', url, true);
  xhttp.send();
}

// Get the start date of the selected month
function getMonthStartDate(month) {
  const startDate = new Date(new Date().getFullYear(), month - 1, 1); // Set the month
  return formatDate(startDate);
}

// Get the end date of the selected month
function getMonthEndDate(month) {
  const endDate = new Date(new Date().getFullYear(), month, 0); // Set the month and day to 0 to get the last day of the previous month
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

  // Toggle the visibility of the search tab
  function toggleSearchTab() {
    const searchTab = document.getElementById('searchTab');
    if (searchTab.style.display === 'none') {
      searchTab.style.display = 'block';
      populateMonthDropdown();
    } else {
      searchTab.style.display = 'none';
    }
  }

  // Perform the search based on the selected month and week
function search() {
  const monthDropdown = document.getElementById('monthDropdown');
  const selectedMonth = monthDropdown.value;
  const weekDropdown = document.getElementById('weekDropdown');
  const selectedWeek = weekDropdown.value;

  if (selectedWeek === '') {
    // If the selected week is blank, filter the data for the entire selected month
    const monthNumber = convertMonthToNumber(selectedMonth);
    filterData('custom', monthNumber, '');
  } else {
    // Convert the selected month name to month number
    const monthNumber = convertMonthToNumber(selectedMonth);

    // Filter the data based on the selected month and week number
    filterData('custom', monthNumber, selectedWeek);
  }

  // Hide the search tab after performing the search
  toggleSearchTab();
}

  // Helper function to convert month name to month number
  function convertMonthToNumber(monthName) {
    const monthIndex = monthNames.findIndex(month => month === monthName);
    return monthIndex + 1; // Add 1 to the index to get the month number
  }

  // Populate the month dropdown with current and future months
  function populateMonthDropdown() {
    const monthDropdown = document.getElementById('monthDropdown');
    const currentDate = new Date();
    const currentMonth = currentDate.getMonth(); // Get the current month index (0-11)

    for (let i = currentMonth; i < 12; i++) {
      const option = document.createElement('option');
      option.text = monthNames[i];
      option.value = monthNames[i];
      monthDropdown.add(option);
    }

    // Update the week dropdown based on the selected month
    populateWeekDropdown();
  }

  // Populate the week dropdown based on the selected month
  function populateWeekDropdown() {
    const monthDropdown = document.getElementById('monthDropdown');
    const weekDropdown = document.getElementById('weekDropdown');
    const selectedMonth = monthDropdown.value;
    const selectedMonthNumber = convertMonthToNumber(selectedMonth);

    const currentDate = new Date();
    const currentMonth = currentDate.getMonth() + 1;
    const currentYear = currentDate.getFullYear();

    let weekOptions = '';
    let weekNumber = 1;
    let startDate = getWeekStartDate(selectedMonthNumber, weekNumber);

    while (startDate.getMonth() + 1 === selectedMonthNumber) {
      const endDate = getWeekEndDate(selectedMonthNumber, weekNumber);
      const weekLabel = `${startDate.getDate()} - ${endDate.getDate()} ${selectedMonth}`;
      weekOptions += `<option value="${weekNumber}">${weekLabel}</option>`;
      weekNumber++;
      startDate = getWeekStartDate(selectedMonthNumber, weekNumber);
    }

    weekDropdown.innerHTML = weekOptions;
  }

  // Add this code to set the default selected value of the month dropdown
  const monthDropdown = document.getElementById('monthDropdown');
  const currentMonth = new Date().toLocaleString('en-US', { month: 'long' });
  monthDropdown.value = currentMonth;
</script>


<script type="text/javascript">
     // Convert table data to CSV format
  function convertToCSV() {
    const table = document.querySelector('.weekTable table');
    const headers = Array.from(table.querySelectorAll('th')).map(header => header.textContent);
    const rows = Array.from(table.querySelectorAll('tbody tr')).map(row =>
      Array.from(row.querySelectorAll('td')).map(cell => cell.textContent)
    );
    const csvContent = [
      headers.join(','),
      ...rows.map(row => row.join(','))
    ].join('\n');
    return csvContent;
    weekDropdown.innerHTML = weekOptions;
  }

  // Initiate the download with the generated CSV data
  function downloadTable() {
    const csvContent = convertToCSV();
    const encodedUri = encodeURI('data:text/csv;charset=utf-8,' + csvContent);
    const link = document.createElement('a');
    link.setAttribute('href', encodedUri);
    link.setAttribute('download', 'table_data.csv');
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  } 


</script>


</body>
</html>
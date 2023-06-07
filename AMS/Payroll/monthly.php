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
      <div class="custom-dropdown">
        <button class="custom-dropbtn">Monthly</button>
        <div class="custom-dropdown-content">
          <a href="view_reports.php?id=<?php echo $user_id; ?>">Weekly</a>
        </div>
      </div>
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
    <label for="date">Year</label>
    <input type="text" id="year" name="year" size="2">
    <br>
    <button name="btn_search" type="submit">Search</button>
  </form>
</div>

<div class="report_type">
  <a>Monthly Summary Report</a>
</div>

<div class="weekTable">
  <table>
    <thead>
      <tr>
        <th>Month</th>
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
  // Function to calculate the absence count for each month
  function calculateMonths(year) {
    var tableBody = document.getElementById("tableBody");

    tableBody.innerHTML = ""; // Clear previous table rows

    var promises = []; // Array to store the AJAX promises

    for (var monthCounter = 0; monthCounter < 12; monthCounter++) {
      (function() {
        var user_id = <?php echo isset($_GET['id']) ? $_GET['id'] : 'null'; ?>;
        var monthRow = document.createElement("tr");
        var monthCell = document.createElement("td");
        var absencesCell = document.createElement("td");

        var monthName = new Date(year, monthCounter, 1).toLocaleString("default", {
          month: "long"
        });

        monthCell.textContent = monthName;

        // Make an AJAX request to count the absences for the current month
        var xhr = new XMLHttpRequest();
        var startDate = year + "-" + (monthCounter + 1) + "-01";
        var endDate = year + "-" + (monthCounter + 1) + "-31";

        var requestData = {
          startDate: startDate,
          endDate: endDate,
          user_id: user_id
        };

        xhr.open("POST", "check_absences.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");

        var promise = new Promise(function(resolve, reject) {
          xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
              if (xhr.status === 200) {
                var absencesCount = parseInt(xhr.responseText);
                absencesCell.textContent = absencesCount;
                resolve(absencesCount); // Resolve the promise with the absence count
              } else {
                reject("Error");
              }
            }
          };
        });

        xhr.send(JSON.stringify(requestData));

        monthRow.appendChild(monthCell);
        monthRow.appendChild(absencesCell);
        tableBody.appendChild(monthRow);

        promises.push(promise); // Add the promise to the array
      })();
    }

    // Return a promise that resolves when all AJAX requests are complete
    return Promise.all(promises);
  }

  // Function to calculate the total absence count for the selected year
  function calculateTotalAbsences(year) {
    var user_id = <?php echo isset($_GET['id']) ? $_GET['id'] : 'null'; ?>;
    var totalAbsences = 0;

    calculateMonths(year)
      .then(function(absenceCounts) {
        // Calculate the total absence count
        totalAbsences = absenceCounts.reduce(function(sum, count) {
          return sum + count;
        }, 0);

        // Display the total absence count
        var totalAbsencesElement = document.getElementById("totalAbsences");
        totalAbsencesElement.textContent = totalAbsences;
      })
      .catch(function(error) {
        console.log("Error calculating total absences:", error);
      });
  }

  // Event listener for form submission
  document.getElementById("searchForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission

    var yearInput = document.getElementById("year");
    var selectedYear = yearInput.value;

    calculateTotalAbsences(selectedYear); // Calculate the total absence count
  });

  // Get the current year and calculate the total absence count
  var currentYear = new Date().getFullYear();
  calculateTotalAbsences(currentYear);

function downloadTableAsCSV() {
  var userFullName = "<?php echo isset($fullname) ? $fullname : 'Unknown User'; ?>";
  var currentYear = new Date().getFullYear();
  var fileName = userFullName + "_" + currentYear + ".csv";

  var csvContent = "data:text/csv;charset=utf-8,";

  var rows = document.querySelectorAll("#tableBody tr");

  // Generate CSV content
  rows.forEach(function(row) {
    var rowData = [];
    var columns = row.querySelectorAll("td");

    columns.forEach(function(column) {
      rowData.push('"' + column.textContent + '"');
    });

    csvContent += rowData.join(",") + "\r\n";
  });

  var encodedUri = encodeURI(csvContent);
  var link = document.createElement("a");
  link.setAttribute("href", encodedUri);
  link.setAttribute("download", fileName);
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

  // Event listener for download button click
  var downloadButton = document.querySelector(".download-button");
  downloadButton.addEventListener("click", function(event) {
    event.preventDefault(); // Prevent default link behavior
    downloadTableAsCSV();
  });
</script>

<a href="#" class="download-button" onclick="downloadTableAsCSV()">Download</a>




</body>
</html>
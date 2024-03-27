<?php
require_once 'connection.php';



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
    // Retrieve the user details from the user table, including the "user_img" column
  $query_user = "SELECT *, IFNULL(user_img, '') AS user_img FROM user WHERE user_id = $user_id";

    // retrieve the schedule details from the schedule table
    $query_schedule = "SELECT * FROM schedule WHERE user_id = $user_id";
    $result_schedule = mysqli_query($conn, $query_schedule);

    if (mysqli_num_rows($result_schedule) > 0) {
        $row_schedule = mysqli_fetch_assoc($result_schedule);
        $academic_year = $row_schedule['academic_year'];
        
        // add more schedule details here as needed
    } else {
    }
} else {
    // handle missing user_id parameter error here
}


if (!empty($error_messages)) {
  $error_message = implode("<br>", $error_messages);
  echo $error_message; // Add this line
}
?>

<?php
// Check if the message variable is set and not empty
if (isset($message)) {
?>
<script>
  // Display an alert box with the message
  alert("<?php echo $message; ?>");
</script>
<?php
}
?>

<?php if (isset($_GET['show_alert']) && $_GET['show_alert'] == 1): ?>
  <script>
    alert("<?php echo $_GET['error_message']; ?>");
  </script>
<?php endif; ?>


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
    <title>Attendance Monitoring System</title>

</head>

<body>
    <nav>
        <div class="d-flex justify-content-centerlogo">
            <img class="logo" src="https://signin.apc.edu.ph/images/logo.png" width="60px"/>
        </div>
        <label class="logo">Attendance Monitoring System</label>
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
                <li><a href="dashboard_FE.php">School of Engineering</a></li>
            </ul>
        
        </div>
        <div class="main_content">
            <div class="info">
                <div>lorem lorem</div>
            </div>
        </div>
    </div>

</head>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="FEStyle2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<div class="wrapper2">
<form method="post" action="save_schedule.php?id=<?php echo $user_id; ?>" enctype="multipart/form-data">
  <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
  <div class="main_content">
    <div class="info">
      <div class="profile-container">
        <label for="profile-image" style="cursor: pointer;">
          <?php if (!empty($row_user['user_img'])) { ?>
            <img id="user-profile-image" src="data:image/jpeg;base64,<?php echo base64_encode($row_user['user_img']); ?>" alt="User Profile Picture">
          <?php } else { ?>
            <img id="user-profile-image" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="User Profile Picture">
          <?php } ?>
        </label>
        <input type="file" id="profile-image" name="profile_image" style="display: none;">
        <div class="details">
          <p><span class="not-bold">Faculty Name:</span> <span><?php echo $fullname; ?></span></p>
          <p><span class="not-bold">Academic Year:</span><input type="text" name="academic_year" value="<?php echo htmlspecialchars($academic_year); ?>"></p>
          <p><span class="not-bold">School Department:</span> <span><?php echo $school_department; ?></span></p>
        </div>
      </div>
    </div>
  </div>

        
<div class="container-tb">
  <form method="post" action="save_schedule.php?id=<?php echo $user_id; ?>">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
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
          <th></th>
        </tr>
      </thead>
      <tbody id="table-body">
        <?php
          // Include database connection file

          // Retrieve data from database
          $sql = "SELECT * FROM schedule WHERE user_id = '".$user_id."'";
          $result = mysqli_query($conn, $sql);

          // Display data in table
          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td class='table__cell'><input type='text' name='subject_code[]' value='" . $row["subject_code"] . "'></td>";
              echo "<td class='table__cell'><input type='text' name='subject_units[]' value='" . $row["subject_units"] . "'></td>";
              echo "<td class='table__cell'><input type='text' name='schedule_day[]' value='" . $row["schedule_day"] . "'></td>";
              echo "<td class='table__cell'><input type='text' name='section[]' value='" . $row["section"] . "'></td>";
              echo "<td class='table__cell'><input type='text' name='schedule_time_start[]' value='" . $row["schedule_time_start"] . "'></td>";
              echo "<td class='table__cell'><input type='text' name='schedule_time_end[]' value='" . $row["schedule_time_end"] . "'></td>";
              echo "<td class='table__cell'><input type='text' name='room[]' value='" . $row["room"] . "'></td>";
              echo "<input type='hidden' name='schedule_id[]' value='" . $row["schedule_id"] . "' />";
              echo "<td class='table__cell'><button class='table__button' onclick='deleteRow(this, " . $row['schedule_id'] . ")'><i class='fa fa-trash fa-2x' style='color: red;'></i></button></td>";
            }
          } else {
            echo "<tr><td class='table__cell' colspan='8'>No schedule found.</td></tr>";
          }
          // Close database connection
          mysqli_close($conn);
        ?>
      </tbody>
    </table>

    <button type="button" onclick="addRow()">Add Row</button>
    <button type="submit">Save</button>

<button type="button" onclick="exportSchedule()">Export</button>
  </form>
<input type="file" id="file-input" style="display: none;" onchange="importSchedule(event)">
<button type="button" onclick="document.getElementById('file-input').click(); importSchedule();">Import</button>
</div>

<script>
function deleteRow(button, schedule_id) {
  if (confirm("Are you sure you want to delete this row?")) {
    var user_id = <?php echo $user_id; ?>;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var response = this.responseText;
        if (response == 'success') {
          button.closest('tr').remove();
          window.location.reload();
        } else {
          alert('Error deleting row'); 
        }
      }
    };
    xhr.open("POST", "delete_row.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("user_id=" + user_id + "&schedule_id=" + schedule_id);
  }
}

function addRow() {
  var table = document.querySelector(".table");
  var tbody = table.querySelector("tbody");
  var row = document.createElement("tr");
  var cell1 = document.createElement("td");
  var cell2 = document.createElement("td");
  var cell3 = document.createElement("td");
  var cell4 = document.createElement("td");
  var cell5 = document.createElement("td");
  var cell6 = document.createElement("td");
  var cell7 = document.createElement("td");
  var cell8 = document.createElement("td");
  var cell9 = document.createElement("td");

  cell1.innerHTML = "<input type='text' name='subject_code[]'>";
  cell2.innerHTML = "<input type='text' name='subject_units[]'>";
  cell3.innerHTML = "<input type='text' name='schedule_day[]'>";
  cell4.innerHTML = "<input type='text' name='section[]'>";
  cell5.innerHTML = "<input type='text' name='schedule_time_start[]'>";
  cell6.innerHTML = "<input type='text' name='schedule_time_end[]'>";
  cell7.innerHTML = "<input type='text' name='room[]'>"; 
  cell8.innerHTML = "<button class='table__button' onclick='deleteRow(this)'><i class='fa fa-trash fa-2x' style='color: red;'></i></button>";
  cell9.innerHTML = "<input type='hidden' name='schedule_id[]' value='' />"

  row.appendChild(cell1);
  row.appendChild(cell2);
  row.appendChild(cell3);
  row.appendChild(cell4);
  row.appendChild(cell5);
  row.appendChild(cell6);
  row.appendChild(cell7);
  row.appendChild(cell8);
  row.appendChild(cell9);

  tbody.appendChild(row);
}
</script>









<script type="text/javascript">

function getUserIdFromUrl() {
  var url = window.location.href;
  var index = url.indexOf('?id=');
  if (index === -1) {
    return null; // If 'id' parameter is not found in the URL
  }
  var user_id = url.slice(index + 4);
  return user_id;
}

function importSchedule(event) {
    const fileInput = event.target;
    const file = fileInput.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const csvData = e.target.result;
            sendDataToServer(csvData);
        };
        reader.readAsText(file);
    }
}

function sendDataToServer(csvData) {
    const user_id = getUserIdFromURL();

    // Split the CSV data into rows and process each row
    const rows = csvData.split('\n');
    for (let i = 1; i < rows.length; i++) {
        const row = rows[i].split(',');

        // Properly format the time values (HH:MM:SS), removing extra quotes
        const start_time = formatTime(row[4].replace(/"/g, '').trim());
        const end_time = formatTime(row[5].replace(/"/g, '').trim());

        const formData = new FormData();
        formData.append('user_id', user_id);
        formData.append('subject_code', row[0].replace(/"/g, '').trim());
        formData.append('subject_units', row[1].replace(/"/g, '').trim());
        formData.append('schedule_day', row[2].replace(/"/g, '').trim());
        formData.append('section', row[3].replace(/"/g, '').trim());
        formData.append('schedule_time_start', start_time);
        formData.append('schedule_time_end', end_time);
        formData.append('room', row[6].replace(/"/g, '').trim());

        // Log the actual row values before sending to the server
        const logString = `"${row[0].replace(/"/g, '').trim()}","${row[1].replace(/"/g, '').trim()}","${row[2].replace(/"/g, '').trim()}","${row[3].replace(/"/g, '').trim()}","${start_time}","${end_time}","${row[6].replace(/"/g, '').trim()}"`;
        console.log('Actual Row Values:', logString);

        // Send an AJAX request to your server for each row of data
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_schedule_import.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log('Data successfully sent to the server');
                console.log('Server response:', xhr.responseText);

                // Reload the page with the same HTTP parameters
                const url = `edit_sched_function.php?id=${user_id}`;
                window.location.href = url;
            } else {
                console.error('Error:', xhr.statusText);
            }
        };
        xhr.send(formData);
    }
}

function formatTime(time) {
    const parts = time.split(':');
    const formattedTime = `${parts[0].padStart(2, '0')}:${parts[1].padStart(2, '0')}:00`;
    return formattedTime;
}

function getUserIdFromURL() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('id');
}



function exportSchedule() {
  // Get the table element
  var table = document.getElementById("table-body");

  // Create a CSV string to hold the table data
  var csvString = "";

  // Get column names
  var columnNames = [];
  var headerRow = table.previousElementSibling.getElementsByTagName("th");
  for (var i = 1; i < headerRow.length; i++) {
    var columnName = headerRow[i].textContent;
    columnNames.push(columnName);
  }

  // Add column names to the CSV string
  csvString += '"' + columnNames.join('","') + '"\n';

  // Iterate over table rows
  for (var i = 0; i < table.rows.length; i++) {
    var row = table.rows[i];

    // Skip rows that have been marked for deletion
    if (!row.classList.contains("deleted-row")) {
      // Iterate over row cells
      for (var j = 1; j < row.cells.length; j++) {
        var cell = row.cells[j];
        var cellValue = cell.querySelector("input").value;

        // Escape double quotes in cell values
        cellValue = cellValue.replace(/"/g, '""');

        // Enclose cell value in double quotes
        csvString += '"' + cellValue + '",';
      }

      // Remove trailing comma and add line break after each row
      csvString = csvString.slice(0, -1) + "\n";
    }
  }

  // Create a dummy anchor element to download the CSV file
  var downloadLink = document.createElement("a");
  downloadLink.href = "data:text/csv;charset=utf-8," + encodeURIComponent(csvString);
  downloadLink.download = "schedule.csv";

  // Trigger the download
  downloadLink.click();
}
</script>




<script>
document.getElementById("profile-image").addEventListener("change", function() {
  const selectedFile = this.files[0];
  if (selectedFile) {
    const userImage = document.getElementById("user-profile-image");
    userImage.src = URL.createObjectURL(selectedFile);
  }
});
</script>



</body>
</html>


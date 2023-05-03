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

    // retrieve the schedule details from the schedule table
    $query_schedule = "SELECT * FROM schedule WHERE user_id = $user_id";
    $result_schedule = mysqli_query($conn, $query_schedule);

    if (mysqli_num_rows($result_schedule) > 0) {
        $row_schedule = mysqli_fetch_assoc($result_schedule);
        $academic_year = $row_schedule['academic_year'];
        
        // add more schedule details here as needed
    } else {
        // handle schedule not found error here
    }
} else {
    // handle missing user_id parameter error here
}
?>

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
            <li><a href="#" class="yourname"><b><?php echo $_SESSION['user_fullname']; ?></b></a></li>
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
  <form method="post" action="save_schedule.php?id=<?php echo $user_id; ?>">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <div class="main_content">
            <div class="info">
                <div class="profile-container">
                    <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="User Profile Picture">
                    <div class="details">
                    <p><span class="not-bold">Faculty Name:</span> <span><?php echo $fullname; ?></span></p>
                    <p><span class="not-bold">Academic Year:</span><input type="text" name="academic_year" value="<?php echo $academic_year; ?>"></p>
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
          <th></th>
          <th>Subject Code</th>
          <th>Subject Units</th>
          <th>Schedule Day</th>
          <th>Section</th>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Room</th>
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
              echo "<td class='table__cell'><button class='table__button' onclick='deleteRow(this, " . $row['schedule_id'] . ")'><i class='fa fa-trash fa-2x' style='color: red;'></i></button></td>";
              echo "<td class='table__cell'><input type='text' name='subject_code[]' value='" . $row["subject_code"] . "'></td>";
              echo "<td class='table__cell'><input type='text' name='subject_units[]' value='" . $row["subject_units"] . "'></td>";
              echo "<td class='table__cell'><input type='text' name='schedule_day[]' value='" . $row["schedule_day"] . "'></td>";
              echo "<td class='table__cell'><input type='text' name='section[]' value='" . $row["section"] . "'></td>";
              echo "<td class='table__cell'><input type='text' name='schedule_time_start[]' value='" . $row["schedule_time_start"] . "'></td>";
              echo "<td class='table__cell'><input type='text' name='schedule_time_end[]' value='" . $row["schedule_time_end"] . "'></td>";
              echo "<td class='table__cell'><input type='text' name='room[]' value='" . $row["room"] . "'></td>";
              echo "<input type='hidden' name='schedule_id[]' value='" . $row["schedule_id"] . "' />";
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
  </form>
</div>
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

  cell1.innerHTML = "<button class='table__button' onclick='deleteRow(this)'><i class='fa fa-trash fa-2x' style='color: red;'></i></button>";
  cell2.innerHTML = "<input type='text' name='subject_code[]'>";
  cell3.innerHTML = "<input type='text' name='subject_units[]'>";
  cell4.innerHTML = "<input type='text' name='schedule_day[]'>";
  cell5.innerHTML = "<input type='text' name='section[]'>";
  cell6.innerHTML = "<input type='text' name='schedule_time_start[]'>";
  cell7.innerHTML = "<input type='text' name='schedule_time_end[]'>";
  cell8.innerHTML = "<input type='text' name='room[]'>";
  cell9.innerHTML = "<input type='hidden' name='schedule_id[]' value='' />";

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


</body>
</html>
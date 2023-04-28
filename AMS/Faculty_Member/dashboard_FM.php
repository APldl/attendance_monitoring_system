<?php

include "connection.php";

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="Style.css">
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
      <li><a href="#"> <b>

        <?php echo $_SESSION['user_fullname'];
        ?>

      </b> </a></li>
    </ul>
  
  </nav>

  <div class="wrapper">
    <div class="sidebar">
      <h2>Viewing</h2>
      <ul>
        <li><a href="#">View Attendance Records</a></li>
        <li><a href="#">View Requests</a></li>
      </ul>
      <h2>Make Request</h2>
      <ul>
        <li><a href="#">Make Up Class</a></li>
        <li><a href="#">Substitution</a></li>
      </ul>
    </div>
    <div class="main_content">
     
      <div class="info">
        <div>lorem lorem</div>
      </div>
    </div>
  </div>


  <title>Here is your class Schedule</title>
  <style>
    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 10px;
      font-family: Arial, sans-serif;
      margin-right: 70px; /* add margin to move the container to the right */
    }

    .table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 20px;
    }

    .table th,
    .table td {
      padding: 10px;
      text-align: left;
      border: 1px solid #ccc;
    }

    .table th {
      background-color: #f2f2f2;
      font-weight: bold;
    }

    .table tr:nth-child(even) {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Class Schedule</h1>
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
        </tr>
      </thead>
      <tbody>
        <?php
          // Include database connection file

          // Retrieve data from database
          $user_id = $_SESSION['user_id'];
          $sql = "SELECT * FROM schedule WHERE user_id = '".$user_id."'";
          $result = mysqli_query($conn, $sql);

          // Display data in table
          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td class='table__cell'>" . $row["subject_code"] . "</td>";
              echo "<td class='table__cell'>" . $row["subject_units"] . "</td>";
              echo "<td class='table__cell'>" . $row["schedule_day"] . "</td>";
              echo "<td class='table__cell'>" . $row["section"] . "</td>";
              echo "<td class='table__cell'>" . $row["schedule_time_start"] . "</td>";
              echo "<td class='table__cell'>" . $row["schedule_time_end"] . "</td>";
              echo "<td class='table__cell'>" . $row["room"] . "</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td class='table__cell' colspan='7'>No schedule found.</td></tr>";
          }

          // Close database connection
          mysqli_close($conn);
        ?>
      </tbody>
    </table>
  </div>

</body>
</html>
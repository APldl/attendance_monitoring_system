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
        $school_department = $row_schedule['school_department'];
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
    <style>
        /* Global styles */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            margin: 50px auto;
            max-width: 700px;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        /* Profile picture */
        .profile-container {
            display: flex;
            align-items: center;
        }

        .profile-container img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
        }

        /* User info */
        .details {
            margin-left: 20px;
            flex: 1;
        }

        .details p {
            font-weight: normal;
            margin-bottom: 5px;
        }

        .details span {
            margin-bottom: 10px;
        }

        .wrapper2 {
            display: block;
            margin: 20px auto;
            max-width: 800px;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin-left: 300px; /* add this line */
        }

        .details span.not-bold {
            font-weight: bold;
        }
        .container-tb {
      max-width: 820px;
      margin: 0 auto;
      padding: 10px;
      font-family: Arial, sans-serif;
      margin-left: 290px; /* add margin to move the container to the right */
    }

    .table {
      border-collapse: collapse;
      width: 100%;
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


    .container-tb {
    position: relative;
    }

    .edit-icon {
    position: relative;
    bottom: 0;
    margin-left: 1030px;
    padding: 10px;
    }

    .edit-icon img {
    height: 20px;
    width: 20px;
    margin-right: 5px;
    vertical-align: middle;
    }

    </style>
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
            $school_department = $row_schedule['school_department'];
            // add more schedule details here as needed
        } else {
            // handle schedule not found error here
        }
    } else {
        // handle missing user_id parameter error here
    }
?>

</head>
<body>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="FEStyle.css">
</head>
<body>

    <div class="wrapper2">

        <div class="main_content">
            <div class="info">
                <div class="profile-container">
                    <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="User Profile Picture">
                    <div class="details">
                    <p><span class="not-bold">Academic Year:</span> <span><?php echo $academic_year; ?></span></p>
                    <p><span class="not-bold">Faculty Name:</span> <span><?php echo $fullname; ?></span></p>
                    <p><span class="not-bold">School Department:</span> <span><?php echo $school_department; ?></span></p>
                    </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</body>

<div class="container-tb">
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

  <div class="edit-icon">
    <a href="#" title="Edit">
      <img src="https://www.clipartmax.com/png/small/121-1212430_white-edit-11-icon-edit-icon-bootstrap-png.png" alt="White Edit 11 Icon - Edit Icon Bootstrap Png @clipartmax.com" alt="Edit Icon">
      Edit
    </a>
  </div>

</body>
</html>
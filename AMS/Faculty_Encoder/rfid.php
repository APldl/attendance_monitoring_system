<?php
 
  require 'connection.php';

// Retrieve data from the form
$user_fullname= $_POST['user_fullname'];
$user_email = $_POST['user_email'];
$user_password = $_POST['user_password']; //MD5 encryption
$confirm_password = $_POST['confirm_password']; //MD5 encryption
$role_id = $_POST['role_id'];
$employee_no = $_POST['employee_no'];
$school_department = $_POST['school_department'];
$user_id = $_POST['user_id'];
$tag_id = $_POST['tag_id'];

    // Insert data into the 'user' table
    $sqlUser = "INSERT INTO user (user_fullname, user_email, user_password, role_id, employee_no, school_department)
                VALUES ('$user_fullname', '$user_email', '$user_password', '$role_id', '$employee_no', '$school_department')";

    if ($conn->query($sqlUser) === TRUE) {
        // Insert data into the 'rfid_data' table
        $sqlRFID = "INSERT INTO rfid_data (user_id, tag_id)
                    VALUES ('$user_id', '$tag_id')";

        if ($conn->query($sqlRFID) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error inserting RFID data: " . $conn->error;
        }
    } else {
        echo "Error inserting user data: " . $conn->error;
    }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Faculty Attendance Card Registration</title>
    <link rel="stylesheet" type="text/css" href="FEStyle2.css">
  </head>
  <body>
    <div class="form-container">
      <h2>Faculty Attendance Card Registration</h2>
      <form action="register_function.php" method="post">
        <!-- Display user's full name -->
        <label for="fullname">Full Name:</label>
        <?php
        // Echo the Full Name here
        echo '<h2>' . $user_fullname . '</h2>';
        ?>
        
        <!-- Display user's employee number -->
        <label for="employeeNum">Employee Number:</label>
        <?php
        // Echo the Employee Number here
        echo '<h2>' . $employee_no  . '</h2>';
        ?>
        
        <!-- Display user's role -->
        <label for="user_role">User Role:</label>
        <h2>Faculty</h2>
        
       
  <label for="user-number">Input User Number:</label>
<input type="text" id="user_id" name="user_id" required>

<label for="user-tag">User Identification Tag:</label>
<input type="text" id="tag_id" name="tag_id" required>

           <input type="text" id="tag_id" name="tag_id" required>
        
        <div class="submit">
          <!-- Add an id attribute to the submit button -->
          <input type="submit" value="Register Card" id="registerButton">
        </div>
      </form>
    </div>


  </body>
</html>
<?php
    require 'connection.php';


if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // retrieve the user details from the user table
    $query_user = "SELECT * FROM user WHERE user_id = $user_id";
    $result_user = mysqli_query($conn, $query_user);

    if (mysqli_num_rows($result_user) > 0) {
        $row_user = mysqli_fetch_assoc($result_user);
        $fullname = $row_user['user_fullname'];
        $role_id = $row_user['role_id'];
        // add more user details here as needed
    } else {
        // handle user not found error here
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
    <link rel="stylesheet" href="AdminStyle.css">
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
  
            <h2>Filter users</h2>
            <ul>
            <li><a href="dashboard_Admin2.php">Attendance Checker</a></li>
            </ul>
                        <ul>
            <li><a href="dashboard_Admin3.php">Faculty Encoder</a></li>
            </ul>
                        <ul>
            <li><a href="dashboard_Admin4.php">Faculty Head</a></li>
            </ul>
                        <ul>
            <li><a href="dashboard_Admin5.php">Payroll</a></li>
            </ul>
            <h2>Schools</h2>
            <ul>
                <li><a href="dashboard_AdminE.php">School of Engineering</a></li>
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
            <form method="POST">
                <div class="profile-container">
                    <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="User Profile Picture">
<div class="details">
    <form method="POST">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <p><span class="not-bold">Name:</span> <span><?php echo $fullname; ?></span></p>
        <p><span class="not-bold">Role: </span><span>
            <select name="role">
                <option value="1" <?php if ($role_id == 1) echo 'selected'; ?>>Faculty Member</option>
                <option value="2" <?php if ($role_id == 2) echo 'selected'; ?>>Attendance Checker</option>
                <option value="3" <?php if ($role_id == 3) echo 'selected'; ?>>Faculty Encoder</option>
                <option value="4" <?php if ($role_id == 4) echo 'selected'; ?>>Faculty Head</option>
                <option value="5" <?php if ($role_id == 5) echo 'selected'; ?>>Payroll</option>
            </select>
        </span></p>
        <button name="btn_save" type="submit">Save</button>
    </form>
</div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($_POST['btn_save'])) {
    $selected_role_id = $_POST['role'];
    $user_id = $_POST['user_id'];

    // Perform necessary database update
    // Assuming you have an established database connection, replace 'user' with your table name, 'user_id' with the column name for user id, and 'role_id' with the column name for role id

    // Prepare and execute the update query
    $query = "UPDATE `user` SET `role_id` = ? WHERE `user_id` = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $selected_role_id, $user_id);
    mysqli_stmt_execute($stmt);

$redirect_url = 'edit_user.php';
$message = urlencode('User has been saved');
$id = $_GET['id'];
$redirect_url_with_params = $redirect_url . '?message=' . $message . '&id=' . $id;
header("Location: $redirect_url_with_params");
exit();
}
?>


            </div>
        </div>



</body>
</html>


<?php
if (isset($_GET['message'])) {
    $message = $_GET['message'];
    echo "<script>alert('$message');</script>";
}
?>
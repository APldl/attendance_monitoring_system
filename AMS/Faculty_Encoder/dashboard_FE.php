<?php
    session_start();
    require 'connection.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="FEStyle.css">
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
                <li ><a href="#" class = "yourname"> <b>

        <?php echo $_SESSION['user_fullname'];
        ?>

      </b></a></li>
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

    <ul class="user-list">
        <?php

        $queryRole = "SELECT * FROM user WHERE role_id = 1";
        $list = mysqli_query($conn, $queryRole);

        while ($row = mysqli_fetch_assoc($list)) {
            $fullname = $row['user_fullname'];
            $user_id = $row['user_id'];
            //$profile_picture = $row['profile_picture'];
        ?>
<a href="edit_sched.php?id=<?php echo $user_id; ?>">
  <li class="user-item">
    <img class="user-icon" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="User Icon">
    <div class="user-name"><?php echo $fullname; ?></div>
  </li>
</a>
        <?php } ?>
    </ul>

</body>
</html>
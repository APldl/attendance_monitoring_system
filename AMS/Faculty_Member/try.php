<?php
session_start();

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

</body>
</html>
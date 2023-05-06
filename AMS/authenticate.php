<?php
  session_start();
  
  //1. Setup database connection
  require 'connection.php';

  $user_email = $_POST['user_email'];
  $user_password = $_POST['user_password']; //MD5 encrytion

  $_SESSION['user_email'] = $email;

  //2. SELECT SQL
  $sql = "SELECT * FROM `user` WHERE `user_email`='".$user_email."'AND `user_password` = '".$user_password."' ";

  //3. Execute SQL
  $result = mysqli_query($conn, $sql);
  $count = mysqli_num_rows($result);
  
  if ($count > 0) {
    //user found
    $row = mysqli_fetch_array($result);

    //$_SESSION['isLogin'] = true;

    $_SESSION['user_fullname'] = $row['user_fullname'];
    $_SESSION['user_id'] = $row['user_id'];

    $_SESSION['user_role'] = $row['role_id'];

         if($_SESSION['user_role'] == 1){
       //header('Location: dashboard_faculty.php');
       header('Location: Faculty_Member/dashboard_FM.php');
     }else if($_SESSION['user_role'] == 2){
       header('Location: Attendance_Checker/dashboard_AC.php');
     }else if($_SESSION['user_role'] == 3){
       header('Location: Faculty_Encoder/dashboard_FE.php');
     }else if($_SESSION['user_role'] == 4){
       header('Location: Faculty_Head/dashboard_FH.php');
     }else if($_SESSION['user_role'] == 5){
       header('Location: Payroll/dashboard_PR.php');
       //wla pa folder
     }else if($_SESSION['user_role'] == 6){
       header('Location: Admin/dashboard_AdminE.php');
       //wla pa folder
     } 
  }else {
     header('Location: loginwrong.php');
     }


?>
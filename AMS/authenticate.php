<?php
  session_start();

  $user_email = $_POST['user_email'];
  $user_password = $_POST['user_password']; //MD5 encrytion

  echo($user_email);
  echo($user_password);

  //1. Setup database connection
  require 'connection.php';

  //2. SELECT SQL
  $sql = "SELECT * FROM `user` WHERE `user_email`='".$user_email."'AND `user_password` = '".$user_password."' ";

  echo($sql);

  //3. Execute SQL
  $result = mysqli_query($conn, $sql);
  $count = mysqli_num_rows($result);
  
  if ($count > 0) {
    //user found
    $row = mysqli_fetch_array($result);

    //$_SESSION['isLogin'] = true;

    $_SESSION['user_fullname'] = $row['user_fullname'];
    $_SESSION['user_id'] = $row['user_id'];

    $_SESSION['user_role'] = $row['user_id'];



    header('Location: dashboard_faculty.php');
  }else {
    //invalid credentials
    //$_SESSION['isLogin'] = false;

    header('Location: loginwrong.php');


  }

  //.4 Closing Database Connection
  //mysqli_close($conn);

?>
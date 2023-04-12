<?php
  session_start();

  //INSERTING USER DATA INTO DATABASE
  $user_fullname= $_POST['user_fullname'];
  $user_email = $_POST['user_email'];
  $user_password = $_POST['user_password']; //MD5 encryption
  $confirm_password = $_POST['confirm_password']; //MD5 encryption
  $role_id = $_POST['role_id'];



  //Make first name and last name first letter capitalized
  //$first_name = ucfirst($first_name);
  //$last_name = ucfirst($last_name);

  if($confirm_password != $user_password){
    //Passwords do not match
    //header('Location: ../register.php?matchPass=false');
    header('Location: register_incorrect_pass.php');
  }

  else {
    //Passwords match - continue with script
    //1. Setup database connection
    require 'connection.php';

    //2. Insert SQL
    $sql = "INSERT INTO `user`(
            `user_email`,  
            `user_password`,
            `user_fullname`,
            `role_id`
          ) VALUES (
            '".$user_email."',
            '".$user_password."',
            '".$user_fullname."',
            '".$role_id."'
          )";

    mysqli_query($conn, $sql);

    $exist = "
        SELECT 
          * 
        FROM 
          `user` 
        WHERE 
          `user_email`='".$user_email."'
      ";

    //3. Execute SQL

    $result = mysqli_query($conn, $exist);
    $count = mysqli_num_rows($result);

    if ($count > 0) {
      //existing email

      //header('Location: ../register.php?origemail=false');
      header('Location: register_incorrect_email.php');
    } 
    else {
      //original email
      //header('Location: ../register.php?origemail=false');
      header('Location: login.php');
    }

    //Closing Database Connection
    //mysqli_close($conn);

  }

  
?>
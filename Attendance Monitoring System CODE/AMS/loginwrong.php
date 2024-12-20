<?php
  session_start();


  include "connection.php";

?>


<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <style>
      /* Center the form container */
      label {
        font-family:sans-serif;
      }
      .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
      }
      .apclogo {
      	display: flex;
        justify-content: center;
        align-items: center;
      }

      /* Style the form */
      form {
        background-color: #f2f2f2;
        border-radius: 5px;
        padding: 20px;
        width: 300px;
      }

      /* Style the form fields */
      input[type=text], input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
      }

      /* Style the submit button */
      input[type=submit] {
        background-color: #083c74;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;

      }
      html{
      	background-color: #083c74;
      }


      /* Float cancel and submit buttons to the right */
      .submit {
        display: flex;
        justify-content: center;
        align-items: center;
      }

      h2 {
        font-family:sans-serif;
      	font-size: 20px;
      	display: flex;
      	justify-content: center;

      }
      .invalid-credentials {
      margin: 0 auto;
      width: 75%;
      margin-bottom: 1rem;
      }
      .alert-danger {
      color: #842029;
      background-color: #f8d7da;
      border-color: #f5c2c7;
      }
      .alert {
      position: relative;
      padding: 1rem 1rem;
      margin-bottom: 1rem;
      border: 1px solid transparent;
      border-radius: 0.25rem;
      }

      /* Add media queries for responsiveness */
      @media screen and (max-width: 600px) {
        form {
          width: 80%;
        }
      }
    </style>
  </head>
  <body>
    <div class="container">
      <form action="authenticate.php" method="post">
      	<div class="apclogo">
      	<img src="https://signin.apc.edu.ph/images/logo.png" width="120px">
      	</div>
        <div class="alert alert-danger invalid-credentials" align="center" role="alert">
                    Invalid Email or Password.
        </div>
        <h2>Attendance Monitoring System</h2>
        <label for="username"><b>Username</b></label>
        <input type="text" placeholder="Enter email" name="user_email" required>

        <label for="password"><b>Password</b></label>
        <input type="password" placeholder="Enter password" name="user_password" required>

        <div class="submit">
          <input type="submit" value="Login">
        </div>
      </form>
    </div>
  </body>
</html>
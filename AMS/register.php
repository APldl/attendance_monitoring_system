<!DOCTYPE html>
<html>
  <head>
    <title>Registration Form</title>
    <style>
      /* Style the form container */
      .form-container {
        margin: auto;
        width: 40%;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        background-color: #f2f2f2;
      }
      
      /* Style the input fields */
      input[type=text], input[type=email], input[type=password], select {
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
        border-radius: 2px;
        cursor: pointer;
      }
      
      /* Style the submit button on hover */
      input[type=submit]:hover {
        background-color: #083c74;
      }
      
      html{
        background-color: #083c74;
      }

      .submit {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
      }

    </style>
  </head>
  <body>
    <div class="form-container">
      <h2>Registration Form</h2>
      <form action="#" method="post">
        <label for="fullname">Full Name</label>
        <input type="text" id="fullname" name="fullname" required>
        
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        
        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password" name="confirm-password" required>
        
        <label for="user-role">User Role</label>
        <select id="user-role" name="user-role">
          <option value="1">Faculty</option>
          <option value="2">Attendance Checker</option>
          <option value="3">Faculty Encoder</option>
          <option value="4">Academic Head</option>
          <option value="5">Admin</option>
        </select>
        
        <div class="submit">
          <input type="submit" value="Login">
        </div>

      </form>
    </div>
  </body>
</html>
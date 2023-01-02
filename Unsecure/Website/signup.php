<?php

include 'Templates/config.php';

if(isset($_POST['submit'])){
  // These two functions are important for extra security purpose in the signup form:
  // The FILTER_SANITIZE_STRING filter removes tags and remove or encode special characters from a string.
  // mysqli_real_escape_string() function escapes special characters in a string and prevents against sql attacks
  // passwords md5 hashing for an extra layer of security for the users

  // fetch the username, email, password & confirm password of the user
   $name = $_POST['name'];
   $email = $_POST['email'];
   $pass = $_POST['password'];
   $cpass = $_POST['confirmPassword'];
   $dob =  $_POST['DOB'];

 // _____________________________________________________________________________

    // select all users that have the same email that the user just entered from the users table in the database, if possible
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    // if the rows returned are more than 0, that means that this email was used already
    if(mysqli_num_rows($select_users) > 0){
          $message[] = 'User already exists!'; // store notification message
       }else{
         // if the 2 paaswords entered do not match
          if($pass != $cpass){
             $message[] = 'Passwords do not match!'; // store notification message
 // _____________________________________________________________________________
          }else{
            // if all input was valid, insert these values into the users table in the databsae
             mysqli_query($conn, "INSERT INTO `users`(name, email, password, birthdate) VALUES('$name', '$email', '$pass', '$dob')") or die('query failed');
             $message[] = 'Registered successfully!'; // store notification message
             // redirect user to the login page
             header('location:login.php');
          }
       }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="CSS/sign-up.css">
  <title>Sign Up</title>
</head>
<body>

  <?php include 'Templates/notification.php' ?>

  <div class="login-wrapper">
    <form action="signup.php" method='post' class="form">
      <img src="images/avatar.png" alt="">
      <h2>Sign-Up</h2>
      <div class="input-group">
        <input type="text" name="name" id="loginUser" required>
        <label for="loginUser">Name</label>
      </div>
      <div class="input-group">
        <input type="email" name="email" id="loginEmail" required>
        <label for="loginEmail">Email</label>
      </div>
      <div class="input-group">
        <input type="password" name="password" id="loginPassword" required>
        <label for="loginPassword">Password</label>
      </div>
      <div class="input-group">
        <input type="password" name="confirmPassword" id="loginCPassword" required>
        <label for="loginCPassword">Confirm Password</label>
      </div>
      <div class="input-group">
        <input type="date" name="DOB" id="loginDOB" required>
        <label for="loginDOB">Date of Birth</label>
      </div>
      <input type="submit" name="submit" value="Sign Up" class="submit-btn">
      <br>
      <span class="mssg">Already Have an account? <a href="login.php">Log In</a> </span>
    </form>
  </div>
</body>
</html>
